<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	5.10.13
 * @author	acyba.com
 * @copyright	(C) 2009-2020 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');
?><div id="acy_content">
	<script type="text/javascript">
		function displayDetails(detailsDivID){

			var oldDisplay = document.getElementById(detailsDivID).style.display;

			document.getElementById('userStatisticDetails').style.display = "none";
			document.getElementById('newsletterStatisticDetails').style.display = "none";
			document.getElementById('listStatisticDetails').style.display = "none";

			if(oldDisplay == 'block'){
				document.getElementById(detailsDivID).style.display = 'none';
			}else{
				document.getElementById(detailsDivID).style.display = 'block';
			}
		}

		(function(){
			window.onload = function(){
				var circles = document.querySelectorAll('.acyprogress');
				for(var i = 0; i < 3; i++){
					var totalProgress = circles[i].querySelector('circle').getAttribute('stroke-dasharray');
					var progress = circles[i].parentNode.getAttribute('data-percent');
					circles[i].querySelector('.bar').style['stroke-dashoffset'] = totalProgress * progress / 100;
				}
			}
		})();
	</script>

	<div id="dashboard_mainview">

		<?php
		if(!empty($this->contentToDisplay) && $this->config->get('dashboardnews', 0) < strtotime($this->contentToDisplay->date)){
			$toggleHelper = acymailing_get('helper.toggle');
			$notremind = '<small style="float:right;margin-right:30px;position:relative;">' . $toggleHelper->delete('acydashboard_specialcontent', 'dashboardnews_'.strtotime($this->contentToDisplay->date), 'config', false, acymailing_translation('DONT_REMIND')) . '</small>';

			echo '<div class="acydashboard_specialcontent onelineblockoptions" id="acydashboard_specialcontent">'.$notremind;
			if(!empty($this->contentToDisplay->title)) echo '<span class="acyblocktitle">'.$this->contentToDisplay->title.'</span>';
			if (strtoupper($this->contentToDisplay->type) == 'URL') {
				$height = !empty($this->contentToDisplay->height) ? $this->contentToDisplay->height : 'auto';
				echo '<iframe frameborder="0" src="' . $this->contentToDisplay->content . '" width="100%" height="' . $height . '" scrolling="auto"></iframe>';
			} else {
				echo $this->contentToDisplay->content;
			}
			echo '</div>';
		}
		include(dirname(__FILE__).DS.'stats.php');
		?>

		<!-- dashboard progress bar -->
		<div id="dashboard_progress">
			<!-- progress bar -->
			<div class="acydashboard_progressbar">
				<table width="100%">

					<tr>
						<td width="25%" class="acydashboard_plane1 <?php echo(!empty($this->progressBarSteps->listCreated) ? 'acystepdone' : ''); ?>" height="36"></td>
						<td width="25%" class="acydashboard_plane2 <?php echo(!empty($this->progressBarSteps->contactCreated) ? 'acystepdone' : ''); ?>" height="36"></td>
						<td width="25%" class="acydashboard_plane3 <?php echo(!empty($this->progressBarSteps->newsletterCreated) ? 'acystepdone' : ''); ?>" height="36"></td>
						<td width="25%" class="acydashboard_plane4 <?php echo(!empty($this->progressBarSteps->newsletterSent) ? 'acystepdone' : ''); ?>" height="36"></td>

					</tr>
					<tr class="acydashboard_progressbar_colors">
						<td width="25%" height="3" class="acydashboard_progress1"><span class="<?php echo(!empty($this->progressBarSteps->listCreated) ? 'acystepdone' : ''); ?>"></span></td>
						<td width="25%" height="3" class="acydashboard_progress2"><span class="<?php echo(!empty($this->progressBarSteps->contactCreated) ? 'acystepdone' : ''); ?>"></span></td>
						<td width="25%" height="3" class="acydashboard_progress3"><span class="<?php echo(!empty($this->progressBarSteps->newsletterCreated) ? 'acystepdone' : ''); ?>"></span></td>
						<td width="25%" height="3" class="acydashboard_progress4"><span class="<?php echo(!empty($this->progressBarSteps->newsletterSent) ? 'acystepdone' : ''); ?>"></span></td>
					</tr>
				</table>
			</div>

			<!-- progress steps -->
			<div class="acydashboard_progress_steps">
				<a href="<?php echo acymailing_completeLink('list'); ?>">
					<div class="acydashboard_progress_block acydashboard_step1">
						<div class="step_image"></div>
						<div class="step_info"><span class="step_title"><?php echo acymailing_translation('MAILING_LISTS'); ?></span><?php echo acymailing_translation('ACY_MAILING_LIST_STEP_DESC'); ?></div>
					</div>
				</a>

				<a href="<?php echo acymailing_completeLink('subscriber'); ?>">
					<div class="acydashboard_progress_block acydashboard_step2">
						<div class="step_image"></div>
						<div class="step_info"><span class="step_title"><?php echo acymailing_translation('ACY_CONTACTS'); ?></span><?php echo acymailing_translation('ACY_MAILING_CONTACT_STEP_DESC'); ?>                        </div>
					</div>
				</a>

				<a href="<?php echo acymailing_completeLink('newsletter'); ?>">
					<div class="acydashboard_progress_block acydashboard_step3">
						<div class="step_image"></div>
						<div class="step_info"><span class="step_title"><?php echo acymailing_translation('NEWSLETTERS'); ?></span><?php echo acymailing_translation('ACY_MAILING_NEWSLETTER_STEP_DESC'); ?>                        </div>
					</div>
				</a>

				<a href="<?php echo acymailing_completeLink('queue'); ?>">
					<div class="acydashboard_progress_block acydashboard_step4">
						<div class="step_image"></div>
						<div class="step_info"><span class="step_title"><?php echo acymailing_translation('SEND_PROCESS'); ?></span><?php echo acymailing_translation('ACY_MAILING_SEND_PROCESS_STEP_DESC'); ?></div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>

