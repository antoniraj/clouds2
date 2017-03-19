<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$termid = JRequest::getVar('termid');
	$courseid = JRequest::getVar('courseid');
	$activityid= JRequest::getVar('activityid');
	$arecs=$this->model->getLSActivities();
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
		$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=cosmarks&view=cosmarks&layout=lsmarks&termid='.$termid.'&activityid='.$arec->id.'&courseid='.$courseid);
		echo '<li><a href="'.$link.'">'.$arec->activityname.'</a></li>';
	   }
	   echo '</ul></div>';
?>
<table border="1" cellspacing="2" cellpadding="3" class="school">
<?php
	   foreach($arecs as $arec){
		if($arec->id ==$activityid){
?>		<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=cosmarks&task=savelsmarks'); ?>" method="POST" name="adminForm">
<?php
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
		$r = $this->model->getLSCoSMarks($srec->id,$arec->id,$courseid,$termid,$data);	
?>			
                <td style="vertical-align: top;" width="5%"><input type="text" name="marks[]" style="width: 40px;" value="<?php echo $data[0]['marks']; ?>" /></td>
		<th width="20%"><textarea name="indicators[]" style="height: 50px;" rows="5" cols="40"><?php echo $data[0]['indicators']; ?></textarea> </th>
		</tr>
		<input type="hidden" name="sid[]" value="<?php echo $srec->id; ?>" />
		<input type="hidden" name="mid[]" value="<?php echo $data[0]['id']; ?>" />
		<input type="hidden" name="rno[]" value="<?php echo $srec->registerno; ?>" />
<?php
		}?>
		<tr><td colspan="5"><input type="submit" value="Save" name="save" class="button_save" />
		<input type="hidden" name="aid" value="<?php echo $arec->id; ?>" />
		<input type="hidden" name="termid" value="<?php echo $termid; ?>" />
		<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="controller" value="cosmarks" />
		<input type="hidden" name="view" value="cosmarks" />
		<input type="hidden" name="layout" value="lsmarks" />
		<input type="hidden" name="task" value="savelsmarks" />
</form>
<?php
	break;
	}
       }
?>
</form>
</table>
