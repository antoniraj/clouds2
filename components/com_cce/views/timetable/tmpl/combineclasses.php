<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $departmentid= JRequest::getVar('departmentid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model1 = & $this->getModel('managesubjects');
        $model = & $this->getModel('timetable');
	$model->getStaffByDepartment($departmentid,$drecs);
	$model->getDays1($days);
	$model->getSessions1($sessions);
	$model1->getAllClassTeachers($clrecs);
	//$courses = $model->getCurrentCourses();
	$courseids = $model->getDepartmentCourses($departmentid);
        $model->getCourse($courseid,$crec);
        $deps=$model->getDepartments();
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
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Time Table',$modulelink);
        $pathway->addItem('Constraints');



?>



<style>

.rotate {
  /* FF3.5+ */
  -moz-transform: rotate(-90.0deg);
  /* Opera 10.5 */
  -o-transform: rotate(-90.0deg);
  /* Saf3.1+, Chrome */
  -webkit-transform: rotate(-90.0deg);
  /* IE6,IE7 */
  filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
  /* IE8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
  /* Standard */
  transform: rotate(-90.0deg);
}

table#t01, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 3px;
    text-align: center;
}
table#t01 tr:nth-child(even) {
    background-color: #fff;
}
table#t01 tr:nth-child(odd) {
   background-color:#fff;
}
table#t01 th	{
    background-color: #eee;
    color: black;
}

</style>


<div class="box">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> <strong>Combine Classes</strong></h2>
			&nbsp;&nbsp;&nbsp;<img id="theimage" src="<?php echo $iconsDir.'/loading.gif'; ?>" style="width: 30px; height: 30px;">

			<div class="pull-right">
			<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                                    <select id="selectError" data-rel="chosen" onchange="submit();" name="departmentid">
                                                                <option value="">Select Department</option>
                                                                <?php
                                                                foreach($deps as $department) :
                                                                echo "<option value=\"".$department->id."\" ".($department->id == $departmentid ? "selected=\"yes\"" : "").">".$department->departmentname."</option>";
                                                                endforeach;
                                                                ?>
                                    </select>

				
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="display" />
				<input type="hidden" name="controller" value="timetable" />
				<input type="hidden" name="view" value="timetable" />
				<input type="hidden" name="layout" value="combineclasses" />
			</form>
			</div>
			<div class="pull-right">
			<h3>Select Department</h3>
                        </div>
	</div>


<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">

<table width="100%">
<?php
$format=2;
if($format==2){
echo '<tr><b>';
echo '</b></tr>';
echo '<tr height="70px">';

echo '<td rowspan="2" style="width:4%">Class</td> <td rowspan="2" style="width:8%">&nbsp;&nbsp;&nbsp;&nbsp;Staff---><br /><br />Subject&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
foreach($drecs as $drec){
	$cl=$drec->staffcode;
	foreach($clrecs as $clrec){
		if($clrec->staffid==$drec->id){
			$cl='<b>'.$cl.'</b>';
			break;
		}
	}
	echo '<td valign="bottom" bgcolor="#eee"><div style="width:20px; text-align:center; margin:0 auto;" class="rotate">'.$cl.'</div></td>';
}
echo '</tr><tr>';
foreach($drecs as $drec){
	echo '<td bgcolor="#eee"><div style="width:23px;horizontal-align:center; margin:0 auto;">';
	$r=$model1->getWorkloadHrs($drec->id,$obj);
	if($r){
		$hhrs=$obj->hrs;
	}else $hhrs='0';
?>
                        <?php echo $hhrs; ?>
<?php
	echo '</div></td>';
}
echo '</tr>';
foreach($courseids as $cs){
	$model->getCourse($cs->courseid,$crec);
	$model1->getMSubjectsByCourse($cs->courseid,$subjects);
	$ct=count($subjects);
	$f=0;
	foreach($subjects as $sb){
		echo '<tr>';
		if($f==0){
			echo '<td rowspan="'.$ct.'" bgcolor="#eee" nowrap><div class="rotate">'.$crec->code.'</div><br />';
			$f=1;
			echo '</td>';
		}
		
		echo '<td bgcolor="#eee" nowrap>'.$sb->subjectcode.'</td>';
		foreach($drecs as $drec){
			echo '<td bgcolor="#eee" nowrap>';
			$rs=$model1->getMSubjectActivitiesByCourseSubject($cs->courseid,$sb->id,$drec->id,$rec);
			if($rs=='true'){
				$rss=$model->getCombinedId($rec->id,$comrec);
				if($comrec->comid){
	                        	echo $rec->hrs.' Hours'; 
        				$dellink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=deletecombinedclasses&comid='.$comrec->comid.'&departmentid='.$departmentid.'&Itemid='.$Itemid);
					echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$comrec->comid.'&nbsp;&nbsp&nbsp;';
					echo '<a href="'.$dellink.'">X</a>';
					
				}else{
	                        	echo $rec->hrs; ?>
        	                        <input type="checkbox" name="com[]" value="<?php echo $rec->id; ?>" />
<?php
				}
			}else{
				echo '';
			}
			echo '</td>';
		}
		echo '</tr>';
	}
?>
<?
	unset($subjects);
}

}

?>
</table>
                        	<button class="btn btn-warning" name="save" value="Save">Save</button>
                                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                                <input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
                                <input type="hidden" name="activityid" value="<?php echo $rec->id; ?>" />
                                <input type="hidden" name="task" value="savecombinedclasses" />
                                <input type="hidden" name="controller" value="timetable" />
                                <input type="hidden" name="view" value="timetable" />
                                <input type="hidden" name="layout" value="combineclasses" />
</form>
</div>
</div>
