<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$cmdf= JRequest::getVar('cmdf');
	$cbid= JRequest::getVar('cbid');
	$eon= JRequest::getVar('eon');
	if(! isset($eon)) $eon="0";
	
	setlocale(LC_MONETARY,"en_IN");
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('exams');
	$cbs = $model->getCourseBooks();
	if(!isset($cbid)) $cbid=$cbs[0]->id;

	$courses = $model->getCourseBookCourses($cbid);

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


<table border="0" width="100%"><tr>
<td width="80%" style="text-align:left;">
<b style="font: bold 15px Georgia, serif;">COURSE BOOK</b>
</td>
<td style="text-align:right;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=savenewcoursebook&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
		<button class="btn btn-small btn-warning" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> New Course Book</button>
		<input type="hidden" name="view" value="exams" />
		<input type="hidden" name="layout" value="coursebooks" />
		<input type="hidden" name="controller" value="exams" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="cbid" value="<?php echo $cbid; ?>" />
		<input type="hidden" name="cmdf" value="<?php echo '1'; ?>" />
		<input type="hidden" name="task" value="savenewcoursebook"/>
	</form>
</td>
<td style="text-align:right;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deletecoursebook&gbid='.$gbid.'&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
		<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
		<input type="hidden" name="view" value="exams" />
		<input type="hidden" name="controller" value="exams" />
		<input type="hidden" name="layout" value="coursebooks" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="cbid" value="<?php echo $cbid; ?>" />
		<input type="hidden" name="cmdf" value="<?php echo '2'; ?>" />
		<input type="hidden" name="task" value="deletecoursebook"/>
	</form>
</td>

</tr></table>				

<table border="0" width="100%"><tr><td style="text-align:left;">
<?php
if($cmdf!='1'){ 
?>
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=showcoursebook&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<select id="selectError" data-rel="chosen" onchange="submit();" style="width:300px;" name="cbid">
		<option value="">Select a Course Book</option>
		<?php
		foreach($cbs as $cb) :
			echo "<option value=\"".$cb->id."\" ".($cb->id == $cbid ? "selected=\"yes\"" : "").">".$cb->title."</option>";
		endforeach;
		?>
	</select>
<!--	<button class="btn btn-small btn-warning" value="go" name="Go"> <i class="icon-edit icon-white"></i>Go</button> -->
	<input type="hidden" name="view" value="exams" />
	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" name="layout" value="coursebook" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="cmdf" value="<?php echo '4'; ?>" />
	<input type="hidden" name="task" value="showcoursebook"/>
	</form>
<?php } ?>
</td>
<td width="50%" style="text-align:right;">
<?php
if($cmdf!='0'){ 
$s=$model->getCourseBook($cbid,$cbrec);
?>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=savecoursebook&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	Course Book Title&nbsp;&nbsp;<input type="text" name="title" value="<?php echo htmlspecialchars($cbrec->title); ?>" />
	<button class="btn btn-small btn-primary" value="Save" name="Save"> <i class="icon-edit icon-white"></i> Save</button>
	<input type="hidden" name="view" value="exams" />
	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" name="layout" value="coursebook" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="cbid" value="<?php echo $cbid; ?>" />
	<input type="hidden" name="cmdf" value="<?php echo '5'; ?>" />
	<input type="hidden" name="eon" value="<?php echo $eon; ?>" />
	<input type="hidden" name="task" value="savecoursebook"/>
</form>
<?php } ?>

</td>
</tr></table>

<?php
	if(strlen($cbid)>0){
		$parts = $model->getParts($cbid);
	}else 
		return;
?>

