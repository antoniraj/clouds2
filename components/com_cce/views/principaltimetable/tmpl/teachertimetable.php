<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $hstaffid= JRequest::getVar('hstaffid');
        $tttermid= JRequest::getVar('tttermid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model1 = & $this->getModel('managesubjects');
        $model = & $this->getModel('timetable');
	$terms = $model->getCurrentTimeTableTerms();
	$staffs=$model->getStaffs(); //Get all staff details for the combo box
	$model->getTimeTableTerm($tttermid,$trec) ;

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
                        <img src="<?php echo $iconsDir.'/createtimetable.png'; ?>" alt="" style="width: 44px; height: 44px;" />
                </div>
                <div style="float:left">
			<h1></h1>
                        <h1 class="item-page-title" align="left">TEACHER TIME TABLE</h1>
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

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<div class="row-fluid alert alert-warning">
<div class="span4">
							   <div class="control-group" >
								<label class="control-label" for="selectError">Select Class/Course</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" name="ttterms">
										<option value="">Select any option</option>
									<?php

											foreach($terms as $term) :
											echo "<option value=\"".$term->id."\" ".($term->id == $tttermid ? "selected=\"yes\"" : "").">".$term->term."</option>";
											endforeach;
									?>
								  </select>
								</div>
							  </div>
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
 <div class="span4">
       <button class="btn btn-small btn-info" name="Go" value="Go"><i class="icon-upload"></i>Go</button>
 </div>              
</div>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="tttermid" value="<?php echo $tttermid; ?>" />
<input type="hidden" name="task" value="viewteachertimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="teachertimetable" />
</form>



<?php
     //   $rs=$model->getSessionCategoriesByDate($idate,&$scids);  //Get Session Categories for term: date->term->session categories
        $rs=$model->getSessionCategoriesByStaff($hstaffid,$tttermid,$scids);

        echo '<table border="1" cellspacing="2" cellpadding="3" width="100%">';
        echo '<tr>';
        foreach($scids as $scid){
                $sessions=$model->getSessions($scid->sid); //Get sessions for a session category
                echo '<th class="list-title">Days</th>';
                foreach ($sessions as $session)  //Display the session headings
                        echo '<th class="list-title" >'.$session->code.'<br ><font style="font-size:9px;">['.$session->start.'-'.$session->stop.']</font></th>';
                echo '</tr>';
                //Get courses for each session category
		$rs=$model->getDaysByStaff($hstaffid,$tttermid,$day);
		$days = $model->getDays($day[0]->dcid);
		foreach($days as $day){
	                echo '<tr>';
        	        echo '<th class="list-title" >'.$day->code.'</th>';
                	foreach ($sessions as $session){  //For each session display the subject and staff members
				echo '<td align="center">';
				$rs = $model->getTTEntryByStaff($tttermid,$hstaffid,$session->id,$day->id,$rec);	
				if($rs){
					$rs=$model->getCourse($rec->courseid,$crec);
					echo $crec->code;
					echo '<br />';
					$rs=$model1->getMSubject($rec->subjectid,$srec);
					echo '['.$srec->subjectcode.']';
				}else
					echo '---';
				echo '</td>';
				
			}//end sessions
                	echo '</tr>';
		} //end days
	}//end session categories
        echo '</table>';

?>

<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="tttermid" value="<?php echo $tttermid; ?>" />
<input type="hidden" name="task" value="viewteachertimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="teachertimetable" />
 </form>	



