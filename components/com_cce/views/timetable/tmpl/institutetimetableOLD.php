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
	$model->getSessions1($sessions);
	$courses = $model->getCurrentCourses();
        $model1 = & $this->getModel('managesubjects');
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
?>

<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
                <div style="float:left">
                        <img src="<?php echo $iconsDir.'/institutetimetable.png'; ?>" alt="" style="width: 44px; height: 44px;" />
                </div>
                <div style="float:left">
			<h1></h1>
                        <h1 class="item-page-title" align="left"> Institutional Time Table</h1>
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

<div class="box">
	<div class="box-header well" data-original-title>
		<h2><i class="icon-edit"></i> <strong> Institutional Time Table</strong></h2>
		<div class="pull-right">
			<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
				<label class="control-label" for="selectError">Select Date</label>
				<input  class="input-xlarge datepicker" id="date01" style="width:200px;" size="16" type="text" name="idate" value="<?php echo $idate; ?>">
				<button class="btn btn-primary" name="Go" value="Go"><i class="icon-play icon-white"></i> Go</button>
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="institutetimetable" />
				<input type="hidden" name="controller" value="timetable" />
				<input type="hidden" name="view" value="timetable" />
				<input type="hidden" name="layout" value="institutetimetable" />
			</form>
		</div>
	</div>
	<div class="box-content">

		<?php
		$rs=$model->getDayByDate($idate,$dayrec); //Dayorder record using calendar: date->cal->dayorderid
		$staffs=$model->getStaffs(); //Get all staff details for the combo box
		echo '<h2 class="item-page-title">'.$dayrec->title.'['.$dayrec->code.']</h2>'; 
		echo '<table border="1" cellspacing="2" cellpadding="3" width="100%">';
			echo '<tr>';
			echo '<th class="list-title">Courses</th>';
			foreach ($sessions as $session) { //Display the session headings
				$model->getSessionByCode($session->code,$ssrec);
				echo '<th class="list-title" >'.$ssrec->code.'<br ><font style="font-size:9px;">['.$ssrec->start.'-'.$ssrec->stop.']</font></th>';
			}
			echo '</tr>';
			foreach($courses as $course){ //For each course display the sessions
				echo '<tr>';
				echo '<th class="list-title" >'.$course->code.'</th>';
				$duration=0;
				foreach ($sessions as $session){  //For each session display the subject and staff members
		                        if($duration>1){
                	                	$duration--;
	                        	        continue;
                        		}
        		                $text=''; //Cell Contents
                        		//Get Entry for the cell
					$rs=$model->getTimetableEntryByClassDay($course->code,$dayrec->code,$session->code,$ttentries);
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
			echo '</table>';
		?>
<br>
	<!--	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
			<div class="pull-right" >
				<label class="control-label" for="selectError">Select Teacher</label>
					<select id="selectError6" data-rel="chosen" name="hstaffid">
					<option value="">Select</option>
				//	<?php
				//	foreach($staffs as $staff) :
				//		echo "<option value=\"".$staff->id."\" ".($staff->id == $hstaffid ? "selected=\"yes\"" : "").">".$staff->firstname."</option>";
				//	endforeach;
					?>
					</select>
					<button class="btn btn-primary" name="show" value="Show"><i class="icon-play icon-white"></i> GO</button>       
					<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
					<input type="hidden" name="task" value="institutetimetable" />
					<input type="hidden" name="controller" value="timetable" />
					<input type="hidden" name="view" value="timetable" />
					<input type="hidden" name="layout" value="institutetimetable" />
			</div>
		</form> -->
	</div>
</div>

