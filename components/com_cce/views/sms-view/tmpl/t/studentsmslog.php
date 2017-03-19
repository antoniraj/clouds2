<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/smslog.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>SMS LOG</h1>
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
$s = $model->getStudentSSMSLog($recs);
$i=1;
foreach($recs as $rec)
{
	echo "<tr>";
	echo "<td>$i</td><td>$rec->fsmsdate</td><td>$rec->smstime</td><td>$rec->smstext</td><td>$rec->sentby</td><td>$rec->sentto</td><td>";
	echo "</td></tr>";
	$i++;
}
?>
</table>
