<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $staffid= JRequest::getVar('staffid');
        $departmentid= JRequest::getVar('departmentid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model = & $this->getModel('timetable');
        $model1 = & $this->getModel('managersubjects');
	$model->getDays1($days);
	$model->getSessions1($sessions);

        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Time Table');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $ttItemid = $model->getMenuItemid('manageschool','Create Time Table');
        if($ttItemid) ;
        else{
                $ttItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
        $conslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=workload&departmentid='.$departmentid.'&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Time Table',$modulelink);
        $pathway->addItem('Workload',$conslink);
        $pathway->addItem('Teacher Constraints');
?>





<form action="<?php echo JRoute::_('index.php?option=com_cce') ?>" class="form-horizontal" method="POST"  name="addform" id="addform" >	
<div class="box">
	<div class="box-header well" data-original-title>
		<h2><i class="icon-edit"></i> <strong>Teacher Constraints</strong></h2>
		<div class="pull-right">
				<button class="btn btn-primary" name="Save" value="Save">
					<i class="icon-plus-sign icon-white"></i> Save
				</button>
				<button class="btn btn-danger" name="Cancel" value="Cancel">
					<i class="icon-plus-sign icon-white"></i> Cancel
				</button>
		</div>
	</div>
<table width="100%">
<tr>
		<td style="vertical-align:top; width:100%;">
		<div class="box-content" style="vertical-algin:top;width:400px;">
		<fieldset>
			<legend>Not available Timings ...</legend>
			<div class="control-group">
			<?php
			echo '<table width="100%" border="1">';
			echo '<tr><td></td>';
			foreach($sessions as $ses){
				echo '<td>'.$ses->code.'</td>';
			}
			echo '</tr>';
			foreach ($days as $day){
				echo '<tr>';
				echo '<td>'.$day->code.'</td>';
				foreach($sessions as $ses){	
					echo '<td>';
					$rs=$model->getteachernotavailableslot($staffid,$day->code,$ses->code);
					if($rs)
						echo '<input type="checkbox" name="slot[]" value="'.$day->code.'-'.$ses->code.'" checked />';
					else
						echo '<input type="checkbox" name="slot[]" value="'.$day->code.'-'.$ses->code.'" />';
					echo '</td>';	
				}
				echo '</tr>';
			}
			echo '</table>';
			?>
			</div>
		</fieldset>
		</div>
		</td>
</tr>
</table>
		<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
		<input type="hidden" id="view" name="view" value="timetable" />
		<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" id="staffid" name="staffid" value="<?php echo $staffid; ?>" />
		<input type="hidden" id="departmentid" name="departmentid" value="<?php echo $departmentid; ?>" />
		<input type="hidden" id="controller" name="controller" value="timetable" />
		<input type="hidden" id="layout" name="layout" value="teacherconstraints" />
		<input type="hidden" name="task" id="task" value="saveteacherconstraints" />
</div><!--/span-->
</form>   
