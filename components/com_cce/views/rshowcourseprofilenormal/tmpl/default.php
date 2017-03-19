<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
  $model = & $this->getModel();
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
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
        $coursereportslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=coursereports&Itemid='.$masterItemid);
?>

<table width="100%" cellpadding="10">
        <tr style="border:none;"> <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2> <h2></h2>
                <h1 class="item-page-title"><?php echo $this->coursename.' '.$this->section; ?></h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br /> </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        

                </td>
        </tr>
</table>



<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span7">
  <h2><i class="icon-edit"></i> <strong>Students Management</strong></h2>
</div>
</div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Code</th>
            <th>Subject</th>
            <th>Subject Teacher</th>
            <th>Mark List</th>
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
                echo '<td align="center">';
                //$exams=$model2->getNGradeBook($this->courseid,$subject->id);
                $exams=$model2->getTNGradeBook();
                foreach($exams as $exam){
                        $link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=ngradebookmarks&view=nmarklist&layout=examreport&max='.$subject->marks.'&passmark='.$subject->passmark.'&title='.$exam->title.'&examid='.$exam->id.'&staff='.$s->firstname.'&subjectid='.$subject->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
                        echo "[<a href=\"$link\">".$exam->code."</a>]&nbsp;&nbsp;";
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
</div>
</div>



  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i><strong>Class Consolidated Reports:</strong></h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>SNO</th>
            <th>Exam Title</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
        <?php
      	$i=1;
                foreach($exams as $exam){
                        $link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=ngradebookmarks&view=nmarklist&layout=cexamreport&title='.$exam->title.'&examid='.$exam->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
                        echo "<tr><td>".$i."</td><td align=\"rigth\"><a href=\"$link\">".$exam->title."</a>&nbsp;&nbsp;</td><td>".$exam->duedate."</td></tr>";
			$i++;
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
      <h2><i class="icon-edit"></i><strong>Students Reports:</strong></h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Rno</th>
            <th>Name</th>
            <th>Grade Sheets</th>
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
		$rlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=ngradebookmarks&view=nmarklist&layout=overall&studentid='.$student->id.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
		//echo $student->firstname;
		echo "<a href=\"$rlink\">".$student->firstname."</a>";
		echo '</td>';
                echo '<td align="center">';
                $exams=$model2->getTNGradeBook();
                //$exams=$model2->getNGradeBooks($this->courseid,$subject->id);
                 foreach($exams as $exam){
                        $link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=ngradebookmarks&view=nmarklist&layout=sexamreport&studentid='.$student->id.'&&examid='.$exam->id.'&max='.$exam->marks.'&courseid='.$this->courseid.'&Itemid='.$Itemid);
                        echo "[<a href=\"$link\">".$exam->code."</a>]&nbsp;&nbsp;";
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
</div>
