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

        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Time Table');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $ttItemid = $model->getMenuItemid('manageschool','Create Time Table');
        if($ttItemid) ;
        else{
                $ttItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
?>
<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
                <div style="float:left">
                        <img src="<?php echo $iconsDir.'/institutionaltimetable.png'; ?>" alt="" style="width: 44px; height: 44px;" />
                </div>
                <div style="float:left">
			<h1></h1>
                        <h1 class="item-page-title" align="left">INSTITUTIONAL TIME TABLE</h1>
                </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>

<br />

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<div class="row-fluid alert alert-warning">
<div class="span3">
</div>
<div class="span4">
							<div class="control-group">
							  <label class="control-label" for="date01">Date input</label>
							  <div class="controls">
								<input type="text" class="input-xlarge datepicker" name="idate" id="date08" value="<?php echo $idate; ?>">
							  </div>
							</div>
</div>
 <div class="span4">
       <button class="btn btn-small btn-info" name="Go" value="Go"><i class="icon-upload"></i>Go</button>
 </div>              
</div>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="institutetimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="institutetimetable" />
</form>

<?php
	$rs=$model->getDayByDate($idate,$dayrec); //Dayorder record using calendar: date->cal->dayorderid
	$staffs=$model->getStaffs(); //Get all staff details for the combo box
	$rs=$model->getTTTermidByDate($idate,$termrec); //get termid using the date
	echo '<h2 class="item-page-title">'.$dayrec->title.'['.$dayrec->code.']</h2>'; 
	$rs=$model->getSessionCategoriesByDate($idate,$scids);  //Get Session Categories for term: date->term->session categories

	echo '<table border="1" cellspacing="2" cellpadding="3" width="100%">';
	echo '<tr>';
	foreach($scids as $scid){
		$sessions=$model->getSessions($scid->sid); //Get sessions for a session category
        	echo '<th class="list-title">Courses</th>';
		foreach ($sessions as $session)  //Display the session headings
        		echo '<th class="list-title" >'.$session->code.'<br ><font style="font-size:9px;">['.$session->start.'-'.$session->stop.']</font></th>';
		echo '</tr>';
		//Get courses for each session category
		$courseids=$model->getCourseidsByDate($idate,$scid->sid);
		foreach($courseids as $course){ //For each course display the sessions
        		$rs=$model->getCourse($course->cid,$crec);
			echo '<tr>';
        		echo '<th class="list-title" >'.$crec->code.'</th>';
			foreach ($sessions as $session){  //For each session display the subject and staff members
				$rs=$model->getTTSubjectid($crec->id,$session->id,$dayrec->id,$obj);
				if($rs){
					$staffids=$model->getTTStaffids($course->cid,$session->id,$dayrec->id,$obj->subjectid);
					echo '<td align="center">';
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
echo '<td>---</td>';

				}
			}
			echo '</tr>';	
		}
	}
	echo '</table>';

?>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<div class="row-fluid alert alert-warning">
<div class="span3">
</div>
<div class="span4">
							   <div class="control-group" >
								<label class="control-label" for="selectError">Select Class/Course</label>
								<div class="controls">
								  <select id="selectError6" data-rel="chosen" name="hstaffid">
										<option value="">Select any option</option>
									<?php

											foreach($staffs as $staff) :
											echo "<option value=\"".$staff->id."\" ".($staff->id == $hstaffid ? "selected=\"yes\"" : "").">".$staff->firstname."</option>";
											endforeach;
									?>
								  </select>
								</div>
							  </div>
</div>
 <div class="span1">
       <button class="btn btn-small btn-info" name="show" value="Show"><i class="icon-upload"></i>Show</button>
 </div>              
</div>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="institutetimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="institutetimetable" />
</form>
<br>

<br>
<br>


