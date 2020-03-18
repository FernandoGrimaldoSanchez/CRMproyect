<?php

/**
 * @component Encrypt Configuration component
 * @author Ratmil Torres
 * @copyright (C) Ratmil Torres
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or
die( 'Direct Access to this location is not allowed.' );

if (!JFactory::getUser()->authorise('core.manage', 'com_encrypt_configuration')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
{
	$task = JRequest::getVar( 'task', '' );
	$option = JRequest::getVar( 'option', '' );

	switch($task)
	{
		case 'controls':
			showcontrols();
			break;
		case 'keys':
			showKeys();
			break;
		case 'savecontrol':
			savecontrol();
			break;
		case 'applycontrol':
			applycontrol();
			break;
		case 'editcontrol':
			editcontrol();
			break;
		case 'newcontrol':
			newcontrol();
			break;
		case 'remove':
			delete();
			break;
		case 'publish':
			publish(1);
			break;
		case 'unpublish':
			publish(0);
			break;
		case 'gen':
			generateRSA();
			break;
		case 'doc':
			documentation();
		     	break;
		case 'import':
			import();
		default:
			showcontrols();
	}
}

function renderSubmenu()
{
	$task = JRequest::getVar("task");
	if($task == "controls" || $task == "" || $task == "cancel" || $task == "keys" ||
		$task == "doc")
	{
		JSubMenuHelper::addEntry(JText::_("CONTROLS_TO_ENCRYPT"), 
			"index.php?option=com_encrypt_configuration&task=controls",
			$task == "controls" || $task == "" || $task == "cancel");
		JSubMenuHelper::addEntry(JText::_("ENCRYPT_KEYS"), 
			"index.php?option=com_encrypt_configuration&task=keys",
			$task == "keys");
		JSubMenuHelper::addEntry(JText::_("ABOUT"), 
			"index.php?option=com_encrypt_configuration&task=doc",
			$task == "doc");
	}
}

function showcontrols()
{
	renderSubmenu();
	createToolbar();
	$mainframe = JFactory::getApplication();
	
	require_once(JPATH_COMPONENT.'/encrypt_configuration.html.php');
	
	$limit = JRequest::getVar( 'limit', $mainframe->getCfg( 'list_limit' ) );
	$limitstart = JRequest::getVar( 'limitstart', 0 );
		
	$db = JFactory::getDBO();
		
	$query = "SELECT count(*) FROM #__encrypt_controls";
	$db->setQuery( $query );
	$total = $db->loadResult();
	
	$query = "SELECT * FROM #__encrypt_controls";
	$db->setQuery( $query, $limitstart, $limit );
	$rows = $db->loadObjectList();
	
	jimport( 'joomla.html.pagination' );
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	ControlsHTML::showControls($rows, $pageNav);
}

function save()
{
	require_once(JPATH_COMPONENT.'/control.php');
	$row = JTable::getInstance( "control", "Table" );
	if($row->bind(JRequest::get('post')))
	{
		if($row->store())
		{
			return $row->control_key;
		}
	}
	return false;
}

function publish($publish)
{
	$mainframe = JFactory::getApplication();
	
	$publish = (int)$publish;
	$option = JRequest::getVar( 'option', '' );
	
	$cid = JRequest::getVar( 'cid', array(), '', 'array' );
	$db = JFactory::getDBO();
	
	if( count($cid) )
	{
		$cids = implode( ',', $cid );
		$query = "UPDATE #__encrypt_controls SET enabled = $publish WHERE control_key IN ( $cids )";
		$db->setQuery( $query );
		if ($db->query())
		{
			$msg = ($publish) ? JText::_("ENCRYPT_CONTROLS_SUCCESSFULLY_ENABLED_54") : JText::_("ENCRYPT_CONTROLS_SUCCESSFULLY_DISABLED_55");
			$mainframe->redirect("index.php?option=$option", $msg);
		}else{
			$msg = ($publish) ? JText::_("ENCRYPT_ERROR_ENABLING_CONTROLS_56") : JText::_("ENCRYPT_ERROR_DISABLING_CONTROLS_57");
			$mainframe->redirect("index.php?option=$option", $msg, "error");		
		}
	}
}

function delete()
{
	$mainframe = JFactory::getApplication();
	
	$option = JRequest::getVar( 'option', '' );
	
	$cid = JRequest::getVar( 'cid', array(), '', 'array' );
	$db = JFactory::getDBO();
	
	if( count($cid) )
	{
		$cids = implode( ',', $cid );
		$query = "DELETE FROM #__encrypt_controls WHERE control_key IN ( $cids )";
		$db->setQuery( $query );
		if ($db->query())
		{
			$msg = JText::_("ENCRYPT_CONTROLS_SUCCESSFULLY_REMOVED_58");
			$mainframe->redirect("index.php?option=$option", $msg);
		}else{
			$msg = JText::_("ENCRYPT_ERROR_DELETING_CONTROLS_59");
			$mainframe->redirect("index.php?option=$option", $msg, "error");		
		}
	}
}

function savecontrol()
{
	$mainframe = JFactory::getApplication();
	
	$option = JRequest::getVar( 'option', '' );
	
	if(save())
	{
		$msg = JText::_("ENCRYPT_DATA_SUCCESSFULLY_SAVED_60");
		$mainframe->redirect("index.php?option=$option", $msg);
	}
	else
	{
		$msg = JText::_("ENCRYPT_ERROR_SAVING_DATA_61");
		$mainframe->redirect("index.php?option=$option", $msg, "error");
	}
}

function applycontrol()
{
	$mainframe = JFactory::getApplication();
	
	$option = JRequest::getVar( 'option', '' );
	
	$id = save();
	if($id)
	{
		$msg = JText::_("ENCRYPT_DATA_SUCCESSFULLY_SAVED_62");
		$mainframe->redirect("index.php?option=$option&task=editcontrol&cid[]=".$id, $msg);
	}
	else
	{
		$msg = JText::_("ENCRYPT_ERROR_SAVING_DATA_63");
		$mainframe->redirect("index.php?option=$option", $msg, "error");
	}
}

function createToolbar()
{
	$task = JRequest::getVar( 'task', '' );
	$option = JRequest::getVar( 'option', '' );

	JHTML::_('stylesheet', 'administrator/components/$option/css/customicon.css');

	switch($task)
	{
	case 'editcontrol':
	case 'newcontrol':
		JToolBarHelper::title( JText::_('ENCRYPT_EDIT_CONTROL_TO_ENCRYPT_64'), 'encryptcube.png' );
		JToolBarHelper::save('savecontrol');
		JToolBarHelper::apply('applycontrol');
		JToolBarHelper::cancel('cancel');
		break;
	case 'doc':
		JToolBarHelper::title( JText::_('ENCRYPT_DOCUMENTATION_66'), 'encryptcube.png' );
		break;
	case 'keys':
		JToolBarHelper::title( JText::_('ENCRYPT_KEYS_GENERATION'), 'encryptcube.png' );
		if (JFactory::getUser()->authorise('core.admin', 'com_encrypt_configuration')) 
		{
			JToolBarHelper::preferences( 'com_encrypt_configuration');
		}
		break;
	default:
		if (JFactory::getUser()->authorise('core.admin', 'com_encrypt_configuration')) 
		{
			JToolBarHelper::preferences( 'com_encrypt_configuration');
		}
		JToolBarHelper::title( JText::_('ENCRYPT_CONTROLS_TO_ENCRYPT_67'), 'encryptcube.png' );
		JToolBarHelper::publishList('publish', JText::_('ENCRYPT_ENABLE_68'));
		JToolBarHelper::unpublishList('unpublish', JText::_('ENCRYPT_DISABLE_69'));
		JToolBarHelper::editList('editcontrol');
		JToolBarHelper::deleteList();
		JToolBarHelper::addNew('newcontrol');
		break;
	}
}

function editcontrol()
{
	renderSubmenu();
	createToolbar();
	require_once(JPATH_COMPONENT.'/encrypt_configuration.html.php');
	require_once(JPATH_COMPONENT.'/control.php');
	$row = JTable::getInstance( "control", "Table" );
	$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
	$row->load($cid[0]);
	ControlsHTML::editControl($row);
}

function newcontrol()
{
	renderSubmenu();
	createToolbar();
	require_once(JPATH_COMPONENT.'/encrypt_configuration.html.php');
	ControlsHTML::editControl(null);
}

function testKeys($e, $d, $m)
{
	if(!extension_loaded('bcmath'))
	{	
		return false;
	}
	if($e == 0 || $d == 0 || $m == 0)
		return false;
	require_once(JPATH_COMPONENT.'/rsa.php');
	$rsaGen = new RSAGenerator();
	$rsaGen->setPair($e, $d, $m);
	return $rsaGen->testPair();
}

function saveKeys()
{
	/*$db = JFactory::getDBO();
	$mainframe = JFactory::getApplication();
	$option = JRequest::getVar( 'option', '' );
	
	$algorithm = JRequest::getInt('algorithm', 1);
	
	$e = $d = $m = $des = $e10 = $d10 = $m10 = "";
	$random_des = 0;
	
	$keys = getKeys();
	if($keys)
	{
		$e = $keys[0];
		$d = $keys[1];
		$m = $keys[2];
		$des = $keys[3];
		$e10 = hex_to_bigint($e);
		$d10 = hex_to_bigint($d);
		$m10 = hex_to_bigint($m);
	}
	$testResult = false;
	if($algorithm == 1)
	{
		$random_des = JRequest::getInt('random_des', 0);
		$des = JRequest::getVar("des_key");
		if($random_des == 1 || strlen($des) >= 8)
		{
			$testResult = true;
		}
	}
	else if($algorithm == 2)
	{
		$new_e = JRequest::getVar('encryptkey');
		$new_m = JRequest::getVar('modulus');
		$new_d = JRequest::getVar('decryptkey', "");
		if($new_d != "")
		{
			$d = $new_d;
			$e = $new_e;
			$m = $new_m;
		}
		$e10 = hex_to_bigint($e);
		$d10 = hex_to_bigint($d);
		$m10 = hex_to_bigint($m);
			
		if($new_d != "")
			$testResult = testKeys($e10, $d10, $m10);
		else
			$testResult = true;
		
	}
	if($testResult !== false)
	{
		
		$query = "DELETE FROM #__encrypt_keys";
		$db->setQuery( $query );
		$db->query();
	
		$e = $db->escape($e);
		$d = $db->escape($d);
		$m = $db->escape($m);
		$des = $db->escape($des);
		
		$e10 = $db->escape($e10);
		$d10 = $db->escape($d10);
		$m10 = $db->escape($m10);
		
		$date = new JDate();
		$date = $date->toSql();
		$date = $db->escape($date);
		
		$query = "INSERT INTO #__encrypt_keys(algorithm, e, d, m, e10, d10, m10, des_key, random_des, gen_time) 
			VALUES($algorithm, '$e', '$d', '$m', '$e10', '$d10', '$m10', '$des', $random_des, '$date');";
		$db->setQuery( $query );
		if($db->query())
		{
			if($testResult === true)
				$mainframe->redirect("index.php?option=$option&task=keys", 
					JText::_("ENCRYPT_CONFIGURATION_SAVED_71"));
			else
				$mainframe->redirect("index.php?option=$option&task=keys", 
					JText::sprintf("ENCRYPT_RSA_KEYS_SAVED_70", $testResult));
		}
		else
			$mainframe->redirect("index.php?option=$option&task=keys", "Error saving keys", "error");
	}
	else
		$mainframe->redirect("index.php?option=$option&task=keys", "Invalid keys provided", "error");*/
}

