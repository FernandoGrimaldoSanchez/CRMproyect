<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	5.10.13
 * @author	acyba.com
 * @copyright	(C) 2009-2020 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');
?><?php

class FieldsController extends acymailingController{
	var $pkey = 'fieldid';
	var $table = 'fields';
	var $groupMap = '';
	var $groupVal = '';

	function listing(){
		if(!acymailing_level(3)){
			$acyToolbar = acymailing_get('helper.toolbar');
			$acyToolbar->setTitle(acymailing_translation('EXTRA_FIELDS'), 'fields');
			$acyToolbar->help('customfields');
			$acyToolbar->display();
            echo '<div style="margin: 1rem;">This feature is available in AcyMailing Enterprise</div>';
			return;
		}

		return parent::listing();
	}

}

