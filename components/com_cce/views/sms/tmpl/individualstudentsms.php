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
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
 //       $pathway->addItem('SMS',$modulelink);
        $pathway->addItem('INDIVIDUAL SMS');




?>


<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>

<?php
        $this->showlinks();
?>

<!-- The following script is used to show the limit in the text area box -->
  <script src="http://code.jquery.com/jquery-1.5.js"></script>
<script>
$(document).ready(function () {

  $('#smstext').keypress(function (event) {
    var max = 315;
    var len = $(this).val().length;

    if (event.which < 0x20) {
      // e.which < 0x20, then it's not a printable character
      // e.which === 0 - Not a character
      return; // Do nothing
    }

    if (len >= max) {
      event.preventDefault();
    }

  });

  $('#smstext').keyup(function (event) {
    var max = 315;
    var len = $(this).val().length;
    var char = max - len;

    $('#textleft').text(char + ' characters left');

  });

});
</script>

				
<br />
<br />
<br />
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=sms&courseid='.$this->courseid.'&view=sms&task=displaystudents&layout=individualstudentsms'); ?>" method="POST" name="adminForm">
<table width="100%" border="0" cellspacing="2" cellpadding="3">
<tr>
<td width="50%" align="right">Select a Course/Class:<select name="courses" style="width:180px;"  onChange="submit();">
	<?php
		if($this->courseid)
			echo '<option value="'.$this->courseid.'">'.$this->code.'</option>';
		else
			echo '<option>--Select a Course--</option>';
		foreach($this->courses as $course)
		{
			if($this->courseid != $course->id)
				echo '<option value="'.$course->id.'">'.$course->code.'</option>';
		}	
	?>
	</select> <input type="submit" name="go" value="Go" class="button_go"></td>
</tr>
</table>
<input type="hidden" name="controller" value="sms" />
<input type="hidden" name="view" value="sms" />
<input type="hidden" name="layout" value="individualstudentsms" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="displaystudents"/>
</form>


<div class="row-fluid sortable">		
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=sms&courseid='.$this->courseid.'&view=sms&task=sendbatchstudentsms&layout=batchstudentsms'); ?>" method="POST" name="adminForm">
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
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
                 <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" />
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
                        //        $editor =& JFactory::getEditor();
                          //      $params = array( 'smilies'=> '0' , 'style'  => '1' , 'layer'  => '0' , 'table'  => '0' , 'clear_entities'=>'0');
                            //    echo $editor->display( 'smstext', 'Dear Parents,<br /><br /><br />Principal', '600', '200', '20', '20', false, null, null, null, $params );
                       ?>
 <textarea class="" id="smstext" name="smstext" style="width:400px;" rows="3" maxlength="300" >Dear Parents, Your GENDER NAME of CLASS ...  Thanks. Principal</textarea> <br />
<div id="textleft">315 characters left</div>


*** NAME,GENDER, CLASS and DATE  will be replaced with the actual values automatically.
                                                        </div>

                        </td>
                </tr>
		</table>

		<?php
		}else{?>
		<tr> <td colspan="13" align="center">... No Students .... </td></tr>
		<?php }
	 ?>
</table>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<td width="50%" align="right"><input type="submit" class="button_send" name="send" value="Send"> </td> </tr>
<input type="hidden" name="controller" value="sms" />
<input type="hidden" name="view" value="sms" />
<input type="hidden" name="layout" value="individualstudentsms" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="logindividualstudentsms"/>
<input type="hidden" name="to" value="<?php echo $course->code; ?>"/>
</table>
</div>
</form>
</div>
