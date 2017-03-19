<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid=JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$courseid=JRequest::getVar('courseid');
	$session =JRequest::getVar('session');
	if(!$session) $session='M';
	$model = &$this->getModel();
	$courses = $model->getCurrentCourses();
	$rs = $model->getCourse($courseid,$rec);
	$students = $model->getStudents($courseid);
	$cdate=JRequest::getVar('cdate');
	if(!$cdate) $cdate=date('d-m-Y');
	$aa= explode('-',$cdate);
	$c1date = "$aa[2]".'-'."$aa[1]".'-'."$aa[0]";
	$rs = $model->getCalEntry($c1date,$cal);


	$iconsDir1 = JURI::base() . 'components/com_cce/images';

        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Attendance Register');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

      $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=attendance&Itemid='.$masterItemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Attendance',$modulelink);
        $pathway->addItem('Register');

?>


<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> Class Attendance</h2>
			<div class="pull-right">
				<table border="0">
				<tr>
				<td>Class</td>
				<td>
				<select id="selectError" data-rel="chosen" name="courseid" onChange="submit();">
                                <option value="">Select</option>
                                <?php
                                foreach($courses as $course) :
                                echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
                                endforeach;
                                ?>
                                </select>
				</td>
				<td>
				Date
				</td>
				<td>
				<input type="text" class="datepicker"  name="cdate" value="<?php echo JArrayHelper::indianDate($cdate); ?>">
				</td>
				<td>
				Session
				</td>
				<td>
				<select onChange="submit();" data-rel="chosen"  style="width: 190px;" name="session">
                                <?php
                                if($session=='M'){
                                echo '<option value="M">Morning</option>';
                                echo '<option value="E">Evening</option>';
                                }else if($session=='E'){
                                echo '<option value="E">Evening</option>';
                                echo '<option value="M">Morning</option>';
                                }else{
                                echo '<option value="M">Morning</option>';
                                echo '<option value="E">Evening</option>';
                                }
                                ?>
                                </select>
				</td><td>
				<button class="btn btn-primary" name="go" value="Go"><i class="icon-plus-sign icon-white"></i> Go</button>
				</td>
				</tr>
				</table>
			</div>
		</div>
			<input type="hidden" name="controller" value="classattendance" >
			<input type="hidden" name="view" value="classattendance" >
			<input type="hidden" name="layout" value="default" >
			<input type="hidden" name="task" value="go" >
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
		</form>		
	</div>
</div>

			<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
				<table borde="0" width="100%" cellspacing="2" style="border:none;" cellpadding="3">
				<?php
					list($d,$m,$y) = explode("-",$cdate);
					$dte = new DateTime("$y-$m-$d");
				?>
				<tr style="border:none;"><td style="border:none;"><h2><b><?php echo "$cdate".'['.$dte->format('D').']</b></h2></td><td style="border:none;" align="right"><h2>'.$cal[0]['description'].'['.$cal[0]['daytype'].']'; ?></h2></td></tr>
				</table>
			<!--	<table class="table table-striped table-bordered" width="100%" cellspacing="2" cellpadding="3">  -->
					<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
					<tr><th class="list-title" width="10%">S#</th><th class="list-title" width="15%">Reg.No</th><th class="list-title" width="40%">Student Name</th><th class="list-title" width="30%">Present?</th></tr>
						  </thead>
					
					<tbody>
					<?php
						$i=1;
						foreach($students as $student){
							echo '<tr>';
							echo '<td>'.$i.'</td>';
							echo '<td>'.$student->registerno.'</td>';
							echo '<td>'.$student->firstname.'</td>';
							echo '<td>';
							$s = $model->getAbsenteeByDateAndSession($student->id,$c1date,$session,$xx);
							if($s) echo '<input type="checkbox" name="present[]" value="'.$student->id.'" />';
							else echo '<input type="checkbox" name="present[]" checked="true" value="'.$student->id.'" />';
							echo '<input type="hidden" name="sids[]" value="'.$student->id.'" />';
							echo '</td>';
							echo '</tr>';
							$i++;
						}
					?>
					</tbody>
				</table>
</div>
				<br />
				<div class="form-actions" align="right">
					<button type="submit" class="btn btn-primary" name="save" value="Save">Save</button>	
				</div>
				<input type="hidden" name="controller" value="classattendance" >
				<input type="hidden" name="view" value="classattendance" >
				<input type="hidden" name="layout" value="default" >
				<input type="hidden" name="task" value="saveabsentees" >
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
				<input type="hidden" name="cdate" value="<?php echo $cdate; ?>" >
				<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" >
				<input type="hidden" name="session" value="<?php echo $session; ?>" >
			</form>
		</div>
