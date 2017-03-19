<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $departmentid= JRequest::getVar('departmentid');
        $courseid= JRequest::getVar('courseid');
        $activityid= JRequest::getVar('activityid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model1 = & $this->getModel('managesubjects');
        $model = & $this->getModel('timetable');
	$model->getDays1($days);
	$model->getSessions1($sessions);
	$model1->getWorkloadActivity($activityid,$arec);
	$terms = $model->getCurrentTimeTableTerms();
	$courses = $model->getCurrentCourses();
        $model->getCourse($courseid,$crec);
	$model->getTimeTableTerm($tttermid,$trec) ;
	$rs = $model1->getMSubjectsByCourse($courseid,$subjects);

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
        //$conslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=workload&Itemid='.$masterItemid);
        $conslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=workload&departmentid='.$departmentid.'&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Time Table',$modulelink);
        $pathway->addItem('Workload',$conslink);
        $pathway->addItem('Constraints');
?>





<form action="<?php echo JRoute::_('index.php?option=com_cce') ?>" class="form-horizontal" method="POST"  name="addform" id="addform" >				
<div class="box">
	<div class="box-header well" data-original-title>
		<h2><i class="icon-edit"></i> <strong>Activity Constraints</strong></h2>
		<div class="pull-right">
				<button class="btn btn-primary" name="Save" value="Save">
					<i class="icon-plus-sign icon-white"></i> Save
				</button>
				<button class="btn btn-danger" name="Cancel" value="Cancel">
					<i class="icon-plus-sign icon-white"></i> Cancel
				</button>
		</div>
	</div>
<table width="100%"><tr><td width="50%">
	<div class="box-content">
		<fieldset>
			<legend>Basic Constraints...</legend>
			<div class="control-group">
				<label class="control-label">Period Duration<span class="mandatory">*</span></label>
				<div class="controls">
					<input type="text"  required="required" id="duration" name="duration" value="<?php echo $arec->duration; ?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Total Periods<span class="mandatory">*</span></label>
				<div class="controls">
					<input type="text" required="required" id="hrs" name="hrs" readonly="true" value="<?php echo  $arec->hrs; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Minimum Number of days between periods<span class="mandatory">*</span></label>
				<div class="controls">
					<input type="text" required="required" id="mindays" name="mindays" value="<?php echo  $arec->mindays; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Consecutive if same day?<span class="mandatory">*</span></label>
				<div class="controls">
    					<?php
                                        	if($arec->consecutive=='1')
                                                	echo '<input type="checkbox" name="consecutive" checked="true" value="1" >';
                                                else
                                                        echo '<input type="checkbox" name="consecutive"  value="0" >';
                                         ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Condition<span class="mandatory">*</span></label>
				<div class="controls">
					<select id="selectError6" data-rel="chosen" name="rate">
					<?php
						if($arec->rate=='99.75') {
							echo '<option value="'.$arec->rate.'">Follow If Possible</option>';  
							echo '<option value="100">Follow Strictly</option>';
						}else if($arec->rate=='100'){
							echo '<option value="'.$arec->rate.'">Follow Strictly</option>'; 
							echo '<option value="99.75">Follow If Possible</option>';
						}else{
							echo '<option value="100">Follow Strictly</option>';
							echo '<option value="99.75">Follow If Possible</option>';
						}
					?>
					</select>

				</div>
			</div>
		</div>
		</td><td style="vertical-align:top; width:50%;">
		<div class="box-content" style="vertical-algin:top;width:400px;">
		<fieldset>
			<legend>Preferred Timings ...</legend>
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
					$rs=$model->getactivitytimingslot($activityid,$day->code,$ses->code);
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
			<div class="control-group">
				<label class="control-label">Condition<span class="mandatory">*</span></label>
				<div class="controls">
					<select id="selectError7" data-rel="chosen" name="psrate">
					<?php
						if($arec->psrate==99.75) {
							echo '<option value="'.$arec->psrate.'" selected>Follow If Possible</option>';  
							echo '<option value="100">Follow Strictly</option>';
						}else if($arec->psrate==100){
							echo '<option value="'.$arec->psrate.'" selected>Follow Strictly</option>'; 
							echo '<option value="99.75">Follow If Possible</option>';
						}else{
							echo '<option value="100">Follow Strictly</option>';
							echo '<option value="99.75" selected>Follow If Possible</option>';
						}
					?>
					</select>
				</div>
			</div>
		</fieldset>
	</div>
		</td></tr></table>
		</fieldset>
		<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
		<input type="hidden" id="view" name="view" value="timetable" />
		<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" id="activityid" name="activityid" value="<?php echo $activityid; ?>" />
		<input type="hidden" id="controller" name="controller" value="timetable" />
		<input type="hidden" id="departmentid" name="departmentid" value="<?php echo $departmentid; ?>" />
		<input type="hidden" id="layout" name="layout" value="workload" />
		<input type="hidden" name="task" id="task" value="saveactivityconstraints" />
	</div>
</div><!--/span-->
</form>   
