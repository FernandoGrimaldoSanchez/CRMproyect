<?php

/**
 * @component Encrypt Configuration component
 * @author Ratmil Torres
 * @copyright (C) Ratmil Torres
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die('Restricted access');

class TableControl extends JTable
{
	var $control_key = null;
	var $description = null;
	var $form_id = null;
	var $form_name = null;
	var $control_id = null;
	var $control_name = null;
	var $encrypt_empty = null;
	var $control_minlength = null;
	var $option_filter = null;
	var $view_filter = null;
	var $show_signal = null;
	var $insertSubmitBefore = null;
	var $enabled = null;
	var $insertBeforeOnSubmit = null;
	var $backEnd = null;
	var $frontEnd = null;

	function __construct(&$db)
	{
		parent::__construct( '#__encrypt_controls', 'control_key', $db );
	}
}
?>