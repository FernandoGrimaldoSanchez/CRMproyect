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

class UpdateController extends acymailingController{

	function __construct($config = array()){
		parent::__construct($config);
		$this->registerDefaultTask('update');
	}

	function listing(){
		return $this->update();
	}

	function install(){
		acymailing_increasePerf();

		$newConfig = new stdClass();
		$newConfig->installcomplete = 1;
		$config = acymailing_config();

		$updateHelper = acymailing_get('helper.update');

		if(!$config->save($newConfig)){
			$updateHelper->installTables();
			return;
		}

		$updateHelper->installLanguages();
		$updateHelper->initList();
		$updateHelper->installTemplates();
		$updateHelper->installNotifications();
		$updateHelper->installFields();
		$updateHelper->installMenu();
		$updateHelper->installExtensions();
		$updateHelper->installBounceRules();
		$updateHelper->fixDoubleExtension();
		$updateHelper->addUpdateSite();
		$updateHelper->fixMenu();

		if(ACYMAILING_J30) acymailing_moveFile(ACYMAILING_BACK.'acymailing_j3.xml', ACYMAILING_BACK.'acymailing.xml');

		$acyToolbar = acymailing_get('helper.toolbar');
		$acyToolbar->setTitle('AcyMailing', 'dashboard');
		$acyToolbar->display();

        echo '<div id="acymailing_div"></div>';
		acymailing_display(acymailing_translation('ACY_SUCCESSFULLY_INSTALLED'));
	}

	function update(){

		$config = acymailing_config();
		if(!acymailing_isAllowed($config->get('acl_config_manage', 'all'))){
			acymailing_display(acymailing_translation('ACY_NOTALLOWED'), 'error');
			return false;
		}

		$acyToolbar = acymailing_get('helper.toolbar');
		$acyToolbar->setTitle(acymailing_translation('UPDATE_ABOUT'), 'update');
		$acyToolbar->link(acymailing_completeLink('dashboard'), acymailing_translation('ACY_CLOSE'), 'cancel');
		$acyToolbar->display();

        acymailing_display(acymailing_translation('ACY_SUCCESSFULLY_INSTALLED'));
	}

	function checkForNewVersion(){

		$config = acymailing_config();
		ob_start();
        $url = ACYMAILING_UPDATEURL.'loadUserInformation';
        $paramsForLicenseCheck = array(
            'component' => 'acymailing', // Know which product to look at
            'level' => strtolower($config->get('level', 'starter')), // Know which version to look at
            'domain' => rtrim(ACYMAILING_LIVE, '/'), // Tell the user if the automatic features are available for the current installation
            'version' => $config->get('version'), // Tell the user if a newer version is available
            'cms' => ACYMAILING_CMS_SIMPLE, // We may delay some new Acy versions depending on the CMS
            'cmsv' => ACYMAILING_CMSV, // Acy isn't available for some versions
		);

        foreach ($paramsForLicenseCheck as $param => $value) {
            $url .= '&'.$param.'='.urlencode($value);
        }

		$userInformation = acymailing_fileGetContent($url, 30);
		$warnings = ob_get_clean();
		$result = (!empty($warnings) && acymailing_isDebug()) ? $warnings : '';

		if(empty($userInformation) || $userInformation === false){
			echo json_encode(array('content' => '<br/><span style="color:#C10000;">Could not load your information from our server</span><br/>'.$result));
			exit;
		}

		$decodedInformation = json_decode($userInformation, true);

		$newConfig = new stdClass();
		$newConfig->latestversion = $decodedInformation['latestversion'];
		$newConfig->expirationdate = $decodedInformation['expiration'];
		$newConfig->lastlicensecheck = time();
		$config->save($newConfig);

		$menuHelper = acymailing_get('helper.acymenu');
		$myAcyArea = $menuHelper->myacymailingarea();

		echo json_encode(array('content' => $myAcyArea));
		exit;
	}

	function acysms(){
		acymailing_redirect('index.php?option=com_acysms');
	}
}

