<?php
/**
 * @component Encrypt Configuration component
 * @author Ratmil Torres
 * @copyright (C) Ratmil Torres
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

define("USE_DATABASE", true);

class plgPwdEncryptControl
{
	var $formid;
	var $formName;
	var $controlId;
	var $controlName;
}


/**
 * Joomla! RSA Encryption plugin
 *
 * @package		Joomla
 * @subpackage	System
 */
 
class  plgSystemEncrypt extends JPlugin
{
	
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	* Generates javascript code to setup configuration variables
	*/
	function renderControlVars($controls)
	{
		$scripts = "<script type=\"text/javascript\">\r\n";
		$scripts .= "var plgEncrypt_controls = new Array();\r\n";
		$scripts .= "var plgEncrypt_control;\r\n";
		foreach($controls as $control)
		{
			if($control->found)
			{
				$scripts .= "plgEncrypt_control = new Object();\r\n";
				$scripts .= "plgEncrypt_control.formid = '".addslashes($control->formid)."';\r\n";
				$scripts .= "plgEncrypt_control.formName = '".addslashes($control->formName)."';\r\n";
				$scripts .= "plgEncrypt_control.controlId = '".addslashes($control->controlId)."';\r\n";
				$scripts .= "plgEncrypt_control.controlName = '".addslashes($control->controlName)."';\r\n";
				$scripts .= "plgEncrypt_control.encryptEmpty = ".($control->encryptEmpty ? 1 : 0).";\r\n";
				$scripts .= "plgEncrypt_control.minLength = ".addslashes($control->minLength).";\r\n";
				$scripts .= "plgEncrypt_control.showSignal = ".($control->showSignal ? 1 : 0).";\r\n";
				$scripts .= "plgEncrypt_control.encrypted = false;\r\n";
				$scripts .= "plgEncrypt_controls.push(plgEncrypt_control);\r\n";
			}
		}
		$lang = JFactory::getLanguage();
		$lang->load('plg_system_encrypt', JPATH_SITE.'/administrator');
		$scripts .= "var plgEncrypt_EncryptedSignal = '" . JText::_("ENCRYPT_ENCRYPTED", true) . "';\r\n";
		$scripts .= "</script>\r\n";
		return $scripts;
	}
	
	function getBackLink()
	{
		$lang = JFactory::getLanguage();
		$lang->load('plg_encrypt', JPATH_SITE.'/administrator');
		$back_link_text = JText::_("ENCRYPT_BACKLINK_TEXT");
		$html = "<div style=\"text-align:center; font-size: 10px;\">" . 
			htmlspecialchars($back_link_text) . 
			"&nbsp;<a href=\"http://www.ratmilwebsolutions.com\">ratmilwebsolutions.com</a></div>";
		return $html;	
	}
	
	function getDisableLink()
	{
		$protocol = $_SERVER['SERVER_PROTOCOL'];
		if(strtolower(substr($protocol, 0, 5)) == 'https')
			$url = "https://";
		else
			$url = "http://";
		$url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		if(strpos($url, "?") === false)
			$url .= "?disableEncrypt=disabled";
		else
			$url .= "&amp;disableEncrypt=disabled";
		return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
	}
	
	function insertDisableEncryptionLink($body)
	{
		$mainframe = JFactory::getApplication();
		if($mainframe->isAdmin())
		{
			$user = JFactory::getUser();
			if(!$user->id)
			{
				$url = $this->getDisableLink();
				$lang = JFactory::getLanguage();
				$lang->load('plg_system_encrypt', JPATH_SITE.'/administrator');
				$disableText = JText::_("ENCRYPT_CLICK_TO_DISABLE_ENCRYPTION");
				$html = "<div><a href=\"$url\">" . htmlspecialchars($disableText) . "</a></div>";
				$body = str_replace("</body>", $html . "</body>", $body);
			}
		}
		return $body;
	}
	
	function decrypt($data, $keys)
	{
		if($keys->algorithm == 2)
		{
			require_once('encrypt/rsa.php');
			return plgEncrypt_rsa_decrypt($data, $keys->private_key);
		}
		else
		{
			require_once('encrypt/helper.php');
			require_once('encrypt/des.php');
			if($keys->random_des)
			{
				$session = JFactory::getSession();
				$keys->des_key = $session->get("deskey");
			}
			return plg_Encrypt_and_check_des($data, $keys->des_key);
		}
	}
	
