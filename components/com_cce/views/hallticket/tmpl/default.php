<?php

        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$examid= JRequest::getVar('examid');
	$ttid= JRequest::getVar('ttid');
	$cid= JRequest::getVar('cid');
	$sid= JRequest::getVar('sid');

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$model = $this->model;
	$model1 = $this->model1;
	$model2 = $this->model2;
        $modelsms = & $this->getModel('sms');
	$courses=$model->getCurrentCourses();
	$exams =$model2->getTNGradeBook();
	$model2->getTNGradeBookEntry($examid,$erec);
	$timetablelist=$modelsms->getSMSTimetableList($examid,$list);
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$photoDir = JURI::base() . 'components/com_cce/studentsphoto/';
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
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=grades&task=display&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Dashboard', $dashboardlink);
        $pathway->addItem('Eams',$modulelink);
        $pathway->addItem('Hall Ticket');

	$model->getSchoolInfo($schoolinfo);

?>

<b style="font: bold 15px Georgia, serif;"><?php echo $mname; ?></b>
<h1>HALL TICKET</h1>
		<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=hallticket&view=hallticket&task=task&Itemid='.$Itemid); ?>" method="POST" name="adminform" > 
                        <div class="pull-left">
                                <table width="100%" border="0">
                                <tr>
                                <td>
	                                <select id="selectError1" data-rel="chosen" name="examid" onChange="submit();" > 
        	        	                <option value="">Select Examination</option>
                	        	        <?php
                        	        	foreach($exams as $exam) :
                                			echo "<option value=\"".$exam->id."\" ".($exam->id == $examid ? "selected=\"yes\"" : "").">".$exam->title."</option>";             
		                                endforeach;
        		                        ?>
                	                </select>
                                </td>
                                <td>
                	                <select id="selectError2" data-rel="chosen" name="tt" onChange="submit();">
                        		        <option value="">Select Time Table</option>
	        	                        <?php
						$ffl='0';
                                		foreach($list as $lrec) :
							if($lrec->id==$ttid) $ffl='1';
                        			        echo "<option value=\"".$lrec->id."\" ".($lrec->id == $ttid ? "selected=\"yes\"" : "").">".$lrec->title."</option>";             
		                                endforeach;
						if($ffl=='0'){
							$ttid='';
						}
                                		?>
	                                </select>
                                </td>	
                                <td>
        	                        <select id="selectError3" data-rel="chosen" name="cid" onChange="submit();">
                		                <option value="">Select Class</option>
                                		<?php
		                                        $courses=$model->getCurrentCourses();
							$ffl='0';
                		                        foreach($courses as $course)
                                		        {
								$modelsms->getSMSTimeTableCourses($ttid,$course->id,$cccs);
								if(count($cccs)>0){
									if($course->id==$cid) $ffl='1';
                		                			echo "<option value=\"".$course->id."\" ".($course->id == $cid ? "selected=\"yes\"" : "").">".$course->code."</option>";
								}
							}
							if($ffl=='0'){
								$cid='';
							}
                                		?>
                                	</select>
                                </td>
                                <td>
                                        <select id="selectError4" data-rel="chosen" name="sid" onChange="submit();">
                                                <option value="">Select Student</option>
                                                <?php
							$srecs = $model->getStudents($cid);
                                                        foreach($srecs as $srec)
                                                        {
                                                        	echo "<option value=\"".$srec->id."\" ".($srec->id == $sid ? "selected=\"yes\"" : "").">".$srec->firstname."</option>";
                                                        }
                                                ?>
                                        </select>
                                </td>


				</tr>
				</table>
	</div>
	<div style="float:right;">
		<input class="btn btn-small btn-warning" type="submit" name="print2" value="DOWNLOAD" />
		<input class="btn btn-small btn-primary" type="submit" name="print1" value="DOWNLOAD ALL" />
	</div>
</div>
<center><hr style="color: #000; background-color: #000; height: 2px;width:100%" /></center><br />
<br />
<br />
<?php
$model->getStudent($sid,$sobj);
$model->getStudentClass($sid,$screc);
	echo '<center>';
	echo '<b><p style="font-size:150%">'.$schoolinfo->schoolname.'</p></b>';
	echo '<b><p style="font-size:100%">'.$schoolinfo->schooladdress.'</p></b>';
	echo '<b><p style="font-size:130%">'.$erec->title.' Examination</p></b>';
	echo '<b><p style="font-size:120%">HALL TICKET</p></b>';
	echo '</center>';