<?php
	//RECURSIVE FUNCTION TO DISPLAY THE SUBJECTS
	function displaySubjects($prec,$model,$psno,$csno,$l,$terms,$cbid){
		echo '<tr>';
			$editsubjectlink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=addeditsubject&subjectid='.$prec->id.'&partid='.$prec->partid.'&cbid='.$cbid.'&Itemid='.$Itemid);
			$deletesubjectlink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deletesubject&subjectid='.$prec->id.'&partid='.$prec->partid.'&cbid='.$cbid.'&Itemid='.$Itemid);
		//	echo '<td><input type="checkbox" name="cid[]" id="cid[]" value="'.$prec->id.'" /></td>';
			echo '<td>';
				if($csno==''){
					echo "$psno";
				}else{
				        echo $psno.'.'.$csno;
				}
			echo '</td>';
			echo '<td align="left">';
				$sp='';
				for($i=0;$i<$l;$i++) $sp=$sp.'&nbsp;&nbsp;&nbsp;';
				echo $sp.'<a href="'.$editsubjectlink.'">'.$prec->subjecttitle.'</a> [<a href="'.$deletesubjectlink.'">X</a>]';
			echo '</td>';
			echo '<td>'.$prec->subjectcode.'</td>';
			
			//To Display Terms and Grade Books
			$tterms=array();
			foreach($terms as $term){
				$tterms[]=$term->id;
				$addgblink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=listgradebooks&subjectid='.$prec->id.'&termid='.$term->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
				$rs=$model->getSubjectTermGradeBook($prec->id,$term->id,$gbrec);
				if($rs){
					if($model->getTGradeBook($gbrec->gbid,$grec)){
						$deletegblink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deletesubjectgradebook&subjectid='.$prec->id.'&termid='.$term->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
						echo '<td>'.htmlspecialchars($grec->title).' [<a href="'.$deletegblink.'"> X </a>]</td>';
					}
					else
						echo '<td></td>';
				}else{
					echo '<td><a href="'.$addgblink.'">[+]</a></td>';
				}
			}
			
			//SUMMARY COLS
			if(count($terms)>1){
				$str_terms = implode(",",$tterms);
				echo '<tD>';
				$serecs=$model->getSummaryEntries($prec->id);
				foreach($serecs as $serec){
					$editsummarylink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=summarycols&id='.$serec->id.'&subjectid='.$prec->id.'&subjecttitle='.$prec->subjecttitle.'&cbid='.$cbid.'&terms='.$str_terms.'&Itemid='.$Itemid);
					echo '<a href="'.$editsummarylink.'">'.$serec->title.'</a> | ';
				}
				$addsummarylink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=summarycols&subjectid='.$prec->id.'&subjecttitle='.$prec->subjecttitle.'&cbid='.$cbid.'&terms='.$str_terms.'&Itemid='.$Itemid);
				echo '<a href="'.$addsummarylink.'">[+]</a>';
				echo '</tD>';
			}


			
			//To Display Grading System
			$addgslink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=listgradingsystems&subjectid='.$prec->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
			if($model->getSubjectGradingSystem($prec->id,$gsrec)){
				if($model->getGradingSystem($gsrec->gsid,$ggs)){
					$deletegslink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deletesubjectgradingsystem&subjectid='.$prec->id.'&gsid='.$gsrec->gsid.'&cbid='.$cbid.'&Itemid='.$Itemid);
					echo '<td>'.htmlspecialchars($ggs->title).'<a href="'.$deletegslink.'"> [X]</a></td>';
				}else{
					echo '<td></td>';
				}
			}else{
				echo '<td><a href="'.$addgslink.'">[+]</a></td>';
			}
		echo '</tr>';

		$crecs = $model->getTSubjectChildEntries($prec->id);
		if(count($crecs)==0){
			return;
		}
		$csno=1;
		$l++;
		foreach($crecs as $crec){
			displaySubjects($crec,$model,$psno,$csno++,$l,$terms,$cbid);
		}
	}
?>