	/*
	* OnAfterRoute event request parameters are decrypted and verified if needed
	*/
	function onAfterRoute()
	{
		$mainframe = JFactory::getApplication();
		$controls = $this->getControls();
		$keys = $this->getKeys();
		if(!$keys)
			return;
		$option = JRequest::getVar('option');
		$session = JFactory::getSession();
		$session_token = $session->get("formtoken");
		$session_used = false;
		foreach($controls as $control)
		{
			if(
			   (($control->backEnd != 0 && $mainframe->isAdmin()) || 
			    ($control->frontEnd != 0 && !$mainframe->isAdmin())) &&
               ($control->optionFilter == "" || 
			   $control->optionFilter == $option))
			{
				$data = JRequest::getVar('encrypted_' . 
					$control->formName . '_' . $control->formid . '_' .
					$this->removeBrackets($control->controlName) . '_' . $control->controlId);
				$formtoken = JRequest::getVar('formtoken_' . $control->formName . '_' . $control->formid);
				
				if($data && $formtoken != null && $formtoken != "" && 
					$formtoken == $session_token)
				{
					$data = $this->decrypt($data, $keys);
					if($data != null)
					{
						$pos = strpos($data, ":");
						if(is_integer($pos))
						{
							$receivedtoken = substr($data, 0, $pos);
							$data = substr($data, $pos + 1);
							if($receivedtoken == $formtoken)
							{
								$this->setVar($control->controlName, $data);
								$session_used = true;
							}
						}
					}
				}
			}
		}
		if($session_used)
		{
			$session->set("formtoken", "");
			$session->set("deskey", "");
		}
	}
	
	function setVar($controlName, $value)
	{
		$open = strpos($controlName, "[");
		if($open === false)
		{
			JFactory::getApplication()->input->post->set($controlName, $value);
			JRequest::setVar($controlName, $value);
		}
		else
		{
			$close = strpos($controlName, "]");
			if($close !== false && $close > $open && $open > 0)
			{
				$name = substr($controlName, 0, $open);
				$index = substr($controlName, $open + 1, $close - $open - 1);
				if($name && $index)
				{
					$data = JFactory::getApplication()->input->post->get($name, array(), 'array');
					$data[$index] = $value;
					JFactory::getApplication()->input->post->set($name, $data);
				}
			}
		}
	}
	
	function removeBrackets($str)
	{
		return str_replace("[", "", str_replace("]", "", $str));
	}
	
	function getToken()
	{
		$session = JFactory::getSession();
		$formtoken = $session->get("formtoken");
		if($formtoken)
			return $formtoken;
		$formtoken = "";
		//Generates random value (form token)
		for($i = 0; $i < 16; $i++)
		{
			$formtoken .= chr(rand(97, 97 + 25));
		}
		$session->set("formtoken", $formtoken);
		return $formtoken;
	}
	
	function getRandomDesKey()
	{
		$session = JFactory::getSession();
		$deskey = $session->get("deskey", "");
		if($deskey)
			return $deskey;
		$deskey = "";
		//Generates random value (des key)
		for($i = 0; $i < 32; $i++)
		{
			$alpha = rand(1, 3);
			switch($alpha)
			{
			case 1:
				$deskey .= chr(rand(97, 97 + 25));
				break;
			case 2:
				$deskey .= chr(rand(65, 65 + 25));
				break;
			default:
				$deskey .= chr(rand(48, 48 + 9));
			}
			
		}
		$session->set("deskey", $deskey);
		return $deskey;
	}
	
	function combine_matches_array($matches1, $matches2)
	{
		$matches = array();
		$c1 = count($matches1[0]);
		$c2 = count($matches2[0]);
		$i1 = 0;
		$i2 = 0;
		while($i1 < $c1 || $i2 < $c2)
		{
			$index1 = $index2 = -1;
			if($i1 < $c1)
				$index1 = $matches1[0][$i1][1];
			if($i2 < $c2)
				$index2 = $matches2[0][$i2][1];
			if($index1 >= 0 && ($index2 < 0 || $index1 < $index2))
			{
				$element = array($matches1[0][$i1][0], $matches1[0][$i1][1]);
				$i1++;
			}
			else
			{
				$element = array($matches2[0][$i2][0], $matches2[0][$i2][1]);
				$i2++;
			}
			$matches[] = $element;
		}
		return $matches;
	}
	
