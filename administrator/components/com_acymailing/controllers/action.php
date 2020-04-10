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

class ActionController extends acymailingController{

	var $pkey = 'action_id';
	var $table = 'action';
	var $aclCat = 'distribution';

	function listing(){
		$actionColumns = acymailing_getColumns('#__acymailing_action');
		if(empty($actionColumns['senderfrom'])){
			acymailing_query("ALTER TABLE #__acymailing_action ADD `senderfrom` tinyint NOT NULL DEFAULT 0");
		}
		if(empty($actionColumns['senderto'])){
			acymailing_query("ALTER TABLE #__acymailing_action ADD `senderto` tinyint NOT NULL DEFAULT 0");
		}
		if(empty($actionColumns['delete_wrong_emails'])){
			acymailing_query("ALTER TABLE #__acymailing_action ADD `delete_wrong_emails` tinyint NOT NULL DEFAULT 0");
		}

		if(!acymailing_level(3)){
			$acyToolbar = acymailing_get('helper.toolbar');
			$acyToolbar->setTitle(acymailing_translation('ACY_DISTRIBUTION'), 'action');
			$acyToolbar->help('distributionlists#listing');
			$acyToolbar->display();
            echo '<div style="margin: 1rem;">This feature is available in AcyMailing Enterprise</div>';
			return;
		}

		return parent::listing();
	}

}