?>
<center><hr style="color: #000; background-color: #000; height: 2px;width:70%" /></center><br />

			<table width="70%" align="center" border="0" class="">
			<tr><td width="25%" align="left">Student Name</td><td width="35%" align="left">: <?php echo $sobj->firstname; ?></td><td align="right" rowspan="6">
				<?php 
				$fs=$model->getsiglestudentphoto($sobj->id,$file);
				if(strlen(trim($file->imagename))>2){ ?>
		        		<img class="stu_image" src="<?php echo  $photoDir.$file->imagename;  ?>" width="150px" height="140px" alt="photo"/>
        		  <?php }else{ ?>
					<img class="stu_image" src="<?php echo $photoDir.'no-image.gif'; ?>" alt="photo" width="150px" height="140px;"/>
			<?php }	?>	
			
			</td></tr>
			<tr><td>Gender</td><td>: <?php echo $sobj->gender; ?></td></tr>
			<tr><td>Date of Birth</td><td>: <?php echo JArrayHelper::indianDate($sobj->dob); ?></td></tr>
			<tr><td>Class</td><td>: <?php echo $screc->code; ?></td></tr>
			<tr><td>Father Name</td><td>: <?php echo $sobj->pfathername; ?></td></tr>
			<tr><td>Signature of the Student</td><td><table border="1" width="100%"><tr height="40px"><td></td></tr></table></td><td></td></tr>
			</table>
<br />
			
			<table width="70%" align="center" border="0" class="">
			<tr><td colspan="5" align="center"><b>SCHEDULE OF EXAMINATION</b></td></tr>
			</table>
			<table width="70%" align="center" border="1" class="">
			<thead>
			<tr>
				<td width="5%" align="center"><b>Sno</b></th>
				<td width="5%" align="center"><b>Date</b></th>
				<td width="10%" align="center"><b>Session</b></th>
				<td width="40%" align="center"><b>Subject Title</b></th>
				<td width="25%" align="center"><b>Signature of the Invigilator</b></th>
				</tr>
			</thead>   
			<tbody>
<?php
	$ttrec = $modelsms->getSMSTimeTableListEntry($ttid,$trec);
	$title = $trec->title;
	$modelsms->getSMSTimeTableCourses($ttid,$ttcourses);
	if($examid && $ttid){
	$rf=0; //To find empty list
				$r=$modelsms->getSMSTimeTableEntries($ttid,$ttrecs);
				$i=1;
				foreach($ttrecs as $ttrec){
					$ff='0';
					$str= '<tr height="30px">';
					if((strlen(trim($ttrec->fn))>1)&&(strlen(trim($ttrec->an))>1)) {
						$ff='1';
						$str=$str.'<td rowspan="2" align="center">'.$i.'</td>';
						$str=$str.'<td rowspan="2" align="center">'.JArrayHelper::indianDate($ttrec->fdate).'</td>';
					}else{
						$str=$str.'<td  align="center">'.$i.'</td>';
						$str=$str.'<td align="center">'.JArrayHelper::indianDate($ttrec->fdate).'</td>';
					}
					if(strlen(trim($ttrec->fn))>1) {
						$str=$str.'<td>Morning</td>';
						$str=$str.'<td>'.htmlspecialchars($ttrec->fn).'</td>';
					}
					if(strlen(trim($ttrec->an))>1) {
						if($ff=='1') {
							$str=$str.'<td></td></tr><tr height="30px">';
						}
						$str=$str. '<td>Evening</td>';
						$str=$str. '<td>'.htmlspecialchars($ttrec->an).'</td>';
					}
					$str=$str.'<td></td>';
					$str=$str.'</tr>';
					echo $str;
					$i++;
				}
		}	
	?>

			</tbody>
			</table>  
			<table width="70%" align="center" border="0" class="">
			<tr height="70px"><td valign="bottom" align="right"><b>Signature of the Principal</b></td></tr>
			<tr><td><b>Instructions:</b></td></tr>
			<tr><td>
		<?php
			echo nl2br($erec->instructions);
		?>
		</td></tr>
		</table>

			<input type="hidden" name="view" value="hallticket" />
			<input type="hidden" name="controller" value="hallticket" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
			<input type="hidden" name="etitle" value="<?php echo $erec->title; ?>" />
			<input type="hidden" name="ttitle" value="<?php echo $title; ?>" />
			<input type="hidden" name="task" value="task"/>
</form>
<br />
<br />
<br />
