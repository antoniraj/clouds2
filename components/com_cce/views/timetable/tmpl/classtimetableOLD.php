<style>
table.subjects{
	border-collapse:collapse;
}
table tr td{
	padding:4px;border:1px solid #ccc;
	font-size:12px;
}
table tr th{
	background:#E8E8E8;
	padding:5px;
	border:1px solid #919191;
	font-size:14px;
	font-weight:bold;
}
</style>
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
                        <h1 class="item-page-title" align="left">CLASS TIME TABLE</h1>
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
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong> View Class Timetable</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						
						<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
							   <div class="control-group" >
								<label class="control-label" for="selectError">Select Term</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" name="ttterms">
										<option value="">Select</option>
									<?php

											foreach($terms as $term) :
											echo "<option value=\"".$term->id."\" ".($term->id == $tttermid ? "selected=\"yes\"" : "").">".$term->term."</option>";
											endforeach;
									?>
								  </select>
								</div>
							  </div>
						<div class="control-group" >
								<label class="control-label" for="selectError">Select Class</label>
								<div class="controls">
								  <select id="selectError6" data-rel="chosen" name="courses">
										<option value="">Select</option>
									<?php

											foreach($courses as $course) :
											echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
											endforeach;
									?>
								  </select>
								</div>
							  </div>
 <div class="form-actions">
       <button class="btn btn-primary" name="Go" value="Go"><i class="icon-upload"></i>Go</button>
 </div>              
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="tttermid" value="<?php echo $tttermid; ?>" />
<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
<input type="hidden" name="task" value="viewclasstimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="classtimetable" />
</form>
	 

	<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=timetable&controller=timetable&layout=printclasstimetable&courseid='.$courseid.'&subjectid='.$subjectid.'&tttermid='.$tttermid.'&tmpl=component&print=1" '.$href;
        }
?>						
<?php if($courseid AND $tttermid)
{
?>	
						
	 <div align="right"><a href=<?php echo $href; ?> ><span title="Print Timetable" class="icon32 icon-green icon-print"></span></a></div>
					
						
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
	           $i=1;
                   foreach($subjects as $srec) {
        ?>
        <tr>
                <td>
			<?php echo $i++; ?>
		</td>
                 <td><?php echo $srec->subjectcode; ?></td>
                 <td><?php echo $srec->subjecttitle; ?></td>
                 <td><?php echo $srec->acronym; ?></td>
	<?php
 			$rs = $model1->getSubjectTeachers($courseid,$srec->id,$staffrecs);
                        echo "<td>";
                        foreach($staffrecs as $staff)
                        {
                                echo "[$staff->staffcode]&nbsp;$staff->firstname<br />";
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
 <Br>
 <br>
  <?php 
 $model->getCourse($courseid,$co_name);
 ?>
 <!-- Class Time Table-->
  <h1 align="center" style="margin-bottom:10px;font-size:20px;font-weight:bold;"><?php echo $co_name->code;?> Time Table</h1>
<table cellpadding="3" width="100%" class="table-striped table-bordered">
						  <thead>
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
					$rs=$model1->getMSubject($ttentry->subjectid,$subrec);
					if($rs) $text=$text . $subrec->subjectcode.'<br />';
				}
				
				//Display Staff
				$rs=$model->getStaff($ttentry->staffid,$staffrec);
				if($rs){
					 $text=$text.'['.$staffrec->staffcode.']&nbsp;';
				}
				$i++;
			}

			echo '<td  align="center">';
			if($flag1==1)
				echo $text;
			else
				echo '---';
			echo '</td>';
		}
		echo '</tr>';
	}
	
?>
							 </tbody>
					  </table>   
	

<?php
} 
?>
<br>
				</div><!--/span-->
			
			</div><!--/row-->

<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="tttermid" value="<?php echo $tttermid; ?>" />
<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
<input type="hidden" name="task" value="viewclasstimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="classtimetable" />
 </form>	

</div>