function getKeys()
{
	$db = JFactory::getDBO();
	$query = "SELECT e, n, des_key, algorithm, gen_time, encrypted_key, random_des FROM #__encrypt_keys";
	$db->setQuery( $query );
	$keys = $db->loadRow();
	return $keys;
}

function bigint_to_hex($bigint)
{
	$result = '';
	$hexChars = '0123456789ABCDEF';
	while(bccomp($bigint, '0') > 0)
	{
		$mod = bcmod($bigint, '16');
		$result = $hexChars[(int)$mod] . $result;
		$bigint = bcdiv($bigint, 16);
	}
	return $result;
}

//Takes a string containing hexadecimal digits and returns the corresponding big integer.
//Ignores non hexadecimal digits.
function hex_to_bigint($hex)
{
	if(!extension_loaded('bcmath'))
	{
		return 0;
	}
	$result = '0';
	for($i = 0; $i < strlen($hex); $i++)
	{
		$result = bcmul($result, '16');
		if($hex[$i] >= '0' && $hex[$i] <= '9')
			$result = bcadd($result, $hex[$i]);
		else if($hex[$i] >= 'a' && $hex[$i] <= 'f')	
		{
			$result = bcadd($result, '1' . ('0' + (ord($hex[$i]) - ord('a'))));
		}
		else if($hex[$i] >= 'A' && $hex[$i] <= 'F')	
		{
			$result = bcadd($result, '1' . ('0' + (ord($hex[$i]) - ord('A'))));
		}
	}
	return $result;
}

