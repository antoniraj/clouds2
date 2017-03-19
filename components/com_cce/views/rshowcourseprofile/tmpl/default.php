<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$Itemid = JRequest::getVar('Itemid');
        $model = & $this->getModel();

        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
        $gradeslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=coursereports&Itemid='.$masterItemid);

?>

<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;"> <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/report3.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2> <h2></h2>
                <h1 class="item-page-title"><?php echo $this->coursename; ?></h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br /> </div>
                       <div style="float:right; width:10px;"> &nbsp;</div>
                       <div style="float:right;">
                       <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $gradeslink; ?>"><img src="<?php echo $iconsDir1.'/StudentProgressReport.png'; ?>" alt="Courses" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>




<?php 	
	foreach($this->classteachers as $cts)
	{
	 	$s=$this->model->getStaff($cts->staffid,$staffrec);
		echo '<br/>';
	}
?>

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
</thead>
<tbody>
<?php
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
		$terms=$this->model -> getCurrentTerms();
		foreach($terms as $term)
		{	
			echo '<td>';
			$ccelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&task=classtermreport&termid='.$term->id.'&subjectid='.$subject->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
			echo "<center>[<a href=\"$ccelink\">".$term->term."</a>]</center>";
			echo '</td>';
		}

		echo '</tr>';
	}
?>
</tbody>
</table>
</div>
</div>
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
<tr><th class="list-title">Area</th><th class="list-title" colspan="3"> Grades</th></tr>
</thead>
<body>
<?php
        $subjects = array('lsreports'=>'Life Skills','avreports'=>'Attitude and Values','cosareports'=>'Wellness and Yoga/Holistic Exercise','cosbreports'=>'Co-Curricular Activities');
        foreach($subjects as $key=>$sub){
                echo '<tr>';
                echo '<td>'.$sub.'</td>';
                foreach($terms as $term){
                        echo '<td>';
                        $ccelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=cosreports&view=cosreports&layout='.$key.'&task=display&termid='.$term->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
                        echo "<center>[<a href=\"$ccelink\">".$term->term."</a>]</center>";
                        echo '</td>';
                }
                echo '</tr>';
        }
?>
</body>
</table>
</div>
</div>
</div>
<br />
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
            <th class="list-title">Terms</th>
                <th class="list-title">Terms</th>
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
		$rstudentlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&layout=studentcons&task=studenttermreport&report=2&tmpl=component&studentid='.$student->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
		echo "<a href=\"$rstudentlink\">".$student->firstname."</a>";
		foreach($terms as $term)
		{	
			echo '<td>';
			$rstudentlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&report=1&view=rclasstermreport&layout=student&task=studenttermreport&termid='.$term->id.'&studentid='.$student->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
			echo "<center>[<a href=\"$rstudentlink\">".$term->term."</a>]</center>";
			echo '</td>';
		}
		echo '</tr>';
	}
?>
</tbody>
</table>
</div>
</div>
</div>
</div>
