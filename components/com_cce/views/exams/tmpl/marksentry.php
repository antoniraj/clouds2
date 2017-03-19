<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$classid= JRequest::getVar('classid');
	$subjectid= JRequest::getVar('subjectid');
	$termid= JRequest::getVar('termid');
	$gbeid= JRequest::getVar('gbeid');
	

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('exams');
	$students = $model->getStudents($classid);
	$model->getGBSubject($subjectid,$sub);
	$model->getTTerm($termid,$trec);
	$model->getGradeBookEntry($gbeid,$grec);
	$close = JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=subjectgradebook&gbeid='.$gbeid.'&eon=1&termid='.$termid.'&subjectid='.$subjectid.'&courseid='.$classid.'&Itemid='.$Itemid);
	$deletemarks = JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deleteallsubjectmarks&layout=subjectgradebook&gbeid='.$gbeid.'&eon=1&termid='.$termid.'&subjectid='.$subjectid.'&courseid='.$classid.'&Itemid='.$Itemid);

?>

<center><b><h2><?php echo strtoupper($sub->subjectcode.': '.$sub->subjecttitle).' MARK SHEET - [ '.$trec->term.' ]'; ?> </h2</b></center>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=savemarksentry&gbeid='.$gbeid.'&eon=1&classid='.$classid.'&termid='.$termid.'&subjectid='.$subjectid.'&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i><?php echo strtoupper($grec->title); ?></h2>
			<div class="box-icon">
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
				<button class="btn btn-small btn-primary"  value="Save" name="save"> <i class="icon-plus icon-white"></i> Save</button>
				<a class="btn btn-small btn-warning" style="width:50px;" href="<?php echo $close; ?>"><i class="icon-minus-sign"></i>Cancel</a>
			</div>
		</div>
		<div class="box-content">
                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                        <thead>
                                <th>Sno</th>
                                <th>Student Name</th>
                                <th>Marks/<?php echo $grec->weightage; ?></th>
                                <th>Comments</th>
                        </thead>
                        <tbody>
			<?php
				$i=1;
				foreach($students as $student){
					$r=$model->getStudentMark($student->id,$gbeid,$mrec);
					if($r)	$fl='u';
					else $fl='a';
					
					echo '<tr>';	
						echo '<td>'.$i++.'</td>';
						echo '<td width="35%">'.$student->firstname.' '.$student->middlename.' '.$student->lastname.' '.$student->initial.'</td>';
						echo '<td><input style="width:25px;" maxlength="3"  type="text" name="mark['.$student->id.']" value="'.$mrec->marks.'" /></td>';
						echo '<input type="hidden" name="fl['.$student->id.']" value="'.$fl.'" />';
						echo '<td><input style="width:500px;" maxlength="255" type="text" name="comment['.$student->id.']" value="'.$mrec->comments.'" /></td>';
					echo '</tr>';	
				}
			?>
                        </tbody>
                        </table>
                </div>
        </div>
<input type="hidden" name="view" value="exams" />
<input type="hidden" name="controller" value="exams" />
<input type="hidden" name="layout" value="marksentry" />
<input type="hidden" name="task" value="savemarksentry" />
<input type="hidden" name="classid" value="<?php echo $classid; ?>" />
<input type="hidden" name="subjectid" value="<?php echo $subjectid; ?>" />
<input type="hidden" name="termid" value="<?php echo $termid; ?>" />
<input type="hidden" name="gbeid" value="<?php echo $gbeid; ?>" />
<input type="hidden" name="eon" value="1" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<div class="pull-right">
<a class="btn btn-small btn-warning" style="width:50px;" href="<?php echo $close; ?>"><i class="icon-minus-sign"></i>Cancel</a>
<button class="btn btn-small btn-primary"  value="Save" name="save"> <i class="icon-plus icon-white"></i> Save</button>
</div>
</form>

<div class="pull-left">
<a class="btn btn-small btn-danger" style="width:100px;" href="<?php echo $deletemarks; ?>" onclick="return confirm('All the marks will be removed for this activity. \nAre you sure?');" ><i class="icon-minus-sign"></i>Reset Marks</a>
</div>

</div>
