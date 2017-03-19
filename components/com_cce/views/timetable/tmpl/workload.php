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
	<div class="box-content">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> <strong>Constraints</strong></h2>
			&nbsp;&nbsp;&nbsp;<img id="theimage" src="<?php echo $iconsDir.'/loading.gif'; ?>" style="width: 30px; height: 30px;">
			<div class="pull-right">
			<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
			<button class="btn btn-danger" name="init" onclick="tend()" value="Initialize"><i class="icon-plus-sign icon-white"></i> Reset<br /> Activities</button>
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="initworkload" />
				<input type="hidden" name="controller" value="timetable" />
                                <input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
				<input type="hidden" name="view" value="timetable" />
				<input type="hidden" name="layout" value="workload" />
			</form>
			</div>

                        <div class="pull-right">
                        <form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                                <button class="btn btn-info" name="Save" value="Save"><i class="icon-plus-sign icon-white"></i> Remove Class<br/> Constraints</button>
                                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                                <input type="hidden" name="task" value="resetclassconstraints" />
                                <input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
                                <input type="hidden" name="controller" value="timetable" />
                                <input type="hidden" name="view" value="timetable" />
                                <input type="hidden" name="layout" value="workload" />
                        </form>
                        </div>

                        <div class="pull-right">
                        <form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                                <button class="btn btn-info" name="Save" value="Save"><i class="icon-plus-sign icon-white"></i> Remove Staff<br /> Constraints</button>
                                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                                <input type="hidden" name="task" value="resetstaffconstraints" />
                                <input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
                                <input type="hidden" name="controller" value="timetable" />
                                <input type="hidden" name="view" value="timetable" />
                                <input type="hidden" name="layout" value="workload" />
                        </form>
                        </div>

                        <div class="pull-right">
                        <form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                                <button class="btn btn-info" name="Save" value="Save"><i class="icon-plus-sign icon-white"></i> Remove Activity<br /> Constraints</button>
                                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                                <input type="hidden" name="task" value="resetactivityconstraints" />
                                <input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
                                <input type="hidden" name="controller" value="timetable" />
                                <input type="hidden" name="view" value="timetable" />
                                <input type="hidden" name="layout" value="workload" />
                        </form>
                        </div>


			<div class="pull-right">
                        <form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                        <button class="btn btn-primary" name="init" onclick="tend()" value="Initialize"><i class="icon-plus-sign icon-white"></i> Referesh<br />Activities</button>
                                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                                <input type="hidden" name="task" value="refereshworkload" />
                                <input type="hidden" name="controller" value="timetable" />
                                <input type="hidden" name="view" value="timetable" />
                                <input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
                                <input type="hidden" name="layout" value="workload" />
                        </form>
                        </div>
<!--
			<div class="pull-right">
			<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
				<button class="btn btn-primary" name="Save" value="Save"><i class="icon-plus-sign icon-white"></i> Save</button>
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="saveworkload" />
				<input type="hidden" name="controller" value="timetable" />
				<input type="hidden" name="view" value="timetable" />
				<input type="hidden" name="layout" value="workload" />
			</form>
			</div>
-->
			<div class="pull-right">
			<h5>Select Department</h5>
			<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                                    <select id="selectError" data-rel="chosen" onchange="submit();" name="departmentid">
                                                                <option value="">Select Department</option>
                                                                <?php
                                                                foreach($deps as $department) :
                                                                echo "<option value=\"".$department->id."\" ".($department->id == $departmentid ? "selected=\"yes\"" : "").">".$department->departmentname."</option>";
                                                                endforeach;
                                                                ?>
                                    </select>
			&nbsp;
			&nbsp;
			&nbsp;

				
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="display" />
				<input type="hidden" name="controller" value="timetable" />
				<input type="hidden" name="view" value="timetable" />
				<input type="hidden" name="layout" value="workload" />
			</form>
			</div>
			</div>
		</div>
		<br>



