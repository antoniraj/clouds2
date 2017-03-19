<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $hstaffid = JRequest::getVar('hstaffid');
        $idate= JRequest::getVar('idate');
	if(!$idate) $idate=date('d-m-Y');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model = & $this->getModel('timetable');
        $model1 = & $this->getModel('managesubjects');

//

//
?>
<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10" style="border:none;">
        <tr style="border:none;">
                <td style="border:none;" align="left">
                <div style="float:left">
                        <img src="<?php echo $iconsDir.'/institutetimetable.png'; ?>" alt="" style="width: 44px; height: 44px;" />
                </div>
                <div style="float:left">
                        <h1 class="item-page-title" style="font-size:15px;"><b>INSTITUTIONAL TIME TABLE</b></h1>
                </div>
                </td>
        </tr>
</table>


<form action="<?php echo JRoute::_('index.php'); ?>" method="POST" name="adminForm">
<table border="0px" cellspacing="2" width="100%" cellpadding="3">
<tr style="border:none;">
<td  style="border:none;" width="100%" align="right">
<?php //$idate= date("d-m-Y"); ?>
Select the date:<?php  echo JHTML::calendar($idate,'idate','idate','%d-%m-%Y'); ?> 
<input type="submit" name="Go" value="Go" class="button_go">
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="institutetimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="rinstitutetimetable" />
</td>
</tr>
</table>
<?php
	$rs=$model->getDayByDate($idate,$dayrec); //Dayorder record using calendar: date->cal->dayorderid
	$staffs=$model->getStaffs(); //Get all staff details for the combo box
	$rs=$model->getTTTermidByDate($idate,$termrec); //get termid using the date
	echo '<h3 class="item-page-title">'.$dayrec->title.'['.$dayrec->code.']</h3>'; 
	$rs=$model->getSessionCategoriesByDate($idate,$scids);  //Get Session Categories for term: date->term->session categories

	echo '<table border="1" cellspacing="2" cellpadding="3" width="100%">';
	echo '<tr style="border:1px; border-color:grey;">';
	foreach($scids as $scid){
		$sessions=$model->getSessions($scid->sid); //Get sessions for a session category
        	echo '<th class="list-title" style="border-color:grey; background-color:#ff8200; color:white;">Course</th>';
		foreach ($sessions as $session)  //Display the session headings
        		echo '<th class="list-title" style="border-color:grey; background-color:#ff8200; color:white;">'.$session->code.'</th>';
			//echo '<font style="font-size:9px;">['.$session->start.'-'.$session->stop.']</font></th>';
		echo '</tr>';
		//Get courses for each session category
		$courseids=$model->getCourseidsByDate($idate,$scid->sid);
		foreach($courseids as $course){ //For each course display the sessions
        		$rs=$model->getCourse($course->cid,$crec);
			echo '<tr style="border:1px; border-color:grey;">';
        		echo '<th class="list-title" style="border:1px; border-color:grey; background-color:#ff8200; color:white;" >'.$crec->code.'</th>';
			foreach ($sessions as $session){  //For each session display the subject and staff members
				$rs=$model->getTTSubjectid($crec->id,$session->id,$dayrec->id,$obj);
				if($rs){
					$staffids=$model->getTTStaffids($course->cid,$session->id,$dayrec->id,$obj->subjectid);
					echo '<td style=" border-color:grey;" align="center">';
					$rs=$model1->getMSubject($obj->subjectid,$subrec);
					echo $subrec->subjectcode;
					echo '<br />';
					foreach($staffids as $staff){
						$rs=$model->getStaff($staff->staffid,$staffrec);
						if($hstaffid==$staff->staffid) //HIghtlight the code 
							echo '[<FONT COLOR="#ff0000"><FONT FACE="LMSans10, sans-serif"><FONT SIZE=2><B>'.$staffrec->staffcode.'</B></FONT></FONT></FONT>]&nbsp;';
						else
							echo '['.$staffrec->staffcode.']&nbsp;';
					}
					echo '</td>';
				}else{
					echo '<td style=" border-color:grey;" align="center">';
					echo '</td>';
				}
				
			}
			echo '</tr>';	
		}
	}
	echo '</table>';

?>
<table borde="0" width="100%" cellspacing="2" cellpadding="3">
<tr style="border:none;">
<td  style="border:none;"width="50%" align="right">
<br />
Select Staff:<select name="hstaffid">
        <?php
                if($hstaffid){
			$model->getStaff($hstaffid,$hstaffrec);
                        echo '<option value="'.$hstaffid.'">'.$hstaffrec->hprefix.' '.$hstaffrec->firstname.'</option>';
		}
                else
                        echo '<option>--Select Staff--</option>';
                foreach($staffs as $staff)
                {
                        if($hstaffid != $staff->id)
                                echo '<option value="'.$staff->id.'">'.$staff->hprefix.' '.$staff->firstname.'</option>';
                }
        ?>
        </select>
	<input type="submit" name="show" value="Show" class="button_go">
</td>
</tr>
</table>


</form>
