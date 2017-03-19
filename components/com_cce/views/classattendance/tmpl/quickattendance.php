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


<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-user"></i> Attendance Register</h2>
			<div class="pull-right">
			<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm1">
                        <table border="0">
                                <tr>
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
                        <input type="hidden" name="controller" value="classattendance" >
                        <input type="hidden" name="view" value="classattendance" >
                        <input type="hidden" name="layout" value="quickattendance" >
                        <input type="hidden" name="task" value="go" >
                        <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
                                </table>
                </form>
                        </div>
                </div>

	</div>
</div>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<tr><th class="list-title" width="10%">S#</th><th class="list-title" width="15%">Class</th><th class="list-title" width="75%">Absentees</th></tr>
<?php
$courses=$model->getCurrentCourses();
$i=1;
foreach($courses as $course)
{
	echo '<tr>';
	echo '<td>'.$i++.'</td>';
	echo '<td>'.$course->code.'</td>';
	echo '<td>'; 
	echo '<select id="selectError1'.$course->id.'" multiple data-rel="chosen" style="width:100%;" name="courses['.$course->id.'][]">';
        $students = $model->getStudents($course->id);
		foreach($students as $student){
			 $s = $model->getAbsenteeByDateAndSession($student->id,$c1date,$session,$xx);
			if($s)
			echo '<option value="'.$student->id.'" selected="true"> <style="font-size:5px;">'.$student->firstname.'</option>';
			else
			echo '<option value="'.$student->id.'"> <style="font-size:5px;">'.$student->firstname.'</option>';
		}
	
	echo '</td>';


	echo '</tr>';
	
}

?>

</table>
<div class="pull-right;">
<button type="submit" class="btn btn-primary" name="save" value="Save">Save</button>
</div>
<input type="hidden" name="controller" value="classattendance" >
<input type="hidden" name="view" value="classattendance" >
<input type="hidden" name="task" value="quicksave" >
<input type="hidden" name="layout" value="quickattendance" >
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
<input type="hidden" name="cdate" value="<?php echo $cdate; ?>" >
<input type="hidden" name="session" value="<?php echo $session; ?>" >
</form>
<br />

