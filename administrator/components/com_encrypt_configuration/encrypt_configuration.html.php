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

class ControlsHTML
{
	static function editControl($row)
	{
		JHTML::_('stylesheet', 'administrator/components/com_encrypt_configuration/css/admin.j16.css');
		$task = JRequest::getVar( 'task', '' );
		$option = JRequest::getVar( 'option', '' );
	?>
	    <script type="text/javascript">
		Joomla.submitbutton = function(pressbutton)
		{
			var t1 = '<?php echo JText::_("ENCRYPT_ARE_YOU_SURE_YOU_WANT_TO_DELETE_THE_SELECTED_ITEMS_1", true); ?>';
			var t2 = '<?php echo JText::_("ENCRYPT_YOU_MUST_WRITE_THE_FORM_NAME_OR_ID_2", true); ?>';
			var t4 = '<?php echo JText::_("ENCRYPT_YOU_MUST_WRITE_THE_CONTROL_NAME_3", true); ?>';
			var t5 = '<?php echo JText::_("ENCRYPT_CONTROL_MINIMUM_LENGTH_MUST_BE_A_NUMBER_BETWEEN_0_AND_50_4", true); ?>';
			switch(pressbutton)
			{
			case 'remove':
				if(!confirm(t1))
					return;
				break;
			case 'savecontrol':
			case 'applycontrol':
				if(document.adminForm.control_name.value == '')
				{
					alert(t4);
					return;
				}
				var regexp = /^[0-9]+$/;
				if(!regexp.test(document.adminForm.control_minlength.value))
				{
					alert(t5);
					return;
				}
				else
				{
					var n = parseInt(document.adminForm.control_minlength.value);
					if(n < 0 || n > 50)
					{
						alert(t5);
						return;
					}
				}
				break;
			}
			submitform(pressbutton);
		}
		
		</script>
		<form action="index.php" method="post" id="adminForm" name="adminForm">
		<fieldset class="adminform">
		<legend>
		<?php
			if($row == null)
				echo htmlspecialchars(JText::_("ENCRYPT_NEW_CONTROL_TO_ENCRYPT_5"));
			else
				echo htmlspecialchars(JText::_("ENCRYPT_EDIT_CONTROL_6"));
		?>
		</legend>
		<table class="admintable">
		<tr>
		<td width="200" class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_DESCRIPTION_7"));?>
		</td>
		<td>
		<input class="text_area" type="text" name="description" id="description" size="100" maxlength="250" value="<?php echo htmlspecialchars($row->description); ?>" />
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_ENABLED_8"));?>
		</td>
		<td>
		<?php $value = ($row!=null)? $row->enabled : 1;
		ControlsHTML::htmlRadio("enabled", $value);
		?>
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_FORM_ID_9"));?>
		</td>
		<td>
		<input class="text_area" type="text" name="form_id" id="form_id" size="50" maxlength="250" value="<?php echo htmlspecialchars($row->form_id); ?>" />
		</td>
		</tr>	
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_FORM_NAME_10"));?>
		</td>
		<td>
		<input class="text_area" type="text" name="form_name" id="form_name" size="50" maxlength="250" value="<?php echo htmlspecialchars($row->form_name); ?>" />
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_CONTROL_ID_11"));?>
		</td>
		<td>
		<input class="text_area" type="text" name="control_id" id="control_id" size="50" maxlength="250" value="<?php echo htmlspecialchars($row->control_id); ?>" />
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_CONTROL_NAME_12"));?>
		</td>
		<td>
		<input class="text_area" type="text" name="control_name" id="control_name" size="50" maxlength="250" value="<?php echo htmlspecialchars($row->control_name); ?>" />
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_ENCRYPT_WHEN_CONTROL_EMPTY_13"));?>
		</td>
		<td>
		<?php $value = ($row!=null)? $row->encrypt_empty : 1;
		ControlsHTML::htmlRadio("encrypt_empty", $value);
		?>
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_MINIMUM_CONTROL_LENGTH_14"));?>
		</td>
		<td>
		<input class="text_area" type="text" name="control_minlength" id="control_minlength" size="50" maxlength="50" 
			value="<?php if($row != null) echo htmlspecialchars($row->control_minlength); else echo "0"; ?>" />
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_OPTION_FILTER_15"));?>
		</td>
		
		<td>
		<input class="text_area" type="text" name="option_filter" id="option_filter" size="50" maxlength="250" value="<?php echo htmlspecialchars($row->option_filter); ?>" />
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_VIEW_FILTER"));?>
		</td>
		<td>
		<input class="text_area" type="text" name="view_filter" id="view_filter" size="50" maxlength="250" value="<?php echo htmlspecialchars($row->view_filter); ?>" />
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_INSERT_ENCRYPT_FORM_CODE_BEFORE_REGULAR_EXPRESSION_16"));?>
		</td>
		<td>
		<input class="text_area" type="text" name="insertSubmitBefore" id="insertSubmitBefore" size="50" maxlength="250" value="<?php echo htmlspecialchars($row->insertSubmitBefore); ?>" />
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_INSERT_ENCRYPT_FORM_CODE_ON_SUBMIT_EVENT_HANDLER_17"));?>
		</td>
		<td>
		<?php $value = ($row!=null)? $row->insertBeforeOnSubmit : 1;
		ControlsHTML::htmlRadio("insertBeforeOnSubmit", $value);
		?>
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_USE_ON_BACKEND_18"));?>
		</td>
		<td>
		<?php $value = ($row!=null)? $row->backEnd : 1;
		ControlsHTML::htmlRadio("backEnd", $value);
		?>
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_USE_ON_FRONTEND_19"));?>
		</td>
		<td>
		<?php $value = ($row!=null)? $row->frontEnd : 1;
		ControlsHTML::htmlRadio("frontEnd", $value);
		?>
		</td>
		</tr>
		<tr>
		<td class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_SHOW_SIGNAL"));?>
		</td>
		<td>
		<?php $value = ($row!=null)? $row->show_signal : 1;
		ControlsHTML::htmlRadio("show_signal", $value);
		?>
		</td>
		</tr>
		</table>
		</fieldset>
		<input type="hidden" name="control_key" value="<?php echo htmlspecialchars($row->control_key); ?>" />
		<input type="hidden" name="option" value="<?php echo htmlspecialchars($option);?>" />
		<input type="hidden" name="task" value="<?php echo htmlspecialchars($task);?>" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
	<?php
	}

