<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$model = & $this->getModel('managesubjects');
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
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=courses&Itemid='.$masterItemid);
   	$slink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=subjects&view=subjects&task=display&Itemid='.$masterItemid);
?>

<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/subjects.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1 class="item-page-title">Subjects Management</h1>
        </div>
</div>

<?php
return;
?>
<hr /> <br />
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=subjects&courseid='.$this->courseid.'&task=actionType'); ?>" method="POST" name="adminForm">
<table borde="0" cellspacing="2" cellpadding="3">
<tr>
<td width="40%" align="right">Select a Course:</td>
<td width="50%" align="right">
	<select name="courses">
	<?php
		if($this->courseid)
			echo '<option value="'.$this->courseid.'">'.$this->coursename.'('.$this->sectionname.')'.'</option>';
		else
			echo '<option>--Select a Course--</option>';
		foreach($this->courses as $course)
		{
			if($this->courseid != $course->id)
				echo '<option value="'.$course->id.'">'.$course->coursename.'('.$course->sectionname.')</option>';
		}	
	?>
	</select>
</td>
<td width="10"> <input type="submit" name="go" value="Go" class="button_go"></td>
</tr>
</table>
<table border="1" cellspacing="2" cellpadding="3">
<tr>
        <th class="list-title" width="5%">Option</th>
        <th class="list-title" width="40%">Subject Name</th>
        <th class="list-title" width="35%">Subject Code</th>
        <th class="list-title" width="20%">Hrs/Wk</th>dfdfd
</tr>
        <?php
		if($this->subjects){
                   foreach($this->subjects as $rec) {
                       // $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjects&controller=subjects&task=edit&cid[]='.$rec->id);
        ?>
        <tr>
                 <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
                 <td><?php echo $rec->subjectname; ?></td>
                 <td><?php echo $rec->subjectcode; ?></td>
                 <td><?php echo $rec->hoursperweek; ?></td>
        </tr>
        <?php 
		  }
		}else{?>
		<tr> <td colspan="4" align="center">... No Subjects .... </td></tr>
		<?php }
	 ?>
</table>
<br />
<table border="0" width="100%">
<tr style="border:none;"> <td style="border:none;" width="50%"><input type="submit" class="button_delete"  value="Delete" name="Delete">
<input type="submit" class="button_edit" name="Edit" value="Edit"></td>
<td style="border:none;" width="50%" align="right"><input type="submit" class="button_add" name="Add" value="Add"> </td> </tr>
<input type="hidden" name="controller" value="subjects" />
<input type="hidden" name="view" value="subjects" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="task" value="actions"/>
</table>
</form>
