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
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('SMS',$modulelink);
        $pathway->addItem('SMS QUEUE');

$bulksmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=bulksms&task=bulksms&Itemid='.$smsItemid);
   $batchstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstudentsms&task=displaystudents&Itemid='.$smsItemid);
   $groupstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=groupstudentsms&task=displaygroupstudents&Itemid='.$smsItemid);
   $staffsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstaffsms&task=displaystaff&Itemid='.$smsItemid);
   $approvestudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsaqueue&task=approvestudentsms&Itemid='.$smsItemid);
   $smsqlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsqueue&task=smsqueue&Itemid='.$smsItemid);
   $studentsmsloglink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=studentsmslog&task=studentsmslog&Itemid='.$smsItemid);
   $todaysabslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=todayabsentees&task=display&fl=1&Itemid='.$lItemid);
   $hwlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=homework&task=displayhomeworks&Itemid='.$smsItemid);
   $indlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=individualstudentsms&task=individualstudentsms&Itemid='.$smsItemid);
   $tplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=testportion&task=displaytestportions&Itemid='.$smsItemid);



?>

<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>
<div class="pull-right">
<a class="btn btn-mini btn-success" href="<?php echo $bulksmslink; ?>"><i class="icon-edit icon-white"></i>Bulk SMS</a>
<a class="btn btn-mini btn-info" href="<?php echo $batchstudentsmslink; ?>"><i class="icon-edit icon-white"></i>Batch SMS</a>
<a class="btn btn-mini btn-primary" href="<?php echo $groupstudentsmslink; ?>"><i class="icon-edit icon-white"></i>Group SMS</a>
<a class="btn btn-mini btn-warning" href="<?php echo $indlink; ?>"><i class="icon-edit icon-white"></i>Individual SMS</a>
<a class="btn btn-mini btn-danger" href="<?php echo $hwlink; ?>"><i class="icon-edit icon-white"></i>Homework SMS</a>
<a class="btn btn-mini btn-success" href="<?php echo $tplink; ?>"><i class="icon-edit icon-white"></i>Test Portion SMS</a>
<a class="btn btn-mini btn-info" href="<?php echo $todaysabslink; ?>"><i class="icon-edit icon-white"></i>Today's Absentees SMS</a>
<a class="btn btn-mini btn-primary" href="<?php echo $staffsmslink; ?>"><i class="icon-edit icon-white"></i>Staff SMS</a>
<a class="btn btn-mini btn-warning" href="<?php echo $smsqlink; ?>"><i class="icon-edit icon-white"></i>SMS QUEUE</a>
<a class="btn btn-mini btn-danger" href="<?php echo $approvestudentsmslink; ?>"><i class="icon-edit icon-white"></i>APPROVE QUEUE</a>
<a class="btn btn-mini btn-info" href="<?php echo $studentsmsloglink; ?>"><i class="icon-edit icon-white"></i>SMS LOG</a>
</div>


<style>
#theimage1 { visibility: hidden; }
</style>
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>SMS  QUEUE</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
<button class="btn btn-small btn-info" name="submit"  onclick="tend1()" value="Send"><i class="icon icon-color icon-envelope-closed icon-white"></i>  Send</button>

						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
								  <th>Date</th>
								  <th>Time</th>
								  <th>Sms Text</th>
                                  <th>Sent By</th>
                                  <th>Sent To</th>
                                  <th>Status</th>				
                           <th>Operation</th>
                          			  </tr>
						  </thead>   
						  <tbody>
<?php
$logid = JRequest::getVar('logid');
$model = $this->getModel('sms');
$s = $model->getStudentSMSLog($recs);
$i=1;
foreach($recs as $rec) {
	echo "<tr>";
	echo "<td>".$i++."</td><td>$rec->fsmsdate</td><td>$rec->smstime</td><td>$rec->smstext</td><td>$rec->sentby</td><td>$rec->sentto</td><td>";
	if($rec->status==='A') //if alreay approved then enable send option
	{
		?>
		<form action="index.php" method="POST" name="addform" id="addform">
   <table border="0"><tr><td>      <button class="btn btn-small btn-info" name="submit"  onclick="tend1()" value="Send"><i class="icon icon-color icon-envelope-closed icon-white"></i>  Send</button> 
<img id="theimage1" src="<?php echo $iconsDir.'/loading25.gif'; ?>" style="width: 50px; height: 50px;" ></td></tr></table>
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
	     <button class="btn btn-small btn-danger" name="cancel"  value="Cancel"><i class="icon-trash icon-white"></i>  Cancel</button>
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

}
?>
    

							 </tbody>
					  </table>            
					</div>
                     

				</div><!--/span-->
			
			</div><!--/row-->
			
