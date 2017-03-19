<style>
table.subjects{
	border-collapse:collapse;
}
table tr td{
	padding:4px;border:1px solid #ccc;
	font-size:12px;
}
table tr th{
	background:#E8E8E8;
	padding:5px;
	border:1px solid #919191;
	font-size:14px;
	font-weight:bold;
}
</style>
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $courseid= JRequest::getVar('courseid');
	
        $subjectid= JRequest::getVar('subjectid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model1 = & $this->getModel('managesubjects');
	$clteachers=$model1->getClassTeachers($courseid);
        $model = & $this->getModel('timetable');
	$courses = $model->getCurrentCourses();
    	$model->getCourse($courseid,$crec);
	$rs = $model1->getMSubjectsByCourse($courseid,$subjects);
	$model->getSessions1($sessions);
	$model->getDays1($days);
    	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
    	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
?>

<?php
	$isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
	if( $isModal) {
		$href = '"#" onclick="window.print(); return false;"';
	} else {
		$href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
		$href = "window.open(this.href,'win2','".$href."'); return false;";
		$href = '"index.php?option=com_cce&view=timetable&controller=timetable&layout=printclasstimetable&courseid='.$courseid.'&subjectid='.$subjectid.'&tttermid='.$tttermid.'&tmpl=component&print=1" '.$href;
	}
?>						
						
<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> <strong> View Class Timetable</strong></h2>
			<div class="pull-right">
				<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
					<label class="control-label" for="selectError">Select Class</label>
					<select id="selectError6" data-rel="chosen" name="courses">
						<option value="">Select</option>
						<?php
							foreach($courses as $course) :
								echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
							endforeach;
						?>
					</select>
					<button class="btn btn-primary" name="Go" value="Go"><i class="icon-upload"></i>Go</button>
					<a href=<?php echo $href; ?> ><span title="Print Timetable" class="icon32 icon-green icon-print"></span></a>
					<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
					<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
					<input type="hidden" name="task" value="viewclasstimetable" />
					<input type="hidden" name="controller" value="timetable" />
					<input type="hidden" name="view" value="timetable" />
					<input type="hidden" name="layout" value="classtimetable" />
				</form>
			</div>
		</div>
		<div class="box-content">
		<?php if($courseid)
		{
		?>	

<?php 
 $model->getCourse($courseid,$co_name);
 ?>
 <!-- Class Time Table-->
  <h1 align="center" style="margin-bottom:10px;font-size:20px;font-weight:bold;"><?php echo $co_name->code;?> Time Table</h1>
<table cellpadding="3" width="100%" class="table-striped table-bordered">
						  <thead>
<?php
	echo '<tr>';
        echo '<th class="list-title">Day</th>';
	foreach ($sessions as $session){
		$model->getSessionByCode($session->code,$ssrec);
        	echo '<th class="list-title" >'.$session->code.'<br ><font style="font-size:9px;">['.$ssrec->start.'-'.$ssrec->stop.']</font></th>';
	}
	echo '</tr>';
	foreach ($days as $day){
		echo '<tr>';
        	echo '<th class="list-title2">'.$day->code.'</th>';
		$duration=0;
		foreach ($sessions as $session){
			if($duration>1){
				$duration--;
				continue;
			}
			$text=''; //Cell Contents
			//Get Entry for the cell
			$rs=$model->getTimetableActivityByClass($co_name->code,$day->code,$session->code,$ttentries);
			$duration=0;
			if(count($ttentries)==1){
					$text=$text . $ttentries[0]->subjectcode.'<br />';
					$text=$text.'['.$ttentries[0]->staffcode.']';
					$duration=$ttentries[0]->duration;
			}else if(count($ttentries)>1){
				$text=$ttentries[0]->subjectcode.'<br />';
				$duration=$ttentries[0]->duration;
				foreach($ttentries as $ttentry){
					$text=$text.'['.$ttentry->staffcode.']&nbsp;';
				}
			}else{
				$text='---';	
			}

			if($duration>1){
				echo '<td  align="center" colspan="'.$duration.'">';
				echo $text;
				echo '</td>';
			}
			else{
				echo '<td  align="center">';
				echo $text;
				echo '</td>';
			}
		}
		echo '</tr>';
	}
	
?>
</tbody>
</table>   
<br />
  <h1 align="center" style="margin-bottom:10px;font-size:20px;font-weight:bold;"><?php echo 'Subjects for '.$co_name->code;?></h1>
	
			<table class="table table-striped table-bordered">
				<thead>
				<tr class="list-title">
					<th class="list-title">Sno</th>
					<th class="list-title">Subject Code</th>
					<th class="list-title">Subject Name</th>
					<th class="list-title">Acronym</th>
					<th class="list-title">Staff</th>
					<th class="list-title">Periods</th>
					<th class="list-title">Subject Type</th>
				</tr>
				</thead>   
				<tbody>
			<?php
		if($subjects){
			$i=1;
			foreach($subjects as $srec) {
		?>
				<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo $srec->subjectcode; ?></td>
					<td><?php echo $srec->subjecttitle; ?></td>
					<td><?php echo $srec->acronym; ?></td>
					<?php
					$rs = $model1->getSubjectTeachers($courseid,$srec->id,$staffrecs);
					echo "<td>";
					foreach($staffrecs as $staff){
						$fl=0;
						foreach($clteachers as $clte){
							if($clte->staffid==$staff->id) $fl=1;
						}		
						if($fl==1) $classteacher="[Class Teacher]";
						echo "[$staff->staffcode]&nbsp;$staff->firstname <b>$classteacher</b><br />";
						$classteacher="";
					}
					echo '</td>'; 
					echo '<td>';
					echo $srec->credits; 
					echo "</td>"; 
					echo '<td>';
					echo $srec->subjecttype;
					echo '</td>';
					?>
				</tr>
			<?php
			}
		}
		?>
			</tbody>
		</table>     
<Br>
<br>


<?php
} 
?>
<br>
				</div><!--/span-->
			
			</div><!--/row-->


</div>
