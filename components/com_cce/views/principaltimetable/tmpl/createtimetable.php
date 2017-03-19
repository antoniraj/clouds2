<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $courseid= JRequest::getVar('courseid');
        $tttermid= JRequest::getVar('tttermid');
        $subjectid= JRequest::getVar('subjectid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model1 = & $this->getModel('managesubjects');
        $model = & $this->getModel('timetable');
	$terms = $model->getCurrentTimeTableTerms();
	$courses = $model->getCurrentCourses();
        $model->getCourse($courseid,$crec);
	$model->getTimeTableTerm($tttermid,$trec) ;
	$rs = $model1->getMSubjectsByCourse($courseid,$subjects);
	$sessions=$model->getCourseSessions($courseid,$tttermid);
	$days=$model->getCourseDays($courseid,$tttermid);

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
                        <h1 class="item-page-title" align="left">PROCESS TIME TABLE</h1>
                </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>

<br />
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
								  <select id="selectError6" data-rel="chosen" name="courses">
										<option value="">Select any option</option>
									<?php

											foreach($courses as $course) :
											echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
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
	 


	
						
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">			
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Subjects</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								  <th>Option</th>
								   <th>Subject Code</th>
									<th>Subject Name</th>
									<th>Acronym</th>
									<th>Staff</th>
									<th>Credits</th>
									<th>Alloted</th>
									<th>Balance</th>
							  </tr>
						  </thead>   
						  <tbody>
		     <?php
		
                if($subjects){
                   foreach($subjects as $srec) {
                       // $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjects&controller=subjects&task=edit&cid[]='.$rec->id);
        ?>
        <tr>
                <td>
		<?php
			if($subjectid == $srec->id){ ?>
				<input type="radio" id="optionsRadios1" checked="true" name="cid[]" id="cid[]" value="<?php echo $srec->id; ?>" /> 
			<?php }
			else {
			?>
				<input type="radio" id="optionsRadios1" name="cid[]" id="cid[]" value="<?php echo $srec->id; ?>" /> 
			<?php } ?>
				
		</td>
                 <td><?php echo $srec->subjectcode; ?></td>
                 <td><?php echo $srec->subjecttitle; ?></td>
                 <td><?php echo $srec->acronym; ?></td>
	<?php
 			$rs = $model1->getSubjectTeachers($courseid,$srec->id,$staffrecs);
                        echo "<td>";
                        foreach($staffrecs as $staff)
                        {
        //                        $dlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=ttremovestaff&courseid='.$courseid.'&subjectid='.$srec->id.'&Itemid='.$Itemid.'&staffid='.$staff->id);
                                echo "$staff->staffcode]&nbsp;$staff->firstname<br />";
                                //echo "(<a href=\"$dlink\">X</a>)[$staff->staffcode]&nbsp;$staff->firstname<br />";
                        }
                 	echo '<td>';
			echo $srec->credits; 
			echo '</td>'; 
                        echo "</td>"; 
			$rss=$model->getAllotedCredits($tttermid,$courseid,$srec->id);
			echo '<td>';
			echo $rss->total;
			echo '</td>';
			echo '<td>';
			echo ($srec->credits-$rss->total);
			echo '</td>';
	?>

        </tr>
        <?php
                  }
                }
         ?>
							 </tbody>
					  </table>     
	       			<div class="row-fluid">
						<div class="span12" align="right">
								<button class="btn btn-small btn-success" name="Allote" value="Allote"><i class="icon-plus-sign"></i> Allote</button>
						</div>
					</div>
					</div>

				</div><!--/span-->
			
			</div><!--/row-->

<?php if($courseid AND $tttermid)
{
	?>					
<table border="1" cellspacing="2" cellpadding="3" width="100%">
<?php
	echo '<tr>';
        echo '<th class="list-title">Day</th>';
	foreach ($sessions as $session)
        	echo '<th class="list-title" >'.$session->code.'<br ><font style="font-size:9px;">['.$session->start.'-'.$session->stop.']</font></th>';
	echo '</tr>';
	foreach ($days as $day){
		echo '<tr>';
        	echo '<th class="list-title2">'.$day->code.'</th>';
		foreach ($sessions as $session){
			$text=''; //Cell Contents
			$flag1=0;
			//Get Entry for the cell
        		$ttentries=$model->getTimeTableEntry($tttermid,$courseid,$day->id,$session->id);
			$i=1;
			foreach($ttentries as $ttentry){
				$flag1=1;
				if($i==1){
					$d1link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=removettentry&courseid='.$courseid.'&subjectid='.$ttentry->subjectid.'&Itemid='.$Itemid.'&tttermid='.$tttermid.'&sessionid='.$session->id.'&dayid='.$day->id);
					$rs=$model1->getMSubject($ttentry->subjectid,$subrec);
					if($rs) $text=$text .'(<a href="'.$d1link.'">X</a>)'. $subrec->subjectcode.'<br />';
					//if($rs) $text=$text .'<a href=\"$d1link\"><img src="'.$iconsDir.'/delete.png'.'" alt="Delete" style="width: 15px; height: 15px;" /></a>'. $subrec->subjectcode.'<br />';
				}
				
				//Display Staff
				$rs=$model->getStaff($ttentry->staffid,$staffrec);
				if($rs){
					$d2link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=removettstaffentry&courseid='.$courseid.'&subjectid='.$ttentry->subjectid.'&Itemid='.$Itemid.'&tttermid='.$tttermid.'&sessionid='.$session->id.'&dayid='.$day->id.'&staffid='.$staffrec->id);
					 $text=$text.'[(<a href="'.$d2link.'">X</a>)'.$staffrec->staffcode.']&nbsp;';
				}
				$i++;
			}

			//FIll with Red which is alreay been assigned for the staff
			$fillcolor='';
			$flag2=0;
 			$rs = $model1->getSubjectTeachers($courseid,$subjectid,$staffrecs);
			foreach($staffrecs as $frec){
                		$rs=$model->checkStaffEntry($tttermid,$day->id,$session->id,$frec->id);	
				if(count($rs)>0){
					$flag2=1;
					$fillcolor='#E17445';
					break;
				}
			}

			echo '<td style="background-color: '.$fillcolor.';color:FFF;" align="center">';
			//Set Check box in other cells
			if($flag1==0 && $flag2==0){
				echo '<input type="checkbox" name="ds[]"  value="'.$day->id.':'.$session->id.'" />';
			}

			echo $text;
			echo '</td>';
		}
		echo '</tr>';
	}
	
?>
</table>
<?php
} 
?>
<br>
<div class="form-actions">
							<div class="span11" align="right">
								<button class="btn btn-small btn-success" name="Save" value="Save"><i class="icon-plus-sign"></i> Save</button>
						</div>
</div>

<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="tttermid" value="<?php echo $tttermid; ?>" />
<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
<input type="hidden" name="task" value="processtimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="createtimetable" />
 </form>	
