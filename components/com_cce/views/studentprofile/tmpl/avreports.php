<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$termid = JRequest::getVar('termid');
	$courseid = JRequest::getVar('courseid');
	$activityid= JRequest::getVar('activityid');
	$arecs=$this->model->getAttitudesAndValues();
	$srecs=$this->model->getStudents($courseid);
	$r=$this->model->getTerm($termid,$trec);
	$r=$this->model->getCourse($courseid,$crec);
?>

<?php
	echo '<center><h1>'.$crec->coursename.' - Life Skills</h1><h3>['.$trec->term.']</h3></center>';
?>
<hr /> <br />
<?php
	   echo '<div  align="right"><ul>';
	   foreach($arecs as $arec){
		$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=cosreports&view=cosreports&layout=avreports&termid='.$termid.'&activityid='.$arec->id.'&courseid='.$courseid.'&Itemid='.$Itemid);
		echo '<li><a href="'.$link.'">'.$arec->activityname.'</a></li>';
	   }
	   echo '</ul></div>';
?>
<table border="1" cellspacing="2" cellpadding="3" class="school">
<?php
	   foreach($arecs as $arec){
		if($arec->id ==$activityid){
		echo "<tr><th colspan=\"5\" align=\"left\" ><h3>".$arec->activityname.'('.$arec->activitycode.')'."</h3></th></tr>";
		echo "<tr><th class=\"list-title\">#</th><th class=\"list-title\">RNo</th><th class=\"list-title\">Student Name</th><th class=\"list-title\">Marks/5</th><th class=\"list-title\">Descriptive Indicators</th></tr>";
		$i=1;
                foreach($srecs as $srec) {
?>
        	<tr>
                <td width="5%" style="vertical-align: top;"><?php echo $i++; ?></td>
                <td width="10%" style="vertical-align: top;"><?php echo $srec->registerno; ?></td>
                <td width="25%" align="left" style="vertical-align: top;"><?php echo $srec->firstname; ?></td>
<?php
		$r = $this->model->getAVCoSMarks($srec->id,$arec->id,$courseid,$termid,$data);	
?>			
                <td style="vertical-align: top;" width="5%"><?php echo $data[0]['marks']; ?></td>
		<th width="60%" align="left"><?php echo $data[0]['indicators']; ?></th>
		</tr>
<?php
	}
	break;
       }
}
?>
</table>
