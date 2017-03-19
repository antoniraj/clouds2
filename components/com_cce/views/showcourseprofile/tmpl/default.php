<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid  = JRequest::getVar('Itemid');
        $model = & $this->getModel();

        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
	$entermarkslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourses&Itemid='.$masterItemid);
?>

<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;"> <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/entermarks.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2> <h2></h2> 
                <h1 class="item-page-title"><?php echo $this->code; ?></h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br /> </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $entermarkslink; ?>"><img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="Enter Marks" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>

<br />
<!--
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/courses.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h2>Course Profile</h2>
        </div>
</div>

<hr /> <br />
<h2>Class Teacher(s)</h2>
<table class="school" cellspacing="5" cellpadding="5">
<tr><td>Staff Names:</td><td>
<?php 	
	foreach($this->classteachers as $cts)
	{
	 	$s=$this->model->getStaff($cts->staffid,$staffrec);
		echo "$staffrec->firstname&nbsp;$staffrec->middlename&nbsp;$staffrec->lastname";
		echo '<br/>';
	}
?>
</td>
</tr>
</table>
<br />
-->
<div class="alert alert-warning" align="left">
<span class="mytitle">Part-1: Academic Performance(Scholastic Areas)</span>
</div>
	<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> <strong>Subjects & Teacher(s)</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
<tr><th class="list-title">Code</th><th class="list-title">Subject</th><th class="list-title">Subject Teacher</th><th class="list-title" colspan="3">Marks</th</tr>
<tbody>
<?php
	$terms=$this->model -> getCurrentTerms();
	foreach($this->subjects as $subject)
	{
		echo '<tr>';
		echo '<td>';
		echo $subject->subjectcode;
		echo '</td>';
		echo '<td>';
		echo $subject->subjecttitle;
		echo '</td>';
		echo '<td>';
		$this->model->getSubjectTeachers($this->courseid,$subject->id,$staff);
		foreach($staff as $s)
		{
			echo $s->firstname;
			echo '<br />';
		}
		echo '</td>';
		foreach($terms as $term)
		{	
			echo '<td>';
			$ccelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=gradebook&task=display&termid='.$term->id.'&subjectid='.$subject->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
			echo "<center>[<a href=\"$ccelink\">".$term->term."</a>]</center>";
			echo '</td>';
		}

		echo '</tr>';
	}
?>
</tbody>
</table>
					</div>
				</div><!--/span-->
				</div>
<br />
<div class="alert alert-warning" align="left">
<span class="mytitle">Part-2: Co-Scholastic Areas</span>
</div>
	<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> <strong></strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
<tr><th class="list-title">Area</th><th class="list-title" colspan="3">Enter Grades</th></tr></thead>
<tbody>
<?php
	$subjects = array('lsmarks'=>'Life Skills','avmarks'=>'Attitude and Values','cosamarks'=>'Wellness and Yoga/Holistic Exercise','cosbmarks'=>'Co-Curricular Activities');
	foreach($subjects as $key=>$sub){
		echo '<tr>';
		echo '<td>'.$sub.'</td>';
		foreach($terms as $term){
			echo '<td>';
			$ccelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=cosmarks&view=cosmarks&layout='.$key.'&task=display&termid='.$term->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
			echo "<center>[<a href=\"$ccelink\">".$term->term."</a>]</center>";
			echo '</td>';
		}
		echo '</tr>';
	}
?>
</tbody>
</table>
					</div>
				</div><!--/span-->
				</div>
				</div>

  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i><strong>Students Reports:</strong></h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Rno</th>
            <th>Name</th>
          </tr>
        </thead>
        <tbody>
<?php
	foreach($this->students as $student)
	{
		echo '<tr>';
		echo '<td>';
		echo $student->registerno;
		echo '</td>';
		echo '<td>';
		echo $student->firstname;
		echo '</td>';
		echo '</tr>';
	}
?>
</tbody>
</table>
</div>
</div>
</div>
</div>