	static function showControls($rows, $pageNav)
	{
		$task = JRequest::getVar( 'task', '' );
		$option = JRequest::getVar( 'option', '' );
	?>
		<script type="text/javascript">
		Joomla.submitbutton = function(pressbutton)
		{
			var t1 = '<?php echo JText::_("ENCRYPT_ARE_YOU_SURE_YOU_WANT_TO_DELETE_THE_SELECTED_ITEMS_20", true); ?>';
			switch(pressbutton)
			{
			case 'remove':
				if(!confirm(t1))
					return;
				break;
			}
			submitform(pressbutton);
		}
		
		</script>
		<table  class="adminlist" >
		<tr>
		<td>
		<form action="index.php" enctype="multipart/form-data" method="post" name="adminImportForm" id="adminImportForm">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_IMPORT_FILE_72"));?>&nbsp;&nbsp;
		<input type="file" name="importxml" />&nbsp;&nbsp;
		<input type="submit" name="import" 
			value="<?php echo htmlspecialchars(JText::_("ENCRYPT_IMPORT_73"));?>"/>
		<input type="hidden" name="option" value="<?php echo htmlspecialchars($option);?>" />
		<input type="hidden" name="task" value="import" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		</td>
		</tr>
		</table>
		<form action="index.php" method="post" name="adminForm" id="adminForm">
		<table class="table table-striped" id="adminTable">
		<thead>
		<tr>
		<th class="title" colspan="7">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_CONTROLS_TO_ENCRYPT_21"));?>
		</th>
		</tr>
		<tr>
		<th width="5%">
		<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
		</th>
		<th class="title" width="25%"><?php echo htmlspecialchars(JText::_("ENCRYPT_DESCRIPTION_22"));?></th>
		<th class="title" width="10%"><?php echo htmlspecialchars(JText::_("ENCRYPT_ENABLED_23"));?></th>
		<th class="title" width="15%"><?php echo htmlspecialchars(JText::_("ENCRYPT_FORM_ID_24"));?></th>
		<th class="title" width="15%"><?php echo htmlspecialchars(JText::_("ENCRYPT_FORM_NAME_25"));?></th>
		<th class="title" width="15%"><?php echo htmlspecialchars(JText::_("ENCRYPT_CONTROL_ID_26"));?></th>
		<th class="title" width="15%"><?php echo htmlspecialchars(JText::_("ENCRYPT_CONTROL_NAME_27"));?></th>
		</tr>
		</thead>
		<tfoot>
			<td colspan="7"><?php echo $pageNav->getListFooter(); ?></td>
		</tfoot>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++)
		{
			$row = $rows[$i];
			$row->published = $row->enabled;
			$checked = JHTML::_('grid.id', $i, $row->control_key );
			//$published	= JHTML::_('grid.published', $row, $i );
			$link = JRoute::_( 'index.php?option=' . urlencode( $option ) . '&task=editcontrol&cid[]=' . urlencode( $row->control_key ) );
			?>
			<tr class="<?php echo "row$k"; ?>">
			<td align="center">
			<?php echo $checked; ?>
			</td>
			<td>
			<a href="<?php echo $link; ?>">
			<?php echo htmlspecialchars(substr($row->description, 0, 80)); ?></a>
			</td>
			<td align="center">
			<?php //echo $published; ?>
			<?php echo JHtml::_('jgrid.published', $row->enabled, $i); ?>
			</td>
			<td nowrap>
			<?php echo htmlspecialchars(substr($row->form_id, 0, 80)); ?>
			</td>	
			<td nowrap>
			<?php echo htmlspecialchars(substr($row->form_name, 0, 80)); ?>
			</td>		
			<td nowrap>
			<?php echo htmlspecialchars(substr($row->control_id, 0, 80)); ?>
			</td>	
			<td nowrap>
			<?php echo htmlspecialchars(substr($row->control_name, 0, 80)); ?>
			</td>				
			
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<input type="hidden" name="option" value="<?php echo htmlspecialchars($option);?>" />
		<input type="hidden" name="task" value="<?php echo htmlspecialchars($task);?>" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
	<?php
	}
	
