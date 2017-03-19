<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$photoDir = JURI::base() . 'components/com_cce/staffphoto/';
	$model = &$this->getModel();
        $user =& JFactory::getUser();
	$staffid = $model->getStaffIdByCode($user->username);
	$Itemid= JRequest::getVar('Itemid');
	$classes = $model->getTeacherClasses($staffid);	
	$r = $model->getStaff($staffid,$srec);	
?>
<div>
        <div style="float:right;">
           <img src="<?php echo $photoDir.'/'.$srec->staffcode.'.jpg'; ?>" alt="" style="width: 3.5cm; height: 4cm;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <h1>Welcome&nbsp;<?php echo $srec->hprefix.' '.$srec->firstname; ?>...!</h1>
        </div>
</div>
<hr /> <br />
<?php
	$al="left";
	foreach($classes as $class){
		$s=$model->getCourse($class->classid,$crec);
		if($s==true){
			if($crec->assessmenttype=='CCE'){
				$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourseprofile&courseid='.$crec->id.'&Itemid='.$Itemid);
				$rlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rshowcourseprofile&task=showcourseprofile&courseid='.$crec->id.'&Itemid='.$Itemid);
			}else{
				$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourseprofilenormal&courseid='.$crec->id.'&Itemid='.$Itemid);
				$rlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rshowcourseprofilenormal&task=showcourseprofilenormal&courseid='.$crec->id.'&Itemid='.$Itemid);
			}
		echo '<div style="float:left;">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '</div>';
		echo '<div style="float:'.$al.'; width:40%;">';
			echo '<font size="5"  color="darkblue">'.$crec->code.'</font>';
			//echo '<font size="20"><a href=\"$link\">".$crec->coursename.' - '.$crec->sectionname.' Section'."</a></h1>";
                	echo "<h2>$crec->coursename".' - '.$crec->sectionname." Section</h2>"; 
               	echo "<h3>".$crec->assessmenttype." Exam Pattern</h3>"; 
               	//echo '<h3><a href="'.$link.'">Enter Marks</a></h3>';
          	echo '<h3><a href="'.$link.'"><img src="'.$iconsDir.'/entermarks.png'.'" alt="Enter Marks" style="width: 32px; height: 42px;" /></a><a href="'.$rlink.'"><img src="'.$iconsDir.'/generatemarks.png'.'" alt="Generate Marks" style="width: 32px; height: 42px;" /></a></h3>';
	//	echo '<h3><a href="'.$rlink.'">Generate Reports</a></h3>'; 
	?>
<br />
<h3>Students' Profiles:</h3>
<table class="school" border="0" cellspacing="5" cellpadding="5">
<tr><th class="list-title">Rno</th><th class="list-title">Name</th></tr>
<?php
	$students = $model->getStudents($class->classid);
        foreach($students as $student)
        {
                echo '<tr>';
                echo '<td>';
                echo $student->registerno;
                echo '</td>';
                echo '<td>';
        	$slink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=profile&id='.$student->id);
                echo '<a href="'.$slink.'">'.$student->firstname.'</a>';
                echo '</td>';
                echo '</tr>';
        }

	echo '</table>';
	echo '</div>';
	echo '<div style="float:right;">';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '</div>';
	}
		if($al=='left') $al='right';
						
	}

?>
