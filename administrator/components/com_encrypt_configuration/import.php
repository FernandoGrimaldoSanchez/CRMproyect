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

class XmlImportControls
{
	var $errorCount = 0;
	var $successCount = 0;
	var $errorMsg = "";
	
	function endElement($parser, $name) 
	{
	}
	
	function deletePreviousElement($formId, $formName, $controlId, $controlName)
	{
		$db =& JFactory::getDBO();
		$formId = $db->escape($formId);
		$formName = $db->escape($formName);
		$controlId = $db->escape($controlId);
		$controlName = $db->escape($controlName);
		$checkNull1 = $checkNull2 = $checkNull3 = $checkNull4 = '';
		if($formId == '')
			$checkNull1 = ' OR form_id IS NULL';
		if($formName == '')
			$checkNull2 = ' OR form_name IS NULL';
		if($controlId == '')
			$checkNull3 = ' OR control_id IS NULL';
		if($controlName == '')
			$checkNull4 = ' OR control_name IS NULL';
		$query = "DELETE FROM #__encrypt_controls 
			WHERE 
				(form_id = '$formId' $checkNull1) AND 
				(form_name = '$formName' $checkNull2) AND 
				(control_id = '$controlId' $checkNull3) AND 
				(control_name = '$controlName' $checkNull4)";
		$db->setQuery($query);
		$db->query();
	}
	
	function startElement($parser, $name, $attrs)
	{
		if($name == "CONTROL")
		{
			$fields = array(
				"DESCRIPTION", 
				"FORM_ID", 
				"FORM_NAME",  
				"CONTROL_ID" ,
				"CONTROL_NAME", 
				"ENCRYPT_EMPTY",
				"CONTROL_MINLENGTH",
				"OPTION_FILTER",
				"VIEW_FILTER",
				"INSERTSUBMITBEFORE" ,
				"INSERTBEFOREONSUBMIT" ,
				"BACKEND",
				"FRONTEND");
			$numeric = array(
				"ENCRYPT_EMPTY",
				"CONTROL_MINLENGTH",
				"INSERTBEFOREONSUBMIT" ,
				"BACKEND",
				"FRONTEND",
				"SHOW_SIGNAL");
			$boolean = array(
				"ENCRYPT_EMPTY",
				"INSERTBEFOREONSUBMIT" ,
				"BACKEND",
				"FRONTEND",
				"SHOW_SIGNAL"); 
			foreach($numeric as $field)
			{
				if(!array_key_exists($field, $attrs))
					$attrs[$field] = 0;
				if(!preg_match("/^\\s*\\d+\\s*$/", $attrs[$field]))
				{
					$this->errorCount++;
					$this->errorMsg .= 
						JText::sprintf("ENCRYPT_IMPORT_INVALID_INT_FORMAT_75",
							$field)."<br/>";
					return;
				}
			}
			foreach($boolean as $field)
			{
				if(!array_key_exists($field, $attrs))
					$attrs[$field] = 0;
				if(!preg_match("/^\\s*[0-1]\\s*$/", $attrs[$field]))
				{
					$this->errorCount++;
					$this->errorMsg .= 
						JText::sprintf("ENCRYPT_IMPORT_INVALID_BOOLEAN_FORMAT_76",
							$field)."<br/>";
					return;
				}
			}
			if($attrs["CONTROL_NAME"])
			{
				$this->deletePreviousElement($attrs["FORM_ID"], $attrs["FORM_NAME"], $attrs["CONTROL_ID"], $attrs["CONTROL_NAME"]);
				$db =& JFactory::getDBO();
				$sql = "INSERT INTO #__encrypt_controls (";
				$values = "";
				foreach($fields as $field)
				{
					$sql .= $field . ", ";
					$value = $attrs[$field];
					$values .= "'". $db->escape($value). "' ,";
				}
				$sql = substr($sql, 0, strlen($sql) - 2);
				$sql .= ")";
				$values = substr($values, 0, strlen($values) - 2);
				$sql .= " VALUES(" . $values. ")";
				$db->setQuery($sql);
				$result = $db->query();
				if(!$result)
				{
					$this->errorCount++;
					$this->errorMsg .= $db->stderr()."<br/>";
				}
				else
					$this->successCount++;
			}
			else
			{
				$this->errorCount++;
				$this->errorMsg .= JText::_("ENCRYPT_IMPORT_REQUIRED_FIELDS_78");
			}
		}
	}
	
	function import($file)
	{
		jimport('joomla.filesystem.file');
		$config =& JFactory::getConfig();
		$tmp_dest 	= $config->get('tmp_path').'/'.$file['name'];
		$tmp_src	= $file['tmp_name'];
		$uploaded = JFile::upload($tmp_src, $tmp_dest);
		$this->errorCount = 0;
		$this->errorMsg = "";
		$this->successCount = 0;
		$ext = JFile::getExt(strtolower($tmp_dest));
		if($ext == "xml")
			return $this->importFromXml($tmp_dest);
		else
			return $this->importFromZip($tmp_dest);
	}
	
	function importFromZip($filePath)
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.archive');
		jimport('joomla.filesystem.folder');
		$extractDir = JPATH_ROOT.'/tmp/extract';
		if(JFolder::exists($extractDir))
			JFolder::delete($extractDir);
		$result = JArchive::extract($filePath, $extractDir);
		if($result === false)
			return false;
		$files = JFolder::files($extractDir, '.', true, true);
		foreach($files as $file)
		{
			$ext = JFile::getExt(strtolower($file));
			if($ext == 'xml')
				$this->importFromXml($file);
		}
		if(JFolder::exists($extractDir))
			JFolder::delete($extractDir);
		return $this->errorCount == 0;
	}
	
	function importFromXml($filePath)
	{
		$xml_parser = xml_parser_create(); 
		xml_set_object($xml_parser, $this);
		xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true); 
		xml_set_element_handler($xml_parser, "startElement", "endElement"); 
		if (!($fp = @fopen($filePath, "r"))) { 
			return false;
		} 

		while ($data = @fread($fp, 4096)) { 
			if (!xml_parse($xml_parser, $data, feof($fp))) { 
				$this->errorMsg .= (sprintf("XML error: %s at line %d", 
				   xml_error_string(xml_get_error_code($xml_parser)), 
				   xml_get_current_line_number($xml_parser))) . "<br/>";
				return false;   
			} 
		} 
		xml_parser_free($xml_parser); 
		return $this->errorCount == 0;
	}
}

?>