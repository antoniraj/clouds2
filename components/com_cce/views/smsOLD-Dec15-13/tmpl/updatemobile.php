<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';


	$mobile = JRequest::getVar('mobile');
	$sid = JRequest::getVar('sid');
	$name = JRequest::getVar('name');
	$logid = JRequest::getVar('logid');
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/updatemobile.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Update Mobile Number</h1>
        </div>
</div>
<hr /> <br />
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table>
		<tr>
			<td>Name</td>
			<td><?php echo $name; ?></td>
		</tr>
		<tr>
			<td>Mobile Number</td>
			<td>
			<input type="text" id="mobile" name="mobile" size="32" maxlength="15" value="<?php echo $mobile;  ?>" />
			</td>
		</tr>
		<tr><td><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="sid" name="sid" value="<?php echo $sid; ?>" />
	<input type="hidden" id="view" name="sms" value="sms" />
	<input type="hidden" id="controller" name="controller" value="sms" />
	<input type="hidden" name="task" id="task" value="updatestudentmobile" />
	<input type="hidden" name="logid" id="logid" value="<?php echo $logid; ?>" />
</form>
