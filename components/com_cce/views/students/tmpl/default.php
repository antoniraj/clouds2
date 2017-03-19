
<?php
        defined('_JEXEC') OR DIE('Access denied..');
 
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$loader = JURI::base() . 'components/com_cce/loader/';
	$Itemid  = JRequest::getVar('Itemid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$photoDir = JURI::base() . 'components/com_cce/studentsphoto/';
	$path = JPATH_COMPONENT.DS.'studentsphoto'.DS;
   	$model = & $this->getModel('cce');
	$courseid = JRequest::getVar('courseid');
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&Itemid='.$studentsItemid);
	$execllink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&task=excel&controller=students&tmpl=component&layout=excel&courseid='.$this->courseid);


 	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
        $pathway->addItem('Home', $dashboardlink);
	$pathway->addItem('Students',$modulelink);
        $pathway->addItem('Class');

	if(!$courseid){
		$cstatus=$model->getCourse($this->courseid,$re);
	}else{
		$cstatus=$model->getCourse($courseid,$re);	
	}
?>

<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=studentprofile&controller=studentprofile&layout=profile&id='.$id.'&tmpl=component&print=1" '.$href;
        }
  
?>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-user"></i> Student Records</h2>
			<div style="float:right;margin-top:-2px;">
				<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
					<fieldset>
						<div class="control-group">
							<label class="control-label" for="selectError">Select Class</label>
							<div class="controls">
								<select id="selectError" data-rel="chosen" onchange="submit();" name="courses">
									<option value="se">Select</option> 
									<?php
										foreach($this->courses as $course) :
											echo "<option value=\"".$course->id."\" ".($course->id == $this->courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
										endforeach;
									?>
								</select>
							</div>
					</fieldset>
					<input type="hidden" name="controller" value="students" />
					<input type="hidden" name="view" value="students" />
					<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
					<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
					<input type="hidden" name="task" value="actions"/>
				</form>
				<div align="right">
				<a class="btn btn-info" href="<?php echo $execllink; ?>"><i class="icon-zoom-in icon-white"></i>  Export to Execl</a>
		<button class="btn btn-small btn-warning" name="View" value="View"><i class="icon-plus-sign icon-white"></i> View</button>
		<button class="btn btn-small btn-info" name="TC" value="TC"><i class="icon-plus-sign icon-white"></i> Transfer Cert</button>
		<button class="btn btn-small btn-danger" name="Conduct" value="Conduct"><i class="icon-plus-sign icon-white"></i> Conduct Cert</button>
		<button class="btn btn-small btn-primary" name="Attendance" value="Attendance"><i class="icon-plus-sign icon-white"></i> Attendance Cert</button>
		<button class="btn btn-small btn-warning" name="Bonafide" value="Bonafide"><i class="icon-plus-sign icon-white"></i> Bonafide Cert</button>
					<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Add</button>
					<button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit icon-white"></i> Edit</button>
					<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
				</div>				
			</div>
		</div>
	</div>
	
	<div class="box-content">
	<table class="table table-striped table-bordered bootstrap-datatable datatable stu-admission">
    		<thead>
		      <tr>
		        <th width="2%" class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
		        <th width="15%">Student Name</th>
		        <th width="5%">Gender</th>
		        <th width="5%">DOB</th>
		        <th width="5%">BG</th>
		        <th width="5%">Ad.No</th>
		        <th width="5%">Religion</th>
		        <th width="10%">Father Mobile</th>
		        <th width="10%">Father Name</th>
		        <th width="10%">Occupation</th>
		        <th width="10%">Mother Name</th>
		        <th width="10%">Community</th>
		        <th width="10%">Caste</th>
		        <th width="8%">Photo</th>
		      </tr>
	    	</thead>
		<tbody>
	      <?php
		if($this->students){
			foreach($this->students as $rec) {
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentstc&controller=studentstc&layout=entertc&task=display&sid='.$rec->id.'',false);	
				$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=profile&courseid='.$this->courseid.'&id='.$rec->id);
		?>
		<tr>
			<td><input type="checkbox"  name="cid[]" value="<?php echo $rec->id; ?>" /></td>
			<input type="hidden" name="studentphoto" value="<?php echo $rec->studentphoto; ?>" />
			<?php 
				echo "<td>$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
				echo "<td >";
				if($rec->gender=='F' || $rec->gender=='Female') echo "Female";
				if($rec->gender=='M' || $rec->gender=='Male') echo "Male";
				echo "</td>";
				$a=split("-",$rec->dob);
				$dob=$a[2].'-'.$a[1].'-'.$a[0];
				echo "<td>$dob</td>";
				echo "<td>$rec->bloodgroup</td>";
				echo "<td>$rec->ano</td>";
				echo "<td>$rec->religion</td>";
				echo '<td class="hidden-phone">'.$rec->mobile.'</td>';
				echo "<td>$rec->pfathername</td>";
				echo "<td>$rec->focc</td>";
				echo "<td>$rec->mothername</td>";
				echo "<td>$rec->community</td>";
				echo "<td>$rec->caste</td>";
				$fs=$model->getsiglestudentphoto($rec->id,$file);
				if(strlen(trim($file->imagename))>2){ ?>
					<center>
		        		<td  class="hidden-phone" ><img class="stu_image" src="<?php echo  $photoDir.$file->imagename;  ?>"  alt="photo"/></td>
	        			</center>
        		  <?php }else{ ?>
					<td  class="hidden-phone"><img class="stu_image" src="<?php echo $photoDir.'no-image.gif'; ?>" alt="photo" /></td>
			<?php }	?>	
		</tr>
	<?php
		}
	}
	?>
	</tbody>
</table>

<div class="form-actions">
	<div align="right">
		<button class="btn btn-small btn-warning" name="View" value="View"><i class="icon-plus-sign icon-white"></i> View</button>
		<button class="btn btn-small btn-info" name="TC" value="TC"><i class="icon-plus-sign icon-white"></i> Transfer Cert</button>
		<button class="btn btn-small btn-danger" name="Conduct" value="Conduct"><i class="icon-plus-sign icon-white"></i> Conduct Cert</button>
		<button class="btn btn-small btn-primary" name="Attendance" value="Attendance"><i class="icon-plus-sign icon-white"></i> Attendance Cert</button>
		<button class="btn btn-small btn-warning" name="Bonafide" value="Bonafide"><i class="icon-plus-sign icon-white"></i> Bonafide Cert</button>
		<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Add</button>
		<button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit icon-white"></i> Edit</button>
		<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
	</div>				
<br />
	<div>
		<form name="upload" method="post" enctype="multipart/form-data">
			Select a CSV file to import:
			<input class="input-file uniform_on" id="fileInput" type="file" name="recs">
			<button class="btn btn-small btn-info" name="import" value="import"><i class="icon-upload icon-white"></i> Upload</button>
			<input type="hidden" name="controller" value="students" />
			<input type="hidden" name="view" value="students" />
			<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
			<input type="hidden" name="task" value="importRecords"/>
		</form>
	</div>
</div>

</div>      
</div>
</div>


</div>
</div>
<!--/span-->
<!--/row-->

<input type="hidden" name="controller" value="students" />
<input type="hidden" name="view" value="students" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>

<!--
<A href="javascript: window.open('index2.php/component/cce/?controller=students&task=add&view=addstudent&courseid=2&Itemid=','','status=no, target=miniwin;targetfeatures=toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=600,'); void('');" )>HELLO</a>

-->
