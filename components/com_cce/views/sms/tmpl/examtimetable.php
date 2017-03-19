<?php

        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$examid= JRequest::getVar('examid');
	$ttid= JRequest::getVar('ttid');
	$flag= JRequest::getVar('flag');

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$model = $this->model;
	$model1 = $this->model1;
	$model2 = $this->model2;
        $modelsms = & $this->getModel('sms');
	$courses=$model->getCurrentCourses();
	$exams =$model2->getTNGradeBook();
	$model2->getTNGradeBookEntry($examid,$erec);
	$timetablelist=$modelsms->getSMSTimetableList($examid,$list);
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
        $emodulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
	if($flag=="exam"){
		$mname="";
        	$pathway->addItem('GRADES',$emodulelink);
	}else{
		$mname="";
	 //       $pathway->addItem('SMS',$modulelink);
	}
        $pathway->addItem('TIME TABLE');

	$ttrec = $modelsms->getSMSTimeTableListEntry($ttid,$trec);
	$title = $trec->title;
	$modelsms->getSMSTimeTableCourses($ttid,$ttcourses);

?>

<script>
$(document).ready(function () {

  $('#dd').onchange(function (event) {
	$('#sms').disable;
  }
}

</script>

<b style="font: bold 15px Georgia, serif;"><?php echo $mname; ?></b>
<?php
if($flag=="exam") ;
else
	$this->showlinks();
?>


<h1>Exam Timetable</h1>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=sms&view=sms&task=saveexamtimetable&layout=examtimetable&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
			<div class="box-icon">
				<div class="pull-right">
				<table border="0"><tr>
					<td>
					<button class="btn btn-small btn-success" name="New" value="New"><i class="icon-plus-sign icon-white"></i> New Time Table</button>
					</td>
</tr>
</table>
				</div>
			</div>


                        <div class="pull-left">
                                <table width="100%" border="0">
                                <tr>
				<td>Exam</td>
                                <td>
                                <select id="selectError1" data-rel="chosen" name="examid"> 
                                <option value="">Select</option>
                                <?php
                                foreach($exams as $exam) :
                                echo "<option value=\"".$exam->id."\" ".($exam->id == $examid ? "selected=\"yes\"" : "").">".$exam->title."</option>";             
                                endforeach;
                                ?>
                                </select>
                                </td>
				<td>
				<button class="btn btn-small btn-warning" name="Go" value="Go"><i class="icon-plus-sign icon-white"></i> Go</button>
				</td>
				<td>Time Table for</td>
                                <td>
                                <select id="selectError2" data-rel="chosen" name="tt" onChange="submit();">
                                <option value="">Select</option>
                                <?php
                                foreach($list as $lrec) :
                                echo "<option value=\"".$lrec->id."\" ".($lrec->id == $ttid ? "selected=\"yes\"" : "").">".$lrec->title."</option>";             
                                endforeach;
                                ?>
                                </select>
                                </td>
				<td>
					Title <input type="text" name="title" style="width:300px;" value="<?php echo $title; ?>" /><button class="btn btn-small btn-warning" name="Update" value="Update"><i class="icon-plus-sign icon-white"></i> Update</button>
				</tD>
				</tr>
				</table>
</div>


<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-content">
			<table width="" class="table">
			<thead>
			<tr>
				<th width="20%">Classes</th>
				<th width="5%">Sno</th>
				<th width="5%">Date</th>
				<th width="31%">Forenoon</th>
				<th width="29%">Afternoon</th>
				<th width="2%">OP</th>
				</tr>
			</thead>   
			<tbody>
<?php
if($examid && $ttid){
$N=15;
	$rf=0; //To find empty list
//	foreach ($courses as $course){
			for($i=1;$i<=$N;$i++){
				//$rs = $modelsms->getSMSExamTimeTable($ttid,$ttrec);
				echo '<tr style="row-height:10px;">';
				if($i==1){
					echo '<td rowspan="15" >';
                                        echo '<select id="selectError4" multiple data-rel="chosen" name="courses[]">';
					
                                        $courses=$model->getCurrentCourses();
                                        foreach($courses as $course)
                                        {
						$modelsms->getSMSTimeTableCourses($ttid,$course->id,$cccs);
						if(count($cccs)>0)
	                                        	echo '<option value="'.$course->id.'" selected="yes">'.$course->code.'</option>';
						else
	                                        	echo '<option value="'.$course->id.'">'.$course->code.'</option>';
						
                                        }
                                        echo '</select>';

					echo '</td>';
				}
				$r=$modelsms->getSMSTimeTableEntry($ttid,$i,$ttrec);
				if($r==false) {
					$ttrec->id="-1";
					$dlink='';
				}else{
   					$dlink= '<a href="'.JRoute::_("index.php?option=".JRequest::getVar('option')."&controller=sms&view=examtimetable&task=deleteexamtimetableentry&flag=".$flag."&tid=".$ttrec->id."&ttid=".$ttid."&examid=".$examid."&Itemid=".$Itemid).'">X</a>';
				}
				echo '<td>'.$i.'</td>';
                                echo '<td><input type="text" class="datepicker" style="width:100px;" name="fdate['.$i.'$$'.$ttid.']" value="'.JArrayHelper::indianDate($ttrec->fdate).'"></td>';
				echo '<td><input type="text" style="width:400px;" name="fn['.$i.'$$'.$ttid.']" value="'.htmlspecialchars($ttrec->fn).'" /></td>';
				echo '<td><input type="text" style="width:400px;" name="an['.$i.'$$'.$ttid.']" value="'.htmlspecialchars($ttrec->an).'" /></td>';
				echo '<td><input type="hidden" name="tid['.$i.'$$'.$ttid.']" value="'.htmlspecialchars($ttrec->id).'" />'.$dlink.'</td>';
				echo '</tr>';
			}
		}	
	?>
			</tbody>
			</table>  

			<input type="hidden" name="view" value="examtimetable" />
			<input type="hidden" name="smstext" value="<?php echo $smstext; ?>" />
			<input type="hidden" name="flag" value="<?php echo $flag; ?>" />
			<input type="hidden" name="controller" value="sms" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
			<input type="hidden" name="etitle" value="<?php echo $erec->title; ?>" />
			<input type="hidden" name="ttitle" value="<?php echo $title; ?>" />
			<input type="hidden" name="task" value="saveexamtimetable"/>
		</div>
	</div><!--/span-->
</div><!--/row-->
<div class="pull-right">
<?php if($flag!="exam") 
	echo '<button class="btn btn-small btn-danger" value="Send" name="Send"> <i class="icon-edit icon-white"></i> Send SMS</button>';
?>
<button class="btn btn-small btn-success" name="Save" value="Save"><i class="icon-plus-sign icon-white"></i> Save</button>        
</div>
</form>
<br />
<br />
<br />