<table width="100%">
<?php
$format=2;
if($format==1){
echo '<tr><b>';
foreach($courseids as $rec) {
	$model1->getCourse($rec->courseid,$crec);
//foreach($courses as $cs){
	$model1->getMSubjectsByCourse($rec->courseid,$subjects);
	$count=count($subjects);
	echo '<td style="text-align:center;" bgcolor="#eee" colspan="'.$count.'"><div>'.$crec->code.'</div></td>';
	//echo '<th nowrap colspan="'.$count.'"><div class="rotate">'.$cs->code.'</div></th>';
}
echo '</b></tr>';
echo '<tr height="40px">';
foreach($courseids as $rec) {
	$model->getCourse($rec->courseid,$crec);
	$model1->getMSubjectsByCourse($rec->id,$subjects);
	foreach($subjects as $sb)
		echo '<td bgcolor="#eee" style="text-align:center;" nowrap><div class="rotate">'.$sb->subjectcode.'</div></td>';
	unset($subjects);
}
echo '</tr>';
	for($i=0;$i<=10;$i++){
		echo '<tr>';
	  	for($j=0;$j<=10;$j++){
			echo '<td width="20px">';
			echo '<input type="text" value="'.$i.'-'.$j.'" name="val['.$i.']['.$j.']" maxlength="2" style="border-style:none;width:20px;" />';
			echo '</td>';
	   	}
		echo '</tr>';
	}
}
if($format==2){
echo '<tr><b>';
//foreach($courses as $cs){
//	$model1->getMSubjectsByCourse($cs->id,$subjects);
//	$count=count($subjects);
//	echo '<td style="text-align:center" bgcolor="#eee" colspan="'.$count.'"><div>'.$cs->code.'</div></td>';
	//echo '<th nowrap colspan="'.$count.'"><div class="rotate">'.$cs->code.'</div></th>';
//}
echo '</b></tr>';
echo '<tr height="70px">';
//$model1->getStaffCodes($scodes);

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
//foreach($scodes as $scode){
foreach($drecs as $drec){
	echo '<td bgcolor="#eee"><div style="width:23px;horizontal-align:center; margin:0 auto;">';
	$r=$model1->getWorkloadHrs($drec->id,$obj);
	if($r){
		$hhrs=$obj->hrs;
	}else $hhrs='0';
?>
 <form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                        <button class="btn btn-info" name="init" value="Initialize"><?php echo $hhrs; ?></button>
                                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                                <input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
                                <input type="hidden" name="task" value="display" />
                                <input type="hidden" name="controller" value="timetable" />
                                <input type="hidden" name="staffid" value="<?php echo $drec->id; ?>" />
                                <input type="hidden" name="view" value="timetable" />
                                <input type="hidden" name="layout" value="teacherconstraints" />
 </form>
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

?>
 <form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                        <button class="btn btn-info" name="init" value="Initialize"><?php echo '+'; ?></button>
                                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                                <input type="hidden" name="classid" value="<?php echo $cs->courseid; ?>" />
                                <input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
                                <input type="hidden" name="task" value="display" />
                                <input type="hidden" name="controller" value="timetable" />
                                <input type="hidden" name="view" value="timetable" />
                                <input type="hidden" name="layout" value="classconstraints" />
 </form>

<?php
			$f=1;
			echo '</td>';
		}
		
		echo '<td bgcolor="#eee" nowrap>'.$sb->subjectcode.'</td>';
		//foreach($scodes as $scode){
		foreach($drecs as $drec){
			echo '<td bgcolor="#eee" nowrap>';
			//echo '<input type="text" value="x" name="val['.$sb->subjectcode.']['.$scode->code.']" maxlength="2" style="border-style:none;width:20px;" />';
			$rs=$model1->getMSubjectActivitiesByCourseSubject($cs->courseid,$sb->id,$drec->id,$rec);
			if($rs=='true'){  ?>
 			<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                        	<button class="btn btn-warning" name="init" value="Initialize"><?php echo $rec->hrs; ?></button>
                                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                                <input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
                                <input type="hidden" name="activityid" value="<?php echo $rec->id; ?>" />
                                <input type="hidden" name="task" value="display" />
                                <input type="hidden" name="controller" value="timetable" />
                                <input type="hidden" name="view" value="timetable" />
                                <input type="hidden" name="layout" value="activityconstraints" />
                        </form>
<?php
			}else{
				echo '';
			}
			echo '</td>';
		}
		//echo '<td bgcolor="#eee" nowrap><div class="rotate">'.$sb->subjectcode.'</div></td>';
		echo '</tr>';
	}
?>
<?
	unset($subjects);
}
//
//	foreach($courses as $cs){

/*
	for($i=0;$i<=10;$i++){
		echo '<tr>';
	  for($j=0;$j<=10;$j++){
		echo '<td width="20px">';
		echo '<input type="text" value="'.$i.'-'.$j.'" name="val['.$i.']['.$j.']" maxlength="2" style="border-style:none;width:20px;" />';
		echo '</td>';
	   }
		echo '</tr>';
*/
//	}

}

?>
</table>
</div>
<hr />

</div>