function showKeys()
{
	renderSubmenu();
	createToolbar();
	require_once(JPATH_COMPONENT.'/encrypt_configuration.html.php');
	$keys = getKeys();
	$session = JFactory::getSession();
	$keys_generated = $session->get("keys_generated", 0);
	if($keys_generated > 0)
	{
		$session->set("keys_generated", 0);
		$mainframe = JFactory::getApplication();
		$mainframe->enqueueMessage(JText::sprintf("ENCRYPT_GENERATION_SUCCESSFUL"));
	}
	ControlsHTML::showGeneration($keys);	
}

function documentation()
{
	renderSubmenu();
	createToolbar();
	require_once(JPATH_COMPONENT.'/encrypt_configuration.html.php');
	ControlsHTML::documentation();	
}

function import()
{
	require_once(JPATH_COMPONENT. "/import.php");
	$importfile = JRequest::getVar('importxml', null, 'files', 'array' );
	$success = true;
	$msg = "";
	if ( $importfile['error'] || $importfile['size'] < 1 )
	{
		$success = false;
		$msg = JText::_("ENCRYPT_IMPORT_INVALID_IMPORT_FILE_77");
	}
	else
	{
		$importer = new XmlImportControls();
		if($importer->import($importfile))
		{
			$success = true;
			$msg = JText::sprintf("ENCRYPT_IMPORT_SUCCESSFUL_74", $importer->successCount);
		}
		else
		{
			$success = false;
			$msg = $importer->errorMsg;
		}
	}
	$mainframe = JFactory::getApplication();
	$option = JRequest::getVar( 'option', '' );
	if($success)
		$mainframe->redirect("index.php?option=$option&task=controls", $msg);
	else
		$mainframe->redirect("index.php?option=$option&task=controls", $msg, "error");
}