<!-- COURSE BOOK COURSES -->
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deletecoursebookcourses&cbid='.$cbid.'&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i>Courses</h2>
			<div class="box-icon">
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
				<?php 
					$courselistlink = JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=courselist&cbid='.$cbid.'&Itemid='.$Itemid);
				?>
				<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
                        	<a class="btn btn-small btn-success" style="width:100px;" href="<?php echo $courselistlink; ?>"><i class="icon-plus-sign"></i>Assign Courses</a>
			</div>
		</div>
		<div class="box-content">
                        <table class="table table-striped table-bordered ">
                        <thead>
				<th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
                                <th>Sno</th>
                                <th>Course Name</th>
                                <th>Section Name</th>
                                <th>Code</th>
                        </thead>
                        <tbody>
			<?php
				$i=1;
				foreach($courses as $crec){
					echo '<tr>';	
	                 			echo '<td><input type="checkbox" name="cid[]" id="cid[]" value="'.$crec->id.'" /> </td>';
						echo '<td>'.$i++.'</td>';
						echo '<td>'.$crec->coursename.'</td>';
						echo '<td>'.$crec->sectionname.'</td>';
						echo '<td>'.$crec->code.'</td>';
					echo '</tr>';	
				}
			?>
                        </tbody>
                        </table>
                </div>
        </div>
</div>
<input type="hidden" name="view" value="exams" />
<input type="hidden" name="controller" value="exams" />
<input type="hidden" name="layout" value="coursebooks" />
<input type="hidden" name="cbid" value="<?php echo $cbid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
</form>




<?php 

//DISPLAY PARTS -> TERMS -> SUBJECTS

foreach ($parts as $part){
	$addtermlink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=addeditterm&partid='.$part->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
	$editpartlink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=addeditpart&partid='.$part->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
	$terms = $model->getTTerms($part->id);
	$deletepartlink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deletepart&partid='.$part->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
	$srecs = $model->getTSubjects($part->id);
	$addsubjectlink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=addeditsubject&partid='.$part->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<i class="icon-edit"></i> <?php echo '<a href="'.$editpartlink.'">'.$part->title.'</a>'; ?>
			<div class="box-icon">
				<a class="btn btn-small btn-success" style="width:50px;" href="<?php echo $addsubjectlink; ?>"><i class="icon-plus-sign"></i>Subject</a>
				<a class="btn btn-small btn-danger" style="width:40px;"  href="<?php echo $deletepartlink; ?>"><i class="icon-trash icon-white"></i>Part</a>
				<a class="btn btn-small btn-warning" style="width:45px;" href="<?php echo $addtermlink; ?>"><i class="icon-plus-sign"></i>Term</a>
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered ">
			<thead>
				<th>Sno</th>
				<th>Subject</th>
				<th>Code</th>
			<?php
				foreach($terms as $term){
					$edittermlink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=addeditterm&termid='.$term->id.'&partid='.$part->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
					$deletetermlink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deleteterm&termid='.$term->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
					echo '<th><a  href="'.$edittermlink.'">'.$term->term.'</a> [ <a href="'.$deletetermlink.'">X</a> ]</th>';
				}
				if(count($terms)>1) echo '<th>Summary Columns</th>';
			?>
				<th>Grading System</th>
			</thead>
			<tbody>
  			<?php
                                        $precs=$model->getParentTSubjects($part->id);
                                        $j=1;
                                        if($precs){
                                                foreach($precs as $prec){
                                                        displaySubjects($prec,$model,$j++,'',0,$terms,$cbid);
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
$addpartlink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=addeditpart&cbid='.$cbid.'&Itemid='.$Itemid);
$markslink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=marks&cbid='.$cbid.'&Itemid='.$Itemid);
if(strlen($cbid)>0){
	$generategradebookslink =JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=generategradebooks&cbid='.$cbid.'&Itemid='.$Itemid);
?>
<a class="btn btn-small btn-info" style="width:50px;" href="<?php echo $addpartlink; ?>"><i class="icon-plus-sign"></i>Part</a>
<a class="btn btn-small btn-primary" style="width:150px;" href="<?php echo $generategradebookslink; ?>"><i class="icon-plus-sign"></i>Generate Grade Books</a>
<?php
}
?>


