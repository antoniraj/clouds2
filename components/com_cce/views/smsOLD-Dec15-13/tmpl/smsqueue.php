<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$category= JRequest::getVar('category');
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $model = & $this->getModel();
        $iconsDir1 = JURI::base() . 'components/com_cce/images';
        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Master');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);

?>

<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/smsqueue.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h1 class="item-page-title">SMS QUEUE</h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1sms.png'; ?>" alt="Bulk SMS" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>

<br />
<br />

<table>
<tr>
<th class="list-title" width="4%">SNO</th><th width="8%" class="list-title">DATE</th><th width="8%" class="list-title">TIME</th><th width="35%" class="list-title">SMS TEXT</th><th width="10%" class="list-title">SENT BY</th><th width="15%" class="list-title">SENT TO</th><th class="list-title" width="10%">STATUS</th><th class="list-title" width="10%">OPTION</th>
</tr>
<?php
$logid = JRequest::getVar('logid');
$model = $this->getModel('sms');
$s = $model->getStudentSMSLog($recs);
$i=1;
foreach($recs as $rec) {
	echo "<tr>";
	echo "<td>$i</td><td>$rec->fsmsdate</td><td>$rec->smstime</td><td>$rec->smstext</td><td>$rec->sentby</td><td>$rec->sentto</td><td>";
	if($rec->status==='A')
	{
		?>
		<form action="index.php" method="POST" name="addform" id="addform">
		<input type="submit" name="submit" class="button_send" value="Send" />
		<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
		<input type="hidden" id="logid" name="logid" value="<?php echo $rec->id; ?>" />
		<input type="hidden" id="view" name="view" value="sms" />
		<input type="hidden" id="layout" name="layout" value="smsqueue" />
		<input type="hidden" id="controller" name="controller" value="sms" />
		<input type="hidden" name="task" id="task" value="sendstudentsms" /> 
		<input type="hidden" name="category" value="<?php echo $category; ?>" /> 
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		</form>

		<?php	
	}
	else if($rec->status==='N')
	{
		echo "Aproval Pending";
	}else{
		echo "Sent";
	}
?>
	</td>
	<td>
		<form action="index.php" method="POST" name="addform" id="addform" >
	
		<input type="submit" name="cancel" class="button_delete" value="Cancel" />
		<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
		<input type="hidden" id="logid" name="logid" value="<?php echo $rec->id; ?>" />
		<input type="hidden" id="view" name="view" value="sms" />
		<input type="hidden" id="layout" name="layout" value="smsqueue" />
		<input type="hidden" id="controller" name="controller" value="sms" />
		<input type="hidden" name="task" id="task" value="deletesms" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	</form>
	</td>
	</tr>
<?php
	$i++;
}
?>
</table>
