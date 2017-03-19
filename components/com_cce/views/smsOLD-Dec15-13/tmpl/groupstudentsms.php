<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $model = & $this->getModel();
        $iconsDir1 = JURI::base() . 'components/com_cce/images';
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
        $modulelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);
?>

<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/smsqueue.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h1 class="item-page-title">STUDENTS GROUP SMS</h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1sms.png'; ?>" alt="Bulk SMS" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>


<br />
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=sms&groupid='.$this->groupid.'&view=sms&task=displaygroupstudents&layout=groupstudentsms'); ?>" method="POST" name="adminForm">
<table width="100%" border="0" cellspacing="2" cellpadding="3">
<tr>
<td width="50%" align="right">Select a Group/Group:<select name="groups" style="width:180px;"  onChange="submit();">
	<?php
		if($this->groupid)
			echo '<option value="'.$this->groupid.'">'.$this->groupname.'</option>';
		else
			echo '<option>--Select a Group--</option>';
		foreach($this->groups as $group)
		{
			if($this->groupid != $group->id)
				echo '<option value="'.$group->id.'">'.$group->groupname.'</option>';
		}	
	?>
	</select> <input type="submit" name="go" value="Go" class="button_go"></td>
</tr>
</table>
<input type="hidden" name="controller" value="sms" />
<input type="hidden" name="view" value="sms" />
<input type="hidden" name="layout" value="groupstudentsms" />
<input type="hidden" name="groupid" value="<?php echo $this->groupid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="displaygroupstudents"/>
</form>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=sms&groupid='.$this->groupid.'&view=sms&task=sendgroupstudentsms&layout=groupstudentsms'); ?>" method="POST" name="adminForm">

<table width="100%" border="1" cellspacing="5" cellpadding="3">
<tr>
        <th class="list-title" style="height:20px;" width="">RegNo</th>
        <th class="list-title" width="">StudentName</th>
        <th class="list-title" width="">Gen</th>
<?php
/*        <th class="list-title" width="">DateOfBirth</th>
        <th class="list-title" width="">BG</th>
        <th class="list-title" width="">BirthPlace</th>
        <th class="list-title" width="">Nationality</th>
        <th class="list-title" width="">MotherTongue</th>
        <th class="list-title" width="">Caste</th>
        <th class="list-title" width="">Address</th>
        <th class="list-title" width="">Phone</th>
*/ ?>
        <th class="list-title" width="">Mobile</th>
        <th class="list-title" width="">email</th>
</tr>
        <?php
		if($this->students){
                   foreach($this->students as $rec) {
                       // $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&task=edit&cid[]='.$rec->id);
        ?>
        <tr style="height:25px;">
                 <td><input type="checkbox" name="cid[]" id="cid[]" checked="true" value="<?php echo $rec->id; ?>" />
<?php
                  echo "$rec->registerno</td>";
                  echo "<td>$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
		//	$a=explode('-',$rec->dob); ";
		//	echo "<td>"$a[2]-$a[1]-$a[0]"; ";
                 echo "<td>$rec->gender</td>";
              //    echo "<td>$rec->bloodgroup</td>";
                  //echo "<td>$rec->birthplace</td>";
                  //echo "<td>$rec->nationality</td>";
                  //echo "<td>$rec->mothertongue</td>";
                  //echo "<td>$rec->caste</td>";
                  //echo "<td>"$rec->addressline1,<br />$rec->addressline2,<br />$rec->city,<br />$rec->state,<br />$rec->pincode,<br />$rec->country</td>";
                  //echo "<td>$rec->phone</td>";
                  echo "<td>$rec->mobile</td>";
                  echo "<td>$rec->email</td>";
?>
        </tr>
        <?php 
		  }?>
		<br />
		<table>
                <tr>
                        <td colspan="2"><h2>SMS Message</h2></td></tr><tr>
                        <td></td><td>
                        <?php
                                $editor =& JFactory::getEditor();
                                $params = array( 'smilies'=> '0' , 'style'  => '1' , 'layer'  => '0' , 'table'  => '0' , 'clear_entities'=>'0');
                                echo $editor->display( 'smstext', $this->rec->smstext, '600', '200', '20', '20', false, null, null, null, $params );
                        ?>

                        </td>
                </tr>
		</table>

		<?php
		}else{?>
		<tr> <td colspan="13" align="center">... No Students .... </td></tr>
		<?php }
	 ?>
</table>
<table border="0" width="100%">
<td width="50%" align="right"><input type="submit" class="button_send" name="send" value="Send"> </td> </tr>
<input type="hidden" name="controller" value="sms" />
<input type="hidden" name="view" value="sms" />
<input type="hidden" name="layout" value="groupstudentsms" />
<input type="hidden" name="groupid" value="<?php echo $this->groupid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="sendgroupstudentsms"/>
</table>
</form>
