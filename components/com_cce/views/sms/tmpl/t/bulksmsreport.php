<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/bulksms.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Send Bulk SMS Report</h1>
        </div>
</div>
<hr /> <br />
<?php
$logid = JRequest::getVar('logid');
$model = $this->getModel('sms');
$model->getStudentSMSLogByID($logid,$rec);
$model->getStudentSMSStatusLogByLID($logid,'Y',$Ystudentids);
$model->getStudentSMSStatusLogByLID($logid,'N',$Nstudentids);

?>
<h1><?php echo $rec->smstext; ?> </h1>
<h4><?php echo "$rec->fsmsdate <br />$rec->smstime"; ?> </h4>
<hr />
<br />
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table>
		<tr>
			<td align="right"><input type="submit" class="button_go" name="retry" id="retry" value="Retry"></td>
		</tr>
	</table>

	<input type="hidden" name="logid" id="logid" value="<?php echo $logid; ?>" />
	<input type="hidden" id="view" name="view" value="sms" />
	<input type="hidden" id="layout" name="layout" value="bulksmsreport" />
	<input type="hidden" id="controller" name="controller" value="sms" />
	<input type="hidden" name="task" id="task" value="retry" />
</form>
<table>
<tr><th class="list-title">SENT ITEMS(<?php echo count($Ystudentids); ?>)</th><th class="list-title">FAILED ITEMS(<?php echo count($Nstudentids); ?>)</th></tr>
<tr>
<td>
<table>
<tr><th class="list-title">Student Details</th><th class="list-title">Mobile No.</th></tr>
<?php
foreach ($Ystudentids as $yrec)
{
	$s=$model->getStudent($yrec->sid,$srec);
	echo "<tr><td>$srec->firstname</td><td>$srec->pmobile</td><tr>";
}
?>

</table>

</td>
<td>
<table>
<tr><th class="list-title">Student Details</th><th class="list-title">Mobile No.</th></tr>

<?php
foreach ($Nstudentids as $nrec)
{
	$s=$model->getStudent($nrec->sid,$srec);
   	$link=JRoute::_("index.php?option=com_cce&controller=sms&view=sms&layout=updatemobile&task=updatemobile&sid=$nrec->sid&name=$srec->firstname&mobile=$srec->pmobile&logid=$logid");
	echo "<tr><td>$srec->firstname</td><td><a href=\"$link\">$srec->pmobile</a></td><tr>";
}

?>
</table>
</td>
</tr>
</table>

