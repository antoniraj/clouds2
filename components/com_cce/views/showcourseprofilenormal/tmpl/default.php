<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
        $model = & $this->getModel();
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
        $entermarkslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourses&Itemid='.$masterItemid);

?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"><?php echo $this->coursename.' '.$this->section;?></h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
                        </div>
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


<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box-header well" data-original-title>
<div class="span7">
  <h2><i class="icon-edit"></i>Subjects & Teacher(s)</h2>
</div>

</div>
</div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Code</th>
            <th>Subject</th>
            <th>Subject Teacher</th>
            <th>Marks</th>
          </tr>
        </thead>
        <tbody>
      <?php
	$model2=& $this->getModel('tngradebook');
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
		
        	//$exams=$model2->getNGradeBook($this->courseid,$subject->id);
        	$exams=$model2->getTNGradeBook();
		echo '<td>';
		foreach($exams as $exam){
			$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=ngradebookmarks&view=nmarklist&layout=default&max='.$subject->marks.'&title='.$exam->title.'&examid='.$exam->id.'&subjectid='.$subject->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
			echo "[<a href=\"$link\">".$exam->code."</a>]&nbsp;";
		}
		echo '</td>';

		echo '</tr>';
	}
?>
        </tbody>
      </table>
    </div>
    <!--/span--> 
    
  </div>
  <!--/row-->



  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i>Students</h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Rno</th>
            <th>Name</th>
            <th>Date Of Birth</th>
            <th>Gender</th>
          </tr>
        </thead>
        <tbody>
</tr>
<?php
	foreach($this->students as $student)
	{
		echo '<tr>';
		echo '<td>';
		echo $student->registerno;
		echo '</td>';
		echo '<td>';
		echo $student->firstname.' '.$student->middlename.' '.$student->lastname;
		echo '</td>';
		echo '<td>';
		echo JArrayHelper::indianDate($student->dob);
		echo '</td>';
		echo '<td>';
		echo $student->gender;
		echo '</td>';
		echo '</tr>';
	}
?>
        </tbody>
      </table>
    </div>
    <!--/span--> 
    
  </div>
  <!--/row-->