	/**
	* Modifica formularios y controles para que sean encriptados en javascript al envianrse la pagina
	* Modifies input controls and web forms to be encrypted before submission.
	*/
	function onAfterRender()
	{
		if(JRequest::getVar("disableEncrypt") == "disabled")
			return;
		$mainframe = JFactory::getApplication();
		$uri = JURI::root();
		$body = JResponse::getBody();
		//$body = $this->insertDisableEncryptionLink($body);
		$controls = $this->getControls();
		$keys = $this->getKeys();
		if(!$keys)
			return;
		if($keys->algorithm == 2 && !extension_loaded('bcmath'))
		{
			$body = str_replace("</body>", "<div style=\"text-align:center\">BCMath lib not installed. RSA encryption unavailable</div></body>", $body);
			JResponse::setBody($body);
			return;
		}
		$forms = array();
		$formsfound = array();
		$newformtext = "";
		$regexSubmit = '/\s*onsubmit="([^"><]*)"/i';
		$count = 0;
		$formtoken = "";
		$option = JRequest::getVar('option');
		$view = JRequest::getVar('view');
		foreach($controls as $controlkey=>$control) //Herman Peeren 100618, changed for PHP4-compatibility
		{
			if(
                (($control->backEnd != 0 && $mainframe->isAdmin()) || 
			    ($control->frontEnd != 0 && !$mainframe->isAdmin())) &&
                ($control->optionFilter == "" || 
				$control->optionFilter == $option) &&
				($control->viewFilter == "" || 
				$control->viewFilter == $view))
			{
				$controls[$controlkey]->found = false; //Herman Peeren 100618, changed for PHP4-compatibility
				$regex  = '/<\s*form(\s+[a-zA-Z0-9]+="[^"><]*")*';
				$regex2 = '/<\s*form(\s+[a-zA-Z0-9]+="[^"><]*")*';
				if($control->formName || $control->formid)
				{
					if($control->formName)
						$regex .= '\s+name="'.$control->formName.'"(\s*[a-zA-Z0-9]+="[^"><]*")*';
					if($control->formid)
						$regex .= '\s+id="'.$control->formid.'"(\s*[a-zA-Z0-9]+="[^"><]*")*';
					if($control->formid)
						$regex2 .= '\s+id="'.$control->formid.'"(\s*[a-zA-Z0-9]+="[^"><]*")*';
					if($control->formName)
						$regex2 .= '\s+name="'.$control->formName.'"(\s*[a-zA-Z0-9]+="[^"><]*")*';
				}
				$regex .= "\s*>/i";
				$regex2 .= "\s*>/i";
				//Search forms by id and or name
				$c1 = preg_match_all($regex, $body, $matches1, PREG_OFFSET_CAPTURE);
				if($regex != $regex2)
					$c2 = preg_match_all($regex2, $body, $matches2, PREG_OFFSET_CAPTURE);
				else 
				{
					$c2 = 0;
					$matches2 = array();
					$matches2[] = array();
				}
				$match_count = $c1 + $c2;
				$matches = $this->combine_matches_array($matches1, $matches2);
				$offset_sum = 0;
				for($m = 0; $m < $match_count; $m++)
				{
					$done_insert_submit_before = false;
					$count++;
					$formtext = $matches[$m][0];
					$newformtext = $formtext;
					if(strpos($formtext, "encrypt_plugin_encryptform") === false)
					{
						if($control->insertBeforeOnSubmit == 1)
						{
							//Modifies form onsubmit event to call encryption routine.
							if(1 == preg_match($regexSubmit, $formtext))
							{
								$newformtext = preg_replace($regexSubmit, ' onsubmit="encrypt_plugin_encryptform(\''.addslashes($control->formName)."', '".addslashes($control->formid).'\', this);$1"', $newformtext);
							}
							else
							{
								$newformtext = str_replace('>', ' onsubmit="encrypt_plugin_encryptform(\''.addslashes($control->formName)."', '".addslashes($control->formid).'\', this);">', $newformtext);
							}
						}
						if($formtoken == "")
							$formtoken = $this->getToken($control, $m);
						//Inserts hidden input value containing form token
						$newformtext .= "\r\n".'<input type="hidden" '.
							'name="formtoken_'.$control->formName.'_'.$control->formid.'"'. 
							' id="formtoken_'.$control->formName.'_'.$control->formid.'" '.
							'value="'.$formtoken.'"/>';
						$newformtext .= "\r\n".'<input type="hidden" '.
							'name="encrypted_'.
							$control->formName . '_' . $control->formid . '_' .
							$this->removeBrackets($control->controlName).'_'.$control->controlId.'"' . 
							' id="encrypted_'.
							$control->formName . '_' . $control->formid . '_' .
							$this->removeBrackets($control->controlName).'_'.$control->controlId.'" '.
							'value=""/>';
						//Updates changes to html output.
						$length_before = strlen($body);
						$body = substr_replace($body, $newformtext, $matches[$m][1] + $offset_sum, strlen($formtext));
						if(!$done_insert_submit_before && $control->insertSubmitBefore != "")
						{
							$done_insert_submit_before = true;
							$body = preg_replace('/(["\s;])(' . $control->insertSubmitBefore . ')/', 
								"$1{encrypt_plugin_encryptform('".addslashes($control->formName)."', '".addslashes($control->formid)."', this);$2}", $body);
						}
						$offset_sum += strlen($body) - $length_before;
						$formsfound[] = $control->formName . '>' .  $control->formid;
					}
					else
					{
						$newformtext .= "\r\n".'<input type="hidden" '.
							'name="encrypted_'.
							$control->formName . '_' . $control->formid . '_' .
							$this->removeBrackets($control->controlName).'_'.$control->controlId.'"' . 
							' id="encrypted_'.
							$control->formName . '_' . $control->formid . '_' .
							$this->removeBrackets($control->controlName).'_'.$control->controlId.'" '.
							'value=""/>';
							
						$length_before = strlen($body);
						$body = substr_replace($body, $newformtext, $matches[$m][1] + $offset_sum, strlen($formtext));
						$offset_sum += strlen($body) - $length_before;
					}					
					
					$controls[$controlkey]->found = true; //Herman Peeren 100618, changed for PHP4-compatibility
				}
				$forms[] = $control->formName . '>' .  $control->formid;
			}
		}
		//Inserts javascript code if there is something to encrypt
		if($count > 0)
		{
			$version = new JVersion;
			if($version->RELEASE == "1.5")
				$plugin_path = "plugins/system/encrypt/";
			else if($version->RELEASE >= "1.6")
				$plugin_path = "plugins/system/encrypt/encrypt/";
			else
				return;
				
			if($keys->algorithm == 2)
			{
				$scripts = "";
				$scripts .= "<script type=\"text/javascript\"  src=\"".$uri.$plugin_path."jsbn.js\"></script>";
				$scripts .= "<script type=\"text/javascript\"  src=\"".$uri.$plugin_path."prng4.js\"></script>";
				$scripts .= "<script type=\"text/javascript\"  src=\"".$uri.$plugin_path."rng.js\"></script>";
				$scripts .= "<script type=\"text/javascript\"  src=\"".$uri.$plugin_path."rsa.js\"></script>";
				$scripts .= "\r\n<script type=\"text/javascript\">";
				$scripts .= "\r\nvar plgEncrypt_rsaObject = new RSAKey();";
				$scripts .= "\r\nplgEncrypt_rsaObject.setPublic('" . addslashes($keys->n) . "', '" . addslashes($keys->e) . "');";
				$scripts .= "\r\n</script>\r\n";
				$scripts .= "<script type=\"text/javascript\"  src=\"".$uri.$plugin_path."convert203.js\"></script>";
			}
			else
			{
				if($keys->random_des)
				{
					$keys->des_key = $this->getRandomDesKey();
				}
				$scripts = "";
				$scripts = "<script type=\"text/javascript\" src=\"".$uri.$plugin_path."encryptdes.js\"></script>";
				$scripts .= "\r\n<script type=\"text/javascript\">";
				$scripts .= "\r\nvar key = null;";
				$scripts .= "\r\nkey = '" . addslashes($keys->des_key) . "';";
				$scripts .= "\r\n</script>\r\n";
			}
			$scripts .= $this->renderControlVars($controls);
			$body = str_replace("</head>", $scripts."\r\n</head>", $body);
			//$encryptConfig = JComponentHelper::getParams( 'com_encrypt_configuration' );
			//if(!$mainframe->isAdmin() && $encryptConfig->get('showbacklink', 1))
			//	$body = str_replace("</body>", $this->getBackLink() . "</body>", $body);
		}
		JResponse::setBody($body);
	}
	