	static function showGeneration($keys)
	{
	?>
	<strong><?php echo htmlspecialchars(JText::_("ENCRYPT_KEYS_LAST_GENERATION_TIME"));?></strong>
	<?php 
		$dateformat = JText::_("ENCRYPT_DATE_TIME_FORMAT");
		$date = new JDate($keys[4]);
		echo htmlspecialchars($date->format($dateformat));
		if(method_exists($date, "diff"))
		{
			echo "&nbsp;,&nbsp;";
			echo self::getTimeDifference($date);
		}
		$option = JRequest::getVar( 'option', '' );
		$scriptPath = JUri::root() . "administrator/components/" . $option . "/gen.js";
		$document = JFactory::getDocument();
		$document->addScript($scriptPath);
		$document->addScriptDeclaration("var encrypt_gen_msg_cancelled = '". JText::_("ENCRYPT_CANCELLED_BY_USER_28", true). "'");
		$document->addScriptDeclaration("var encrypt_gen_msg_gen_error = '". JText::_("ENCRYPT_THERE_WAS_AN_ERROR_GENERATING_RSA_KEYS_CHECK_IF_BCMATH_EXTENSIONS_IS_INSTALLED_29", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_generating_prime1 = '". JText::_("ENCRYPT_GENERATING_PRIME_NUMBER_1_TRIES___30", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_generating_prime2 = '". JText::_("ENCRYPT_GENERATING_PRIME_NUMBER_2_TRIES___31", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_generating_rsa_keys = '". JText::_("ENCRYPT_GENERATING_RSA_KEY_PAIR_32", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_testing_rsa_keys = '". JText::_("ENCRYPT_TESTING_RSA_KEY_PAIR_33", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_finished = '". JText::_("ENCRYPT_FINISHED_34", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_gen_failed = '". JText::_("ENCRYPT_GENERATION_FAILED_35", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_gen_successfull = '". JText::_("ENCRYPT_GENERATION_SUCCESSFUL_KEYS_HAVE_BEEN_TESTED_AND_SAVED_ENCRYPT_AND_DECRPYT_TIME___36", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_connection_error = '". JText::_("ENCRYPT_CONNECTION_ERROR_37", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_generating = '". JText::_("ENCRYPT_GENERATING_38", true). "';");
		$document->addScriptDeclaration("var encrypt_gen_msg_invalid_key_length = '". JText::_("ENCRYPT_KEYLENGTH_MUST_BE_A_VALID_INTEGER_BETWEEN_128_AND_9048_39", true). "';");
		
		?>
		<br/><br/>
		<strong>
		<?php echo htmlspecialchars(JText::_("ENCRYPT_PUBLIC_KEY"));?>&nbsp;&nbsp;
		</strong>
		<?php echo htmlspecialchars(self::splitKey($keys[0])) . ",&nbsp;&nbsp;&nbsp;" . htmlspecialchars(self::splitKey($keys[1])); ?>
		<br/><br/>
		<strong>
		<?php echo htmlspecialchars(JText::_("ENCRYPT_KEY_LENGTH_51"));?>&nbsp;&nbsp;
		</strong>
		<input type="text" value="<?php if($keys[1]) echo strlen($keys[1]) * 4; else echo 512;?>" id="keylength" class="inputbox"/>
		<input type="button" value="<?php echo JText::_("ENCRYPT_GENERATE_52"); ?>" id="btnRSAGenerate" onclick="genRSAProcess('');"/>
		<input type="button" value="<?php echo JText::_("ENCRYPT_CANCEL_53"); ?>" id="btnRSACancel" disabled="true" onclick="cancelRSAProcess();"/>
		<div id="divRSAProgress"></div>
		<?php
	}

	static function showKeys($keys)
	{
		JHTML::_('stylesheet', 'administrator/components/com_encrypt_configuration/css/admin.j16.css');
		$task = JRequest::getVar( 'task', '' );
		$option = JRequest::getVar( 'option', '' );
		$scriptPath = "administrator/components/" . $option . "/";
		?>
	<script language="JavaScript">
	var encrypt_gen_msg_cancelled = '<?php echo JText::_("ENCRYPT_CANCELLED_BY_USER_28"); ?>';
	var encrypt_gen_msg_gen_error = '<?php echo JText::_("ENCRYPT_THERE_WAS_AN_ERROR_GENERATING_RSA_KEYS_CHECK_IF_BCMATH_EXTENSIONS_IS_INSTALLED_29"); ?>';
	var encrypt_gen_msg_generating_prime1 = '<?php echo JText::_("ENCRYPT_GENERATING_PRIME_NUMBER_1_TRIES___30"); ?>';
	var encrypt_gen_msg_generating_prime2 = '<?php echo JText::_("ENCRYPT_GENERATING_PRIME_NUMBER_2_TRIES___31"); ?>';
	var encrypt_gen_msg_generating_rsa_keys = '<?php echo JText::_("ENCRYPT_GENERATING_RSA_KEY_PAIR_32"); ?>';
	var encrypt_gen_msg_testing_rsa_keys = '<?php echo JText::_("ENCRYPT_TESTING_RSA_KEY_PAIR_33"); ?>';
	var encrypt_gen_msg_finished = '<?php echo JText::_("ENCRYPT_FINISHED_34"); ?>';
	var encrypt_gen_msg_gen_failed = '<?php echo JText::_("ENCRYPT_GENERATION_FAILED_35"); ?>';
	var encrypt_gen_msg_gen_successfull = '<?php echo JText::_("ENCRYPT_GENERATION_SUCCESSFUL_KEYS_HAVE_BEEN_TESTED_AND_SAVED_ENCRYPT_AND_DECRPYT_TIME___36"); ?>';
	var encrypt_gen_msg_connection_error = '<?php echo JText::_("ENCRYPT_CONNECTION_ERROR_37"); ?>';
	var encrypt_gen_msg_generating = '<?php echo JText::_("ENCRYPT_GENERATING_38"); ?>';
	var encrypt_gen_msg_invalid_key_length = '<?php echo JText::_("ENCRYPT_KEYLENGTH_MUST_BE_A_VALID_INTEGER_BETWEEN_128_AND_9048_39"); ?>';
	</script>
	<?php
	JHTML::script($scriptPath . "gen.js", false);
	$disableRSA = "";
	$disableDES = "";
	if($keys[4] == 1)
		$disableRSA = " disabled=\"true\" ";
	else
		$disableDES = " disabled=\"true\" ";
	$option = JRequest::getVar( 'option', '' );
	?>
	<script type="text/javascript">
	function algorithm_changed()
	{
		var algorithm_des = document.getElementById('algorithm_des');
		var algorithm_rsa = document.getElementById('algorithm_rsa');
		var des_key = document.getElementById('des_key');
		var encryptkey = document.getElementById('encryptkey');
		var decryptkey = document.getElementById('decryptkey');
		var modulus = document.getElementById('modulus');
		var keylength = document.getElementById('keylength');
		var btnRSAGenerate = document.getElementById('btnRSAGenerate');
		var btnRSACancel = document.getElementById('btnRSACancel');
		
		if(algorithm_des.checked)
		{
			des_key.disabled = false;
			encryptkey.disabled = true;
			decryptkey.disabled = true;
			modulus.disabled = true;
			keylength.disabled = true;
			btnRSAGenerate.disabled = true;
		}
		else
		{
			des_key.disabled = true;
			encryptkey.disabled = false;
			decryptkey.disabled = false;
			modulus.disabled = false;
			keylength.disabled = false;
			btnRSAGenerate.disabled = false;
		}
	}
	</script>
	<script type="text/javascript">
		Joomla.submitbutton = function(pressbutton)
		{
			if(pressbutton != 'cancel')
			{
				var t1 = '<?php echo JText::_("ENCRYPT_DES_KEY_MUST_BE_AT_LEAST_8_CHARACTERS_LONG_40", true); ?>';
				var t2 = '<?php echo JText::_("ENCRYPT_RSA_KEYS_ARE_NOT_VALID_41", true); ?>';
				var t3 = '<?php echo JText::_("ENCRYPT_ONLY_STANDARD_ASCII_CHARACTERS_FOR_DES_KEY_42", true); ?>';
				var algorithm_des = document.getElementById('algorithm_des');
				var algorithm_rsa = document.getElementById('algorithm_rsa');
				var random_des1 = document.getElementById('random_des1');
				if(algorithm_des.checked && !random_des1.checked)
				{
					var des_key = document.getElementById('des_key');
					if(des_key.value.length < 8)
					{
						alert(t1);
						return;
					}
					var regExp = /^[\u0000-\u007f]+$/;
					if(!regExp.test(des_key.value))
					{
						alert(t3);
						return;
					}
				}
				else if(algorithm_rsa.checked)
				{
					var encryptkey = document.getElementById('encryptkey');
					var decryptkey = document.getElementById('decryptkey');
					var modulus = document.getElementById('modulus');
					if(encryptkey.value == '' || modulus.value == '')
					{
						alert(t2);
						return;
					}
				}
			}
			submitform(pressbutton);
		}
		
	</script>
	<p><font size="2"><strong><?php echo JText::_("ENCRYPT_RSA_WARNING_80"); ?></strong></font></p>
	<form action="index.php" method="post" name="adminForm" id="adminForm">
	<input type="radio" name="algorithm" id="algorithm_des" value="1" onclick="algorithm_changed();"
		<?php if($keys[4] == 1) echo "checked";?> />
	<label for="algorithm_des"><?php echo JText::_("ENCRYPT_USE_DES_ALGORITHM_TO_ENCRYPT_43"); ?></label>
	<fieldset class="adminform">
	<legend>
	<?php echo htmlspecialchars(JText::_("ENCRYPT_DES_CONFIGURATION_44"));?>
	</legend>
	<table class="admintable">
	<tr>
		<td width="100" align="right" valign="top" class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_RANDOM_DES_KEY_79"));?>
		</td>
		<td>
		<?php $value = $keys[7];
		ControlsHTML::htmlRadio("random_des", $value);
		?>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" valign="top" class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_DES_KEY_45"));?>
		</td>
		<td>
		<input type="text" name="des_key" id="des_key" value="<?php echo htmlspecialchars($keys[3]);?>" <?php echo $disableDES;?> />
		</td>
	</tr>
	</table>
	</fieldset>
	<input type="radio" name="algorithm" id="algorithm_rsa" value="2" onclick="algorithm_changed();"
		<?php if($keys[4] != 1) echo "checked";?>/>
	<label for="algorithm_rsa"><?php echo JText::_("ENCRYPT_USE_RSA_ALGORITHM_TO_ENCRYPT_46"); ?></label>
	<fieldset class="adminform">
	<legend>
	<?php echo htmlspecialchars(JText::_("ENCRYPT_RSA_CONFIGURATION_47"));?>
	</legend>
	<table class="admintable">
	<tr>
		<td width="100" align="right" valign="top" class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_ENCRYPTION_EXPONENT_HEXADECIMAL_48"));?>
		</td>
		<td>
		<textarea class="text_area" name="encryptkey" id="encryptkey" cols="36" rows="6" <?php echo $disableRSA;?>><?php echo htmlspecialchars($keys[0]);?></textarea>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" valign="top" class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_DECRYPTION_EXPONENT_HEXADECIMALNOT_SHOWN_49"));?>
		</td>
		<td>
		<textarea class="text_area" name="decryptkey" id="decryptkey" cols="36" rows="6" <?php echo $disableRSA;?>></textarea>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" valign="top" class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_MODULUS_HEXADECIMAL_50"));?>
		</td>
		<td>
		<textarea class="text_area" name="modulus" id="modulus" cols="36" rows="6" <?php echo $disableRSA;?>><?php echo htmlspecialchars($keys[2]);?></textarea>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" valign="top" class="key">
		<?php echo htmlspecialchars(JText::_("ENCRYPT_GENERATION_DATE_91"));?>
		</td>
		<td>
		<?php echo htmlspecialchars($keys[5]); ?>
		</td>
	</tr>
	<tr>
	<td  width="100" align="right" valign="top" class="key">
	<?php echo htmlspecialchars(JText::_("ENCRYPT_KEY_LENGTH_51"));?>
	</td>
	<td>
	<input type="text" value="<?php if($keys[2]) echo strlen($keys[2]) * 4; else echo 512;?>" id="keylength" class="inputbox" <?php echo $disableRSA;?>/>
	<input type="button" value="<?php echo JText::_("ENCRYPT_GENERATE_52"); ?>" id="btnRSAGenerate" onclick="genRSAProcess('');" <?php echo $disableRSA;?>/>
	<input type="button" value="<?php echo JText::_("ENCRYPT_CANCEL_53"); ?>" id="btnRSACancel" disabled="true" onclick="cancelRSAProcess();" <?php echo $disableRSA;?>/>
	<div id="divRSAProgress"></div>
	</td>
	</tr>
	</table>
	</fieldset>
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="<?php echo $task;?>" />
	
	</form>
	<?php
	}

	static function documentation()
	{
		$task = JRequest::getVar( 'task', '' );
		$option = JRequest::getVar( 'option', '' );
		?>
		<form action="index.php" method="post" name="adminForm" id="adminForm">
		<fieldset class="adminform">
		<?php
		require("doc.html.php");
		?>
		</fieldset>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="<?php echo $task;?>" />
		</form>
		<?php
	}
	
	static function htmlRadio($name, $value)
	{
	?>
		<fieldset id="jform_type" class="radio inputbox">
		<input type="radio" name="<?php echo $name ?>" id="<?php echo $name ?>0" value="0" <?php if($value == 0) echo "checked=\"checked\"";?> />
		<label><?php echo JText::_("ENCRYPT_NO")?></label>
		<input type="radio" name="<?php echo $name ?>" id="<?php echo $name ?>1" value="1" <?php if($value == 1) echo "checked=\"checked\"";?> />
		<label><?php echo JText::_("ENCRYPT_YES")?></label>
		</fieldset>
		<?php
	}
	
	public static function getTimeDifference($date, $null_text = "")
	{
		if(method_exists($date, "diff"))
		{
			$now = new JDate();
			$diff = $now->diff($date);
			$s1 = "ENCRYPT_TIME_AGO";
			$s2 = "ENCRYPT_TIME_AGO1";
			if($diff->y > 2000)
			{
				if($null_text == "")
					$result = JText::_("ENCRYPT_NEVER");
				else
					$result = $null_text;
			}
			else if($diff->y > 0)
			{
				$unit1 = JText::_("ENCRYPT_YEARS");
				$unit2 = JText::_("ENCRYPT_MONTHS");
				if($diff->y == 1)
					$unit1 = JText::_("ENCRYPT_YEAR");
				if($diff->m == 1)
					$unit2 = JText::_("ENCRYPT_MONTH");
				if($diff->m > 0)
				{
					$result = JText::sprintf($s1, $diff->y, $unit1, $diff->m, $unit2);
				}
				else
					$result = JText::sprintf($s2, $diff->y, $unit1);
			}
			else if($diff->m > 0)
			{
				$unit1 = JText::_("ENCRYPT_MONTHS");
				$unit2 = JText::_("ENCRYPT_DAYS");
				if($diff->m == 1)
					$unit1 = JText::_("ENCRYPT_MONTH");
				if($diff->d == 1)
					$unit2 = JText::_("ENCRYPT_DAY");
				if($diff->d > 0)
					$result = JText::sprintf($s1, $diff->m, $unit1, $diff->d, $unit2);
				else
					$result = JText::sprintf($s2, $diff->m, $unit1);
			}
			else if($diff->d > 0)
			{
				$unit1 = JText::_("ENCRYPT_DAYS");
				$unit2 = JText::_("ENCRYPT_HOURS");
				if($diff->d == 1)
					$unit1 = JText::_("ENCRYPT_DAY");
				if($diff->h == 1)
					$unit2 = JText::_("ENCRYPT_HOUR");
				if($diff->h > 0)
					$result = JText::sprintf($s1, $diff->d, $unit1, $diff->h, $unit2);
				else
					$result = JText::sprintf($s2, $diff->d, $unit1);
			}
			else if($diff->h > 0)
			{
				$unit1 = JText::_("ENCRYPT_HOURS");
				$unit2 = JText::_("ENCRYPT_MINS");
				if($diff->h == 1)
					$unit1 = JText::_("ENCRYPT_HOUR");
				if($diff->i == 1)
					$unit2 = JText::_("ENCRYPT_MIN");
				if($diff->i > 0)
					$result = JText::sprintf($s1, $diff->h, $unit1, $diff->i, $unit2);
				else
					$result = JText::sprintf($s2, $diff->h, $unit1);
			}
			else
			{
				if($diff->i == 1)
					$result = JText::sprintf($s2, $diff->i, JText::_("ENCRYPT_MIN"));
				else
					$result = JText::sprintf($s2, $diff->i, JText::_("ENCRYPT_MINS"));
			}
			return $result;
		}
		else
		{
			$format = JText::_("ENCRYPT_DATE_TIME_FORMAT");
			return $date->format($format);
		}
	}
	
	static function splitKey($key)
	{
		$splitted = "";
		$i = 0;
		$length = strlen($key);
		while($i < $length)
		{
			$l = 64;
			if($i + $l > $length)
				$l = $length - $i;
			$splitted .= substr($key, $i, $l) . " ";
			$i += 64;
		}
		return $splitted;
	}
}

?>