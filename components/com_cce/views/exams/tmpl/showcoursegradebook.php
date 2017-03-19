<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$courseid = JRequest::getVar('courseid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('exams');
	$courses = $model->getCurrentCourses();
	if(!isset($courseid)) $courseid=$courses[0]->id;

	$parts = $model->getCourseParts($courseid);

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Exams');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);


?>


<b style="font: bold 15px Georgia, serif;">COURSE GRADE BOOK </b>
<div style="float:right;">
<table border="0" width="100%"><tr><td style="text-align:left;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=display&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<select id="selectError" data-rel="chosen" onchange="submit();" style="width:300px;" name="courseid">
		<option value="">Select a Course</option>
		<?php
		foreach($courses as $course) :
			echo "<option value=\"".$course->id."\" ".($course->id == $courseid? "selected=\"yes\"" : "").">".$course->code."</option>";
		endforeach;
		?>
	</select>
	<input type="hidden" name="view" value="exams" />
	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" name="layout" value="showcoursegradebook" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	</form>
</td>
</tr></table>
</div>
<?php
	//RECURSIVE FUNCTION TO DISPLAY THE SUBJECTS
	function displaySubjects($prec,$model,$psno,$csno,$l,$terms,$cbid,$courseid,$Itemid){
		echo '<tr>';
			echo '<td>';
				if($csno==''){
					echo "$psno";
				}else{
				        echo $psno.'.'.$csno;
				}
			echo '</td>';
			echo '<td align="left" width="40%">';
				$sp='';
				for($i=0;$i<$l;$i++) $sp=$sp.'&nbsp;&nbsp;&nbsp;';
				echo $sp.$prec->subjecttitle;
			echo '</td>';
			echo '<td>'.$prec->subjectcode.'</td>';
			
			//To Display Terms and Grade Books
			foreach($terms as $term){
				$rs=$model->getSubjectTermGradeBook($prec->id,$term->id,$gbrec);
				if($rs){
					$link=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=subjectgradebook&courseid='.$courseid.'&Itemid='.$Itemid.'&eon=1&gbid='.$gbrec->gbid.'&termid='.$term->id.'&subjectid='.$prec->id);
					echo '<td><a class="btn btn-mini btn-info" style="width:50px;" href="'.$link.'"><i class="icon-plus-sign"></i>Marks</a></td>';
				}
			}
		echo '</tr>';

		$crecs = $model->getTSubjectChildEntries($prec->id);
		if(count($crecs)==0){
			return;
		}
		$csno=1;
		$l++;
		foreach($crecs as $crec){
			displaySubjects($crec,$model,$psno,$csno++,$l,$terms,$cbid,$courseid,$Itemid);
		}
	}


?>

<?php 
//DISPLAY PARTS -> TERMS -> SUBJECTS
foreach ($parts as $part){
	$terms = $model->getTTerms($part->id);
	$srecs = $model->getTSubjects($part->id);
?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<i class="icon-edit"></i> <?php echo $part->title; ?>
			<div class="box-icon">
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered">
			<thead>
				<th>Sno</th>
				<th>Subject</th>
				<th>Code</th>
			<?php
				foreach($terms as $term){
					echo '<th>'.$term->term.'</th>';
				}
			?>
			</thead>
			<tbody>
  			<?php
                                        $precs=$model->getParentTSubjects($part->id);
                                        $j=1;
                                        if($precs){
                                                foreach($precs as $prec){
                                                        displaySubjects($prec,$model,$j++,'',0,$terms,$cbid,$courseid,$Itemid);
                                                }
                                        }
                                        $i++;
                                ?>

			</tbody>

			</table>
		</div>
	</div>
</div>
<?php
}

?>
