<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/smsqueue.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>SMS QUEUE</h1>
        </div>
</div>
<hr /> <br />

<table>
<tr>
	<th class="list-title" width="4%">SNO</th><th width="8%" class="list-title">DATE</th><th width="8%" class="list-title">TIME</th><th width="45%" class="list-title">SMS TEXT</th><th width="10%" class="list-title">SENT BY</th><th width="15%" class="list-title">SENT TO</th><th class="list-title" width="10%">STATUS</th>
</tr>
<?php
$logid = JRequest::getVar('logid');
$model = $this->getModel('sms');
$s = $model->getStudentSMSLog($recs);
$i=1;
foreach($recs as $rec)
{
	echo "<tr>";
	echo "<td>$i</td><td>$rec->fsmsdate</td><td>$rec->smstime</td><td>$rec->smstext</td><td>$rec->sentby</td><td>$rec->sentto</td><td>";
	if($rec->status==='A')
	{
		?>
		<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
		<input type="submit" name="submit" value="Send" />
		<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
		<input type="hidden" id="logid" name="logid" value="<?php echo $rec->id; ?>" />
		<input type="hidden" id="view" name="view" value="sms" />
		<input type="hidden" id="layout" name="layout" value="smsqueue" />
		<input type="hidden" id="controller" name="controller" value="sms" />
		<input type="hidden" name="task" id="task" value="sendbulksms" />
		</form>

		<?php	
	}
	else if($rec->status==='N')
	{
		echo "Aproval Pending";
	}else{
		echo "Sent";
	}

	echo "</td></tr>";
	$i++;
}
?>
</table>