<?php
        defined('_JEXEC') OR DIE('Access denied..');

	
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$examid=JRequest::getVar('examid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$courseid=JRequest::getVar('courseid');
	$subjectid=JRequest::getVar('subjectid');	
	$title=JRequest::getVar('title');
	$max=JRequest::getVar('max');
        $iconsDir1 = JURI::base() . 'components/com_cce/images';
        $model = & $this->getModel();
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
        $entermarkslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourses&Itemid='.$masterItemid);
        $classlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourseprofilenormal&courseid='.$this->courseid.'&Itemid='.$masterItemid);



?>

<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
                <div style="float:left">
                        <img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="" style="width: 64px; height: 64px;" />
                </div>
                <div style="float:left">
			<h1></h1>
                        <h1 class="item-page-title" align="left"><?php echo $this->code; ?></h1>
                </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
             <div style="float:right;">
                   <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Master" style="width: 28px; height: 28px;" /></a><br />
             </div>
             <div style="float:right; width:10px;"> &nbsp;</div>
             <div style="float:right;">
                  <a href="<?php echo $classlink; ?>"><img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="Enter Marks" style="width: 28px; height: 28px;" /></a><br />
             </div>
                </td>
        </tr>
</table>

<?php
	$status=$this->model->getNGradeBookEntry($examid,$examrec);
?>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">			
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						
	<div class="span4">
			<button class="btn btn-small btn-success" name="save" value="save"><i class="icon-plus-sign icon-white"></i> Save</button>

	</div>			

<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					   
					</div>
					<div class="box-content">
	<div class="span12">		
	<div class="span4">
		  <h2 class="item-page-title"><?php echo '['.$this->srec->subjectcode.'] '.$this->srec->subjecttitle; ?></h2>
	</div>
	<div class="span4">
		 <h2 class="item-page-title" align="left"><?php echo $title; ?></h2>
	</div>
	<div class="span4">
		<h2 class="item-page-title" align="left"><?php echo $this->crec->coursename.'-'.$this->crec->sectionname; ?></h2>
	</div>
	</div>	
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								<th width="7%">SNO</th>
								<th width="10%">RNO</th>
								<th width="25%">NAME</th>
								<th width="8%">MARK/<?php echo $max; ?></th>
								<th width="10%">COMMENTS</th>
							  </tr>
						  </thead>   
						  <tbody>
<?php
		$i=1;
		foreach($this->students as $student)
		{
		        $this->model->getNMarks($student->id,$examid,$subjectid,$courseid,$mrec);
			$mlink=JRoute::_('index.php?option=com_cce&controller=ngradebookmarks&task=addnmarks&view=nmarklist&marksid='.$mrec->id.'&studentid='.$student->id.'&subjectid='.$subjectid.'&examid='.$examid.'&max='.$max.'&firstname='.$student->firstname.'&atitle='.$examrec->title.'&rno='.$student->registerno.'&courseid='.$courseid);
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$student->registerno.'</td>';	
			echo '<td>'.$student->firstname.'</a></td>';
			//echo '<td><a href="'.$mlink.'">'.$student->firstname.'</a></td>';
			?>		  
		  <td style="vertical-align: top;" width="5%"><input type="text" name="marks[]" style="width: 40px;" value="<?php echo $mrec->marks; ?>" /></td>
		
		<?php	
			echo '<td><input type="text" name="comments[]" maxlength="100" size="20px"  value="'.$mrec->comments.'"></td>';
			echo '</tr>';
			echo '<input type="hidden" name="sid[]" value="'.$student->id.'">';
			echo '<input type="hidden" name="mid[]" value="'.$mrec->id.'">';
			echo '<input type="hidden" name="rno[]" value="'.$student->registerno.'">';
			$i++;
		}
	?>
							 </tbody>
					  </table>     
	       			<div class="row-fluid">
						<div class="span6">
								<button class="btn btn-small btn-success" name="Save" value="Save"><i class="icon-plus-sign"></i> Save</button>
						</div>
					</div>
					</div>

				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" name="task" value="savemarkss" />
	<input type="hidden" id="view" name="view" value="nmarklist" />
	<input type="hidden" id="controller" name="controller" value="ngradebookmarks" />
	<input type="hidden" id="id" name="id" value="<?php echo $mrec->id; ?>" />
	<input type="hidden" id="courseid" name="courseid" value="<?php echo $courseid; ?>" />
	<input type="hidden" id="subjectid" name="subjectid" value="<?php echo $subjectid; ?>" />
	<input type="hidden" id="studentid" name="studentid" value="<?php echo $student->id; ?>" />
	<input type="hidden" id="examid" name="examid" value="<?php echo $examid; ?>" />
	<input type="hidden" id="max" name="max" value="<?php echo $max; ?>" />
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" id="title" name="title" value="<?php echo $title; ?>" />
</form>