	function getControls()
	{
		if(USE_DATABASE)
		{
			$controls = array();
			
			$db = JFactory::getDBO();
			$query = "SELECT * FROM #__encrypt_controls";
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			if($rows)
			{
				foreach($rows as $row)
				{
					if($row->enabled != 0)
					{
						$control = new plgPwdEncryptControl();
						$control->formid = $row->form_id;
						$control->formName = $row->form_name;
						$control->controlId = $row->control_id;
						$control->controlName = $row->control_name;
						$control->encryptEmpty = $row->encrypt_empty != 0;
						$control->minLength = $row->control_minlength;
						$control->optionFilter = $row->option_filter;
						$control->viewFilter = $row->view_filter;
						$control->showSignal = $row->show_signal;
						$control->insertSubmitBefore = $row->insertSubmitBefore;
						$control->insertBeforeOnSubmit = $row->insertBeforeOnSubmit;
						$control->backEnd = $row->backEnd;
						$control->frontEnd = $row->frontEnd;
						$control->found = false;
						$controls[] = $control;
					}
				}
				return $controls;
			}
		}
		return array();
	}
	
	function generateNewKeys($key_length)
	{
		require_once('encrypt/silentgen.php');	
		plgEncrypt_generateRSA($key_length);
	}
	
	function decryptPrivateKey($private_key)
	{
		return $private_key;
	}

