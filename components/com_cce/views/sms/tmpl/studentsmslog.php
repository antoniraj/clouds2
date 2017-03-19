
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
           JHTML::script('validate.js', 'components/com_cce/js/');
        
	$fdate = JRequest::getVar('fdate');
	$Itemid= JRequest::getVar('Itemid');
	if(!$fdate) $fdate=date('d-m-Y');
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
 //       $pathway->addItem('SMS',$modulelink);
        $pathway->addItem('SMS LOG');

?>

<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>

<?php
        $this->showlinks();
?>





	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Sms Log</h2>
						<div class="box-icon">
				<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=sms&view=sms&task=display&layout=studentsmslog&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
                                  		Select Date:<input type="text" class="datepicker" name="fdate" id="fdate" value="<?php echo JArrayHelper::indianDate($fdate); ?>">
 <button class="btn btn-primary" name="go" value="Go"><i class="icon-plus-sign icon-white"></i> Go</button></td></tr>

                <input type="hidden" name="controller" value="sms" >
              <input type="hidden" name="view" value="sms" >
              <input type="hidden" name="layout" value="studentsmslog" >
              <input type="hidden" name="task" value="display" >
              <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
            </form>




						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								<!--  <th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>  -->
								  <th width="10%">Date</th>
								  <th>Time</th>
								  <th>Sms Text</th>
                                  <th width="10%">Total</th>
                                  <th width="10%">Sent</th>
                                  <th width="10%">Failed</th>
                                  <th width="10%">Sent By</th>
                                  <th>Sent To</th>
							  </tr>
						  </thead>   
						  <tbody>
<?php
$logid = JRequest::getVar('logid');
$model = $this->getModel('sms');
$fdate=JArrayHelper::mysqlformat($fdate);
$s = $model->getStudentSSMSLog($fdate,$recs);

$i=1;
foreach($recs as $rec)
{
	$rs=$model->rep_smslog($rec->id,$tot,$del,$failed);
        $alllink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=studentsmslogtotal&logid='.$rec->id.'&Itemid='.$masterItemid);
        $sentlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=studentsmslogsent&logid='.$rec->id.'&Itemid='.$masterItemid);
	echo "<tr>";
?>
<!--	 <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td> -->
<?php
	echo "<td>$rec->fsmsdate</td><td>$rec->smstime</td><td>$rec->smstext</td>";

	echo '<td><a class="btn btn-mini btn-primary" href="'.$alllink.'"><i class="" icon-white"></i>'.$tot.'</a></td>';

	echo "<td>$del</td>";
	if($failed>0)
		echo '<td><a class="btn btn-mini btn-danger" href="'.$sentlink.'"><i class="" icon-white"></i>'.$failed.'</a></td>';
	else
		echo '<td>'.$failed.'</td>';
	echo "<td>$rec->sentby</td><td>$rec->sentto</td></tr>";
	$i++;
}
?>
							 </tbody>
					  </table>            
					</div>
                     

				</div><!--/span-->
			
			</div><!--/row-->
						

