<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/staffs.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Select Class Teachers</h1>
        </div>
</div>
<hr /><br />
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=classteachers&task=actionType&courseid=<?php echo $this->courseid; ?>'); ?>" method="POST" name="adminForm">
<table border="1" cellspacing="2" cellpadding="3">
<tr>
        <th class="list-title" width="">Option</th>
        <th class="list-title" width="">StaffCode</th>
        <th class="list-title" width="">StaffName</th>
        <th class="list-title" width="">Department</th>
        <th class="list-title" width="">email</th>
</tr>
        <?php
		if($this->staffs){
                   foreach($this->staffs as $rec) {
                       // $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffs&controller=staffs&task=edit&cid[]='.$rec->id);
        ?>
        <tr>
                 <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
                 <td><?php echo $rec->staffcode; ?></td>
                 <td><?php echo "$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname"; ?></td>
                 <td><?php echo $rec->department; ?></td>
                 <td><?php echo $rec->email; ?></td>
        </tr>
        <?php 
		  }
		}else{?>
		<tr> <td colspan="13" align="center">... No Staff .... </td></tr>
		<?php }
	 ?>
</table>
<table border="0" width="100%">
<tr><td width="50%" align="right"><input type="submit" class="button_add" name="Add" value="Assign"> </td> </tr>
<input type="hidden" name="controller" value="classteachers" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" id="view" name="view" value="assignstaff" />
<input type="hidden" name="task" id="task" value="save" />
<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
</table>
</form>
