<style>
table.subjects{
	border-collapse:collapse;
}
table.subjects tr td{
	padding:7px;border:1px solid #919191;
	font-size:12px;
}
table.subjects tr th{
	background:#E8E8E8;
	padding:4px;
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
        $courseid= JRequest::getVar('courseid');
        $tttermid= JRequest::getVar('tttermid');
        $subjectid= JRequest::getVar('subjectid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model1 = & $this->getModel('managesubjects');
        $model = & $this->getModel('timetable');
	$courses = $model->getCurrentCourses();
    $model->getCourse($courseid,$crec);
	$model->getTimeTableTerm($tttermid,$trec) ;
	$rs = $model1->getMSubjectsByCourse($courseid,$subjects);
	$model->getSessions1($sessions);
	$model->getDays1($days);
	$clteachers=$model1->getClassTeachers($courseid);
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
<Br>	
						<table  class="subjects" width="100%">
						  <thead>
							  <tr>
								  <th>Option</th>
								   <th>Subject Code</th>
									<th>Subject Name</th>
									<th>Acronym</th>
									<th>Staff</th>
									<th>Credits</th>
									<th>Subject Type</th>
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
                                $fl=0;
                                foreach($clteachers as $clte){
                                        if($clte->staffid==$staff->id) $fl=1;
                                }
                                if($fl==1) $classteacher="[Class Teacher]";
                                echo "[$staff->staffcode]&nbsp;$staff->firstname <b>$classteacher</b><br />";
                                $classteacher="";
                        }
                 	echo '<td>';
			echo $srec->credits; 
			echo '</td>'; 
                        echo "</td>"; 
			echo '<td>';
			echo $srec->subjecttype;
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
<table cellpadding="0" width="100%" class="subjects">
						  <thead>
<?php
        echo '<tr>';
        echo '<th class="list-title"><font color="black">Day</font></th>';
        foreach ($sessions as $session){
                $model->getSessionByCode($session->code,$ssrec);
                echo '<th class="list-title" > <font color="black">'.$session->code.'</font><br ><font color="black" style="font-size:9px;">['.$ssrec->start.'-'.$ssrec->stop.']</font></th>';
        }
        echo '</tr>';
        foreach ($days as $day){
                echo '<tr>';
                echo '<th class="list-title2"><font color="black">'.$day->code.'</font></th>';
                $duration=0;


    foreach ($sessions as $session){
                        if($duration>1){
                                $duration--;
                                continue;
                        }
                        $text=''; //Cell Contents
                        //Get Entry for the cell
                        $rs=$model->getTimetableActivityByClass($co_name->code,$day->code,$session->code,$ttentries);

                        $i=1;
                        $duration=0;

                        if(count($ttentries)==1){
                                        $text=$text . $ttentries[0]->subjectcode.'<br />';
                                        $text=$text.'['.$ttentries[0]->staffcode.']';
                                        $duration=$ttentries[0]->duration;

                        }else if(count($ttentries)>1){
                                $text=$ttentries[0]->subjectcode.'<br />';
                                $duration=$ttentries[0]->duration;
                                foreach($ttentries as $ttentry){
                                        $text=$text.'['.$ttentry->staffcode.']&nbsp;';
                                }
                        }else{
                                $text='---';
                        }

                        if($duration>1){
                                echo '<td  align="center" colspan="'.$duration.'">';
                                echo $text;
                                echo '</td>';
                        }
                        else{
                                echo '<td  align="center">';
                                echo $text;
                                echo '</td>';
			}
		}
		echo '</tr>';
	}
	
?>
							 </tbody>
					  </table>   
	

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
<br>
<br>
<br>
<br>
<div align="right">
<h3>Principal's Signature</h3>
</div>