function generateRSA()
{
	if(!extension_loaded('bcmath'))
	{
		echo "(-1)";
		return;
	}
	$ellapsedTime = 0;
	$startTime = time();
	$finished = false;
	while($ellapsedTime < 5 && !$finished)
	{
		$finished = generateRSAPass();
		$ellapsedTime = time() - $startTime;
	}
	if($finished)
	{
		echo "(1)";
	}
	else
		echo "(0)";
	exit;
}

function trimStartingZeros($s)
{
	$i = 0;
	while($i < strlen($s) && $s[$i] === '0') $i++;
	if($i < strlen($s))
		return substr($s, $i);
	else
		return '0';
	
}

function savePair($rsaGen)
{
	$des = "";
	$keys = getKeys();
	if($keys)
		$des = $keys[3];

	$e10 = trimStartingZeros($rsaGen->getEncryption());
	$d10 = trimStartingZeros($rsaGen->getDecryption());
	$m10 = trimStartingZeros($rsaGen->getModulus());
	
	$e = trimStartingZeros(bigint_to_hex($e10));
	$d = trimStartingZeros(bigint_to_hex($d10));
	$m = trimStartingZeros(bigint_to_hex($m10));
	
	$db = JFactory::getDBO();
	$query = "DELETE FROM #__encrypt_keys";
	$db->setQuery( $query );
	if(!$db->query())
		return false;
	
	
	$e = $db->escape($e);
	$d = $db->escape($d);
	$m = $db->escape($m);
	$des = $db->escape($des);
	
	$e10 = $db->escape($e10);
	$d10 = $db->escape($d10);
	$m10 = $db->escape($m10);
	
	$date = new JDate();
	$date = $date->toSql();
	$date = $db->escape($date);
	
	$query = "INSERT INTO #__encrypt_keys(algorithm, e, d, m, e10, d10, m10, des_key, gen_time) 
					VALUES(2, '$e', '$d', '$m', '$e10', '$d10', '$m10', '$des', '$date');";
	$db->setQuery( $query );
	return $db->query();
}

function generateRSAPass()
{
	require_once(JPATH_ROOT . "/plugins/system/encrypt/encrypt/silentgen.php");
	$session = JFactory::getSession();
	$key_length = JRequest::getInt('kl', -1);
	if($key_length > 0)
	{
		$session->set("rsa_key_length", (int)$key_length);
	}
	$key_length = $session->get("rsa_key_length", 0);
	if($key_length <= 0 || $key_length > 4098)
	{
		$key_length = 128;
	}
	require_once(JPATH_ROOT . "/plugins/system/encrypt/encrypt/Math/BigInteger.php");
	require_once(JPATH_ROOT . "/plugins/system/encrypt/encrypt/Crypt/Hash.php");
	require_once(JPATH_ROOT . "/plugins/system/encrypt/encrypt/Crypt/Random.php");
	require_once(JPATH_ROOT . "/plugins/system/encrypt/encrypt/Crypt/RSA.php");
	
	$db = JFactory::getDBO();
	$db->setQuery("SELECT gen_data FROM #__encrypt_gendata LIMIT 1");
	$gen_data = $db->loadResult();
	$rsa = new Crypt_RSA();
	$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_RAW);
	$key = $rsa->createKey($key_length, 5, $gen_data);
	if($key['privatekey'])
	{
		plgEncrypt_savePair($key['privatekey'], $key['publickey']['e'], $key['publickey']['n']);
		plgEncrypt_markGenTime();
		$session->set('keys_generated', 1);
		return true;
	}
	else
	{
		$db->setQuery("DELETE FROM #__encrypt_gendata");
		$db->query();
		$gen_data = $db->escape($key["partialkey"]);
		$db->setQuery("INSERT INTO #__encrypt_gendata(gen_data) VALUES('$gen_data')");
		$db->query();
		return false;
	}
}
?>