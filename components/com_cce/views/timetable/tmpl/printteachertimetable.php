<style>
table.subjects{
	border-collapse:collapse;
}
table.subjects tr td{
	padding:6px;border:1px solid #919191;
	font-size:12px;
}
table.subjects tr th{
	background:#E8E8E8;
	padding:5px;
	border:1px solid #919191;
	font-size:14px;
	font-weight:bold;
}
</style>
<script>
window.print();
</script>

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
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
?>

<?php
	$model2=& $this->getModel('tngradebook');
	$model3=& $this->getModel('nmarks');
	$status=$model->getSchoolInfo($rec);
?>
<div style="border-bottom:10px;" align="center">

                <h1 style="font-size:26px;"><strong><?php echo $rec->schoolname; ?></strong></h1><br>
                <h3><?php echo $rec->schooladdress; ?></h3>
</div>	
<br>
<br>						
	 <?php 
 $model->getStaff($hstaffid,$staff_name);
 ?>
 <!-- Class Time Table-->
 <h1 align="center" style="margin-bottom:10px;font-size:20px;font-weight:bold;"> Time Table For <?php echo $staff_name->firstname;?></h1>		
<?php
     //   $rs=$model->getSessionCategoriesByDate($idate,&$scids);  //Get Session Categories for term: date->term->session categories
        $rs=$model->getSessionCategoriesByStaff($hstaffid,$tttermid,$scids);
        echo '<table cellpadding="0" width="100%" class="subjects">';
        echo '<tr>';
        foreach($scids as $scid){
                $sessions=$model->getSessions($scid->sid); //Get sessions for a session category
                echo '<th>Days</th>';
                foreach ($sessions as $session)  //Display the session headings
                        echo '<th >'.$session->code.'<br ><font style="font-size:9px;">['.$session->start.'-'.$session->stop.']</font></th>';
                echo '</tr>';
                //Get courses for each session category
		$rs=$model->getDaysByStaff($hstaffid,$tttermid,$day);
		$days = $model->getDays($day[0]->dcid);
		foreach($days as $day){
	                echo '<tr>';
        	        echo '<th>'.$day->code.'</th>';
                	foreach ($sessions as $session){  //For each session display the subject and staff members
				echo '<td align="center">';
				$rs = $model->getTTEntryByStaff($tttermid,$hstaffid,$session->id,$day->id,$rec);	
				if($rs){
					$rs=$model->getCourse($rec->courseid,$crec);
					echo '<b>'.$crec->code.'</b>';
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

					</div>
				</div>
<br>
<br>
<br>
<br>
<div align="right">
<h3>Principal's Signature</h3>
</div>



<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $hstaffid= JRequest::getVar('hstaffid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

	$sname='';
        $model1 = & $this->getModel('managesubjects');
        $model = & $this->getModel('timetable');
	$model->getSessions1($sessions);
	$model->getDays1($days);
		$terms = $model->getCurrentTimeTableTerms();
		$staffs=$model->getStaffs(); //Get all staff details for the combo box
		$model->getTimeTableTerm($tttermid,$trec) ;
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
?>

	
  <h1 align="center" style="margin-bottom:10px;font-size:20px;font-weight:bold;"><?php echo $sname;?></h1>
<?php
     //   $rs=$model->getSessionCategoriesByDate($idate,&$scids);  //Get Session Categories for term: date->term->session categories
//        echo '<table class="table table-striped table-bordered teachertimetable">';
	echo '<table cellpadding="3" width="100%" class="table-striped table-bordered">';
        echo '<tr>';
                echo '<th class="list-title">Days</th>';
                foreach ($sessions as $session)  //Display the session headings
		{
			$model->getSessionByCode($session->code,$ssrec);
                        echo '<th class="list-title" >'.$session->code.'<br ><font style="font-size:9px;">['.$ssrec->start.'-'.$ssrec->stop.']</font></th>';
		}
                echo '</tr>';


                //Get courses for each session category
		foreach($days as $day){
	                echo '<tr>';
        	        echo '<th class="list-title" >'.$day->code.'</th>';
   			$duration=0;
                	foreach ($sessions as $session){  //For each session display the subject and staff members
                        	if($duration>1){
                               	 	$duration--;
                                	continue;
                        	}
				$text=''; //Cell Contents
				//$rs = $model->getTTEntryByStaff($tttermid,$hstaffid,$session->id,$day->id,$rec);	
				$rs = $model->getTimetableEntryByStaff($hstaffid,$day->code,$session->code,$ttentries);	
				if($rs){
		                        $duration=0;
                		        if(count($ttentries)==1){
                                	        $text=$text . $ttentries[0]->subjectcode.'<br />';
                                        	$text=$text.'['.$ttentries[0]->classcode.']';
	                                        $duration=$ttentries[0]->duration;
        		                }else if(count($ttentries)>1){
                        		        $text=$ttentries[0]->subjectcode.'<br />';
	                                	$duration=$ttentries[0]->duration;
        		                	foreach($ttentries as $ttentry){
                        				$text=$text.'['.$ttentry->classcode.']&nbsp;';
                                		}
                        		}else{
                                		$text='---';
                        		}

                        		if($duration>1){
                                		echo '<td align="center" colspan="'.$duration.'">';
                                		echo $text;
                                		echo '</td>';
                        		}else{
                                		echo '<td  align="center">';
                                		echo $text;
                                		echo '</td>';
                        		}
				}
			}
                	echo '</tr>';
		} //end days
        	echo '</table>';
	}
?>
	</div>
</div>
		