	function getKeys()
	{
		if(USE_DATABASE)
		{
			$db = JFactory::getDBO();
			$query = "SELECT algorithm, private_key, e, n, des_key, random_des, 
				TO_DAYS(NOW()) - TO_DAYS(gen_time) AS age_in_days
				FROM #__encrypt_keys";
			$db->setQuery( $query );
			$keys = $db->loadObject();
			$encryptConfig =  JComponentHelper::getParams( 'com_encrypt_configuration' );
			if($keys && $encryptConfig &&
				$encryptConfig->get('autogenerate', 1) && 
				$keys->age_in_days > $encryptConfig->get('frequency', 180)) //generate a new set of keys every 6 months
			{
				$key_length = (int)$encryptConfig->get('key_length', 1024);
				if($key_length < 128 || $key_length > 2048)
					$key_length = 1024;
				$this->generateNewKeys($key_length);
			}
			return $keys;
		}
		else
		{
			$keys = new StdClass();
			if(!extension_loaded('bcmath'))
				$keys->algorithm = 1;
			else
				$keys->algorithm = 2;
			$keys->private_key = "-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCreTknt5KE5RKJJMKYcO8bxm9KRsuNGhbMpsFQU7r//7XxO9Z5TsOJWK4BZtGl
QUWR+uqAYnxDgs/BMwPIkTXw4sxn8BZ+5JepLXSa0iDxHDVAfKZgYZeTU7U0wqRYKSa0f2y6gRYE
zUXQzwC30XSnLLTO7UzcDslnljENmXyCowIDAQABAoGAA719qymcZwyuFlK4ceXIuWTfKZIYv4ep
pqYegleJNStJNy1UdMnshvLpvLsW6JFfaJs+ATXkuv4/9NldhELyl7jTRcZbg/Ee7mYIebt1BjLe
gqkVQxBx2MX2O5nn/0BmBxBP+pdOhS0BA1R9Uo05vhF1R+vDDXBr35FvxJpdfNECQQDnacEamxI8
40zryHmRo8kwDnsD2cXdDJ9mBtxg1qPsYEbuT4MBGYXYfJFT+IgXJZuesvCO9SbkWuMW/E8A65jT
AkEAvbEpc71z4jKzTCvbx4/AsypZBSAHuML3i1zwwd1BjZTUHvDSRD30QGpGGzHn0S3FxAcsWgyi
uY2XJ9e0GIFM8QJASDaNJuNLPqrjnxRRM2x75L4wDxSPFRrSRwFPFf0E7Edi+wze4aH4TYUZyK1e
snJu7IgEX2gK+emOweZ8NNpQNwJAIbYddstBj/6QrMXSnkmm5nBtN6L0nFpR4fuXceyfXMkJVaJY
y/XytYvtf6HD4AHxdqALuskqFi3aoiMMh5pbEQJBAIu4dl1IcAweENEoIdaJvG/RshMNoGI7kDUy
giijOCCt6xjBUucVFVftbBrDQYzvX+/ZCxUSlQX7BHR5hKu8/4Q=
-----END RSA PRIVATE KEY-----";
			$keys->e  = "10001";
			$keys->m = "ab793927b79284e5128924c29870ef1bc66f4a46cb8d1a16cca6c15053baffffb5f13bd6794ec38958ae0166d1a5414591faea80627c4382cfc13303c89135f0e2cc67f0167ee497a92d749ad220f11c35407ca66061979353b534c2a4582926b47f6cba811604cd45d0cf00b7d174a72cb4ceed4cdc0ec96796310d997c82a3";
			$keys->des_key = "534656jdsf787GERT453";
			return $keys;
		}
	}
}