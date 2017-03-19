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

						
	<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=timetable&controller=timetable&layout=printteachertimetable&hstaffid='.$hstaffid.'&subjectid='.$subjectid.'&tmpl=component&print=1" '.$href;
        }
?>			
			<div class="box">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Teacher Timetable</strong></h2>
						<div class="pull-right">
					<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&view=timetable&controller=timetable&layout=teachertimetable&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
								<label class="control-label" for="selectError">Select Teacher</label>
								<div class="controls">
								  <select id="selectError6" data-rel="chosen" name="hstaffid">
										<option value="">Select</option>
									<?php

											foreach($staffs as $staff) :
											echo "<option value=\"".$staff->id."\" ".($staff->id == $hstaffid ? "selected=\"yes\"" : "").">".$staff->firstname."</option>";
											if($staff->id == $hstaffid)
												$sname=$staff->firstname;
											endforeach;
									?>
								  </select>
       <button class="btn btn-primary" name="Go" value="Go"><i class="icon-upload"></i>Go</button>
 <a href=<?php echo $href; ?> ><span title="Print Timetable" class="icon32 icon-green icon-print"></span></a>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="viewteachertimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="teachertimetable" />
</form>
								</div>

						</div>
					</div>
					<div class="box-content">
<?php if($hstaffid){ ?>			
	
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
		




