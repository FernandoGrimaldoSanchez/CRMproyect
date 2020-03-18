<?php
/**
 * @component Pay per Download component
 * @author Ratmil Torres
 * @copyright (C) Ratmil Torres
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class com_encrypt_configurationInstallerScript
{
	/**
	 * Constructor
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	public function __constructor(JAdapterInstance $adapter)
	{
	}

	/**
	 * Called before any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($route, JAdapterInstance $adapter)
	{
		return true;
	}

	/**
	 * Called after any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($route, JAdapterInstance $adapter)
	{
		return true;
	}

	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function install(JAdapterInstance $adapter)
	{
		$this->updatePlugins();
		return true;
	}

	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function update(JAdapterInstance $adapter)
	{
		$this->updatePlugins();
		$this->recreateTables();
		return true;
	}

	/**
	 * Called on uninstallation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	public function uninstall(JAdapterInstance $adapter)
	{
		$this->uninstallPlugins();
		return true;
	}
	
	function recreateTables()
	{
		$db = JFactory::getDBO();
		$db->setQuery("DROP TABLE IF EXISTS `#__encrypt_keys`");
		$db->query();
		$db->setQuery("DROP TABLE IF EXISTS `#__encrypt_gendata`");
		$db->query();
		$query = "CREATE TABLE `#__encrypt_keys` (
		  `keys_id` int(11) NOT NULL auto_increment,
		  `algorithm` tinyint(3) NOT NULL default '1',
		  `private_key` text NOT NULL,
		  `e` text NOT NULL,
		  `n` text NOT NULL,
		  `d` int NULL, `m` int NULL,
		  `e10` int NULL,
		  `d10` int NULL,
		  `m10` int NULL,
		  `random_des` tinyint(3) NOT NULL default '1',
		  `des_key` varchar(255) NOT NULL,
		  `encrypted_key` tinyint(3) NOT NULL default '0',
		  `gen_time` datetime NULL,
		  PRIMARY KEY  (`keys_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$db->setQuery($query);
		$db->query();
		$query = "CREATE TABLE `#__encrypt_gendata` (
			  gen_key int(11) NOT NULL auto_increment,
			  gen_data text NULL,
			  PRIMARY KEY  (`gen_key`)
			) ENGINE=MyISAM;";
		$db->setQuery($query);
		$db->query();
		
		$query = "INSERT INTO #__encrypt_keys(algorithm, private_key, e, n, des_key, gen_time)
			VALUES(2, 
				'-----BEGIN RSA PRIVATE KEY-----\r\nMIICXAIBAAKBgQCreTknt5KE5RKJJMKYcO8bxm9KRsuNGhbMpsFQU7r//7XxO9Z5TsOJWK4BZtGl\r\nQUWR+uqAYnxDgs/BMwPIkTXw4sxn8BZ+5JepLXSa0iDxHDVAfKZgYZeTU7U0wqRYKSa0f2y6gRYE\r\nzUXQzwC30XSnLLTO7UzcDslnljENmXyCowIDAQABAoGAA719qymcZwyuFlK4ceXIuWTfKZIYv4ep\r\npqYegleJNStJNy1UdMnshvLpvLsW6JFfaJs+ATXkuv4/9NldhELyl7jTRcZbg/Ee7mYIebt1BjLe\r\ngqkVQxBx2MX2O5nn/0BmBxBP+pdOhS0BA1R9Uo05vhF1R+vDDXBr35FvxJpdfNECQQDnacEamxI8\r\n40zryHmRo8kwDnsD2cXdDJ9mBtxg1qPsYEbuT4MBGYXYfJFT+IgXJZuesvCO9SbkWuMW/E8A65jT\r\nAkEAvbEpc71z4jKzTCvbx4/AsypZBSAHuML3i1zwwd1BjZTUHvDSRD30QGpGGzHn0S3FxAcsWgyi\r\nuY2XJ9e0GIFM8QJASDaNJuNLPqrjnxRRM2x75L4wDxSPFRrSRwFPFf0E7Edi+wze4aH4TYUZyK1e\r\nsnJu7IgEX2gK+emOweZ8NNpQNwJAIbYddstBj/6QrMXSnkmm5nBtN6L0nFpR4fuXceyfXMkJVaJY\r\ny/XytYvtf6HD4AHxdqALuskqFi3aoiMMh5pbEQJBAIu4dl1IcAweENEoIdaJvG/RshMNoGI7kDUy\r\ngiijOCCt6xjBUucVFVftbBrDQYzvX+/ZCxUSlQX7BHR5hKu8/4Q=\r\n-----END RSA PRIVATE KEY-----', 
				'10001', 
				'ab793927b79284e5128924c29870ef1bc66f4a46cb8d1a16cca6c15053baffffb5f13bd6794ec38958ae0166d1a5414591faea80627c4382cfc13303c89135f0e2cc67f0167ee497a92d749ad220f11c35407ca66061979353b534c2a4582926b47f6cba811604cd45d0cf00b7d174a72cb4ceed4cdc0ec96796310d997c82a3', 
				'534656jdsf787GERT453', '2000-05-22 09:19:35');";
		$db->setQuery($query);
		$db->query();
	}
	
	function uninstallPlugins()
	{
		$this->uninstall_plugin('encrypt', 'system', 'encrypt');
		
	}
	
	function install_plugin($component, $element, $folder = 'system', $extra_folders = null, $extra_files = null, $language_files = null)
	{
		$this->uninstall_plugin($element, $folder, $extra_folders);
		$db = JFactory::getDBO();
		$name = $folder . ' - ' . $element;
		$e_name = $db->escape($name);
		$e_element = $db->escape($element);
		$e_folder = $db->escape($folder);
		$version = new JVersion;
		if($version->RELEASE >= "1.6")
		{
			$result = true;
		
			$dest_folder = JPATH_SITE.'/'.'plugins'.'/'.$folder.'/'.$element;
			$dest_file_php = JPATH_SITE.'/'.'plugins'.'/'.$folder.'/'.$element.'/'.$element.'.php';
			$dest_file_xml = JPATH_SITE.'/'.'plugins'.'/'.$folder.'/'.$element.'/'.$element.'.xml';

			if(!JFolder::exists($dest_folder))
			{
				JFolder::create($dest_folder);
			}
			if(is_array($extra_folders))
			{
				foreach($extra_folders as $extra_folder)
				{
					$new_folder = JPATH_ADMINISTRATOR.'/components/'.$component.'/extensions/plugins/'.$folder.'/'.$element.'/'.$extra_folder;
					if(!JFolder::copy($new_folder, $dest_folder . "/" . $extra_folder))
					{
						echo "Error copying folder ($new_folder) to ($dest_folder) folder<br/>";
						$result = false;
					}
				}
			}
			
			$file_php = JPATH_ADMINISTRATOR.'/components/'.$component.'/extensions/plugins/'.$folder.'/'.$element.'/'.$element.'.php';
			if(!JFile::exists($file_php) || !JFile::copy($file_php, $dest_file_php))
			{
				echo "Error copying file ($file_php) to ($dest_file_php)<br/>";
				$result = false;
			}
			$file_xml = JPATH_ADMINISTRATOR.'/components/'.$component.'/extensions/plugins/'.$folder.'/'.$element.'/'.$element.'.xml';
			if(!JFile::exists($file_xml) || !JFile::copy($file_xml, $dest_file_xml))
			{
				echo "Error copying file ($file_xml) to ($dest_file_xml)<br/>";
				$result = false;
			}
			
			if($extra_files)
			{
				foreach($extra_files as $extra_file)
				{
					$source_file = JPATH_ADMINISTRATOR.'/components/'.$component.'/extensions/plugins/'.$folder.'/'.$element.'/'.$extra_file;
					$dest_file = JPATH_SITE.'/plugins/'.$folder.'/'.$element.'/'.$extra_file;
					if(!JFile::exists($source_file) || !JFile::copy($source_file, $dest_file))
					{
						echo "Error copying file ($source_file) to ($dest_file)<br/>";
						$result = false;
					}
				}
			}
			
			if($language_files)
			{
				foreach($language_files as $language_file)
				{
					$dot_pos = strpos($language_file, ".");
					if($dot_pos !== false)
					{
						$language = substr($language_file, 0, $dot_pos);
						$source_file = JPATH_ADMINISTRATOR.'/components/'.$component.'/extensions/plugins/'.$folder.'/'.$element.'/'.$language_file;
						$dest_file = JPATH_ADMINISTRATOR.'/language/'.$language.'/'.$language_file;
						if(JFile::exists($source_file) && JFolder::exists(JPATH_ADMINISTRATOR.'/language/'.$language))
						{
							JFile::copy($source_file, $dest_file);
						}
					}
				}
			}
			
			$query = "INSERT INTO #__extensions(name, type, element, folder, enabled, access) 
				VALUES('$e_name', 'plugin', '$e_element', '$e_folder', 1, 1)";
			$db->setQuery($query);
			if(!$db->query())
			{
				echo "Error inserting plugin record<br/>";
				$result = false;
			}
			if(!$result)
				$this->uninstall_plugin($element, $folder );
			return false;
		}
	}
	
	function uninstall_plugin($element, $folder = 'system', $extra_folders = null, $extra_files = null, $language_files = null)
	{
		$db = JFactory::getDBO();
		$e_element = $db->escape($element);
		$e_folder = $db->escape($folder);
		$version = new JVersion;
		if($version->RELEASE >= "1.6")
		{
			$db = JFactory::getDBO();
			$db->setQuery("DELETE FROM #__extensions WHERE element='$e_element' AND folder='$e_folder' AND type='plugin'");
			$db->query();
			$dest_folder = JPATH_SITE.'/plugins/'.$folder.'/'.$element;
			if(JFolder::exists($dest_folder))
			{
				JFolder::delete($dest_folder);
			}
			if($language_files)
			{
				foreach($language_files as $language_file)
				{
					$dot_pos = strpos($language_file, ".");
					if($dot_pos !== false)
					{
						$language = substr($language_file, 0, $dot_pos);
						$dest_file = JPATH_ADMINISTRATOR.'/language/'.$language.'/'.$language_file;
						if(JFile::exists($dest_file))
						{
							JFile::delete($dest_file);
						}
					}
				}
			}
		}
	}
	
	function updatePlugins()
	{
		$this->uninstall_plugin('encrypt', 'system', null, null, array('en-GB.plg_system_encrypt.ini', 'es-ES.plg_system_encrypt.ini'));
		$this->install_plugin('com_encrypt_configuration', 'encrypt', 'system', array('encrypt'), null, array('en-GB.plg_system_encrypt.ini', 'es-ES.plg_system_encrypt.ini'));
	}

}
?>