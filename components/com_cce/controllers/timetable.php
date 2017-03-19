<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

require_once('helper.php'); 

class CCEControllerTimeTable extends JController
{

	function validateuser()
	{
		if(! Helper::checkuser()){ 
			$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
	        	$this->setRedirect($redirectTo,'Please Login First');
			return;
		}
	}

   	function display() {
		$this->validateuser();
		$document = JFactory::getDocument();
        	$viewType = $document->getType();
	        $viewName = JRequest::getCmd('view', $this->default_view);
        	$viewLayout = JRequest::getCmd('layout', 'default');
	        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        	$model=& $this->getModel('timetable');
        	$model1=& $this->getModel('managesubjects');
	        if($model==true){
        	        $view->setModel($model,true);
        	        $view->setModel($model1);
	        }
        	$view->setLayout($viewLayout);
	        $view->display();
    	}

	function savesessioncategory(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=sessioncategory&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('timetable');
                if($sc['id']==-1){
                        $status = $model->addSessionCategory($sc['description']);
                }else{
                        $status = $model->updateSessionCategory($sc['id'],$sc['description']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'');
                }else{
                        $this->setRedirect($redirectTo,'Session Category has been Saved');
                }
	}

	function deletesessioncategory()
        {
		$scid = JRequest::getVar('scid');
		$Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=sessioncategory&Itemid='.$Itemid,false);
                if($scid==null){
                        //Make sure the id parameter was in the request
                        JError::raiseWarning(500,'Record not found');
                        $this->setRedirect($redirectTo,'');
                        return;
                }
                $model = & $this->getModel('timetable');
                $status=$model->deleteSessionCategory($scid);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted!');
                else
                        $this->setRedirect($redirectTo,'Could not delete');
        }



	
	function deletesessioncourse()
        {
		$scid = JRequest::getVar('scid');
		$termid= JRequest::getVar('termid');
		$cid = JRequest::getVar('cid');
		$Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=sessioncategory&Itemid='.$Itemid,false);
                $model = & $this->getModel('timetable');
                $status=$model->deleteSessionCourse($scid,$cid,$termid);
                $this->setRedirect($redirectTo,'Course has been Deleted');
	}

	function assigncourses()
	{
                $scid = JRequest::getVar('scid');	
                $Itemid = JRequest::getVar('Itemid');	
                $termid = JRequest::getVar('terms');	
		//Read cid as an array
				$redirect= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=assigncourses&scid='.$scid.'&Itemid='.$Itemid);
				
				if(!$termid)
				{
					 JError::raiseWarning(500,'Please select a Term');
                     $this->setRedirect($redirect,'');
                     return;
				}
                $cids = JRequest::getVar('cid',null,'default','array');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=sessioncategory&Itemid='.$Itemid,false);
                if($cids==null){
					    JError::raiseWarning(500,'Please select a record');
                        $this->setRedirect($redirect,'');
                        return;
                }
                $model = & $this->getModel('timetable');
		foreach($cids as $cid){
                	$status=$model->assignSessionCourse($scid,$cid,$termid);
		}
                $this->setRedirect($redirectTo,'Courses has been assigned successfully');
	}

        function savesession(){
                $sc = JRequest::get('POST');
		if(isset($sc['break'])) $sc['break']=1;
		else $sc['break']=0;
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=sessioncategory&scid='.$sc['scid'].'&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('timetable');
                if($sc['id']==-1){
                        $status = $model->addSession($sc['title'],$sc['code'],$sc['start'],$sc['stop'],$sc['break'],$sc['scid']);
                }else{
                        $status = $model->updateSession($sc['id'],$sc['title'],$sc['code'],$sc['start'],$sc['stop'],$sc['break']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'');
                }else{
                        $this->setRedirect($redirectTo,'Session has been Saved');
                }
        }


	function deletesession()
        {
                $scid = JRequest::getVar('scid');
                $stid = JRequest::getVar('stid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=sessioncategory&scid='.$scid.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('timetable');
                $status=$model->deleteSession($stid);
                $this->setRedirect($redirectTo,'Session has been Deleted');
        }


//Days
	function savedaycategory(){
                $sd = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=daycategory&Itemid='.$sd['Itemid'],false);
                $model = & $this->getModel('timetable');
                if($sd['id']==-1){
                        $status = $model->addDayCategory($sd['description']);
                }else{
                        $status = $model->updateDayCategory($sd['id'],$sd['description']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record');
                        $this->setRedirect($redirectTo,'');
                }else{
                        $this->setRedirect($redirectTo,'Day Category has been Saved');
                }
	}

	function deletedaycategory()
        {
		$sdid = JRequest::getVar('sdid');
		$Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=daycategory&Itemid='.$Itemid,false);
                if($sdid==null){
                        //Make sure the id parameter was in the request
                        JError::raiseWarning(500,'Record not found');
                        $this->setRedirect($redirectTo,'');
                        return;
                }

                $model = & $this->getModel('timetable');
                $status=$model->deleteDayCategory($sdid);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted!');
                else
                        $this->setRedirect($redirectTo,'Could not delete');
        }



	
	function deletedaycourse()
        {
		$sdid = JRequest::getVar('sdid');

		$cid = JRequest::getVar('cid');
		$tid= JRequest::getVar('tid');
		$Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=daycategory&Itemid='.$Itemid,false);
                $model = & $this->getModel('timetable');
                $status=$model->deleteDayCourse($sdid,$cid,$tid);
                $this->setRedirect($redirectTo,'Course has been Deleted');
	}

	function dayassigncourses()
	{
                $sdid = JRequest::getVar('sdid');	
                $Itemid = JRequest::getVar('Itemid');	
                $termid= JRequest::getVar('terms');	
                if(!$termid)
                {
					  $redirectTo= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=dayassigncourses&sdid='.$sdid.'&Itemid='.$Itemid);
                     JError::raiseWarning(500,'Please select term');
					   $this->setRedirect($redirectTo,'');
					   return;
				}
		//Read cid as an array
                $cids = JRequest::getVar('cid',null,'default','array');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=daycategory&Itemid='.$Itemid,false);
                if($cids==null){
			  		  $redirect= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=dayassigncourses&sdid='.$sdid.'&Itemid='.$Itemid);
                 
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        JError::raiseWarning(500,'Please select a record');
                        $this->setRedirect($redirect,'');
                        return;
                }
                $model = & $this->getModel('timetable');
		foreach($cids as $cid){
                	$status=$model->assignDayCourse($sdid,$cid,$termid);
		}
		
                $this->setRedirect($redirectTo,'Courses has been assigned successfully');
	}

        function saveday(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=daycategory&sdid='.$sc['sdid'].'&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('timetable');
                if($sc['id']==-1){
                        $status = $model->addDay($sc['title'],$sc['code'],$sc['active'],$sc['sdid']);
                }else{
                        $status = $model->updateDay($sc['id'],$sc['title'],$sc['code'],$sc['active']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'');
                }else{
                        $this->setRedirect($redirectTo,'Day has been Saved');
                }
        }


	function deleteday()
        {
                $sdid = JRequest::getVar('sdid');
                $ddid = JRequest::getVar('ddid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=daycategory&sdid='.$sdid.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('timetable');
                $status=$model->deleteDay($ddid);
                $this->setRedirect($redirectTo,'Day has been Deleted');
        }


	function removettentry(){
                $Itemid = JRequest::getVar('Itemid');
                $courseid= JRequest::getVar('courseid');
                $tttermid = JRequest::getVar('tttermid');
                $subjectid = JRequest::getVar('subjectid');
                $sessionid= JRequest::getVar('sessionid');
                $dayid = JRequest::getVar('dayid');

                $model = & $this->getModel('timetable');
		$rs = $model->deleteTTEntry($tttermid,$courseid,$dayid,$sessionid,$subjectid);

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=createtimetable&tttermid='.$tttermid.'&courseid='.$courseid.'&Itemid='.$Itemid,false);
        $this->setRedirect($redirectTo,'');
	}


	function removettstaffentry(){
                $Itemid = JRequest::getVar('Itemid');
                $courseid= JRequest::getVar('courseid');
                $tttermid = JRequest::getVar('tttermid');
                $subjectid = JRequest::getVar('subjectid');
                $sessionid= JRequest::getVar('sessionid');
                $dayid = JRequest::getVar('dayid');
                $staffid= JRequest::getVar('staffid');
                
                $model = & $this->getModel('timetable');
		$rs = $model->deleteTTStaffEntry($tttermid,$courseid,$dayid,$sessionid,$subjectid,$staffid);

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=createtimetable&tttermid='.$tttermid.'&courseid='.$courseid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');
	}


	function generatetimetable() {
                $Itemid = JRequest::getVar('Itemid');
             	$ttdir = JPATH_SITE.DS.'tt';
                $model = & $this->getModel('timetable');
		$model->getDays1($days);
		$model->getBreakSessions($bsessions);
		$model->getSessions1($sessions);
                $model1 = & $this->getModel('managesubjects');
		$model1->getCurrentMSubjects($subjects);
		$model1->getMSubjectTypes($subjecttypes);
		$model1->getWorkloadActivities($activities);
		$model1->getCombinedClassIds($comids);
		//$model1->getMSubjectActivities($activities);
		$model1->getStaffCodes($staffcodes);
		$model1->getClassTotal($classtotals);

		$model1->getSchoolInfo($schoolrec);



		$gflag='0';
	
		$t_days= count($days);
		$t_sessions = count($sessions);
		$t_bsessions = count($bsessions);
		$t_staff= count($staffcodes);
		$t_class= count($classtotals);
		$t_totalsessions =  (($t_sessions-$t_bsessions)*$t_days);
		$t_totalclasssessions = $t_totalsessions * $t_class;
		

		echo '<b><h1>Total Number of Days: ' .$t_days.'</h1></b>';
		echo '<b><h1>Number of Sessions/Week: ' .$t_sessions.'</h1></b>';
		echo '<b><h1>Number of Break Sessions/Week: ' .$t_bsessions.'</h1></b>';
		echo '<b><h1>Total Number of Sessions: ' .$t_totalsessions.'</h1></b>';
		echo '<b><h1>Total Number of Staff: ' .$t_staff.'</h1></b>';
		echo '<b><h1>Total Number of Classes(student batches): ' .$t_class.'</h1></b>';
		echo '<b><h1>Total Sessions: ' .$t_totalclasssessions.'</h1></b>';
		
		if($t_class=='0') {
			echo '<b><h3>Please create student batches/classes<h3></b>';
			$gflag='1';
		}
		$t_workload=0;	
		foreach($staffcodes as $staffrec){
			$r=$model1->getWorkloadHrs($staffrec->id,$obj);
			if($obj->hrs > $t_totalsessions){
				echo "<br />Staff Workload: ".$staffrec->staffcode."-".$obj->hrs;
				$gflag='1';
			}
				
			$t_workload=$t_workload+$obj->hrs;
		}
		echo '<b><h1>Total Workload: ' .$t_workload.'</h1></b>';
		echo '<b><h1>Total Free Sessions: ' .$t_freesessions.'</h1></b>';
		$t_freesessions = $t_totalclasssessions - $t_workload;
		if($t_freesessions < 0){
			echo '<b><h3>Total Workload of Staff is more than the Total Sessions of all Classes</h3></b>';
			$gflag='1';	
		}
	
		if($gflag=='1'){
			echo "Time Table Can not be generated...";
			//return;
			
		}


		$fd = fopen($ttdir.'/tt.fet','w');
		if($fd){
			$str='<?xml version="1.0" encoding="utf-8"?>'."\n\n";
			$str=$str.'<fet version="5.13.0">'."\n\n";
			$str=$str."<Institution_Name>".$schoolrec->schoolname."</Institution_Name>\n\n";
			$str=$str."<Comments>".$schoolrec->schooladdress."</Comments>\n\n\n";
			fwrite($fd,$str);


			//Hours List
			$str="<Hours_List>\n";
       			$str=$str."\t<Number>".count($sessions)."</Number>\n";
			foreach($sessions as $session){
       				$str=$str."\t<Name>".$session->code."</Name>\n";
       			//	$str=$str."\t<Sessionid>".$session->id."</Sessionid>\n";
			}
			$str=$str."</Hours_List>\n\n";
			fwrite($fd,$str);

			//Days List
			$str="<Days_List>\n";
       			$str=$str."\t<Number>".count($days)."</Number>\n";
			foreach($days as $day){
       				$str=$str."\t<Name>".$day->code."</Name>\n";
       			//	$str=$str."\t<Dayid>".$day->id."</Dayid>\n";
			}
			$str=$str."</Days_List>\n\n";
			fwrite($fd,$str);


			//Students List
			$str="<Students_List>\n";
			foreach($classtotals as $ct){
				$str=$str."<Year>\n";
       				$str=$str."\t<Name>".$ct->coursecode."</Name>\n";
       				$str=$str."\t<Number_of_Students>".$ct->classtotal."</Number_of_Students>\n";
       			//	$str=$str."\t<Classid>".$ct->classid."</Classid>\n";
				$str=$str."</Year>\n";
			}
			$str=$str."</Students_List>\n\n";
			fwrite($fd,$str);


			//Teacher List
			$str="<Teachers_List>\n";
			foreach($staffcodes as $staffcode){
				$str=$str."<Teacher>\n";
       				$str=$str."\t<Name>".$staffcode->staffcode."</Name>\n";
       			//	$str=$str."\t<Staffid>".$staffcode->id."</Staffid>\n";
				$str=$str."</Teacher>\n";
			}
			$str=$str."</Teachers_List>\n\n";
			fwrite($fd,$str);

			//Subject List
			$str="<Subjects_List>\n";
			foreach($subjects as $subject){
				$str=$str."<Subject>\n";
       				$str=$str."\t<Name>".$subject->subjectcode."</Name>\n";
			//	$str=$str."\t<Subjectid>".$subject->sid."</Subjectid>\n";
				$str=$str."</Subject>\n";
			}
			$str=$str."</Subjects_List>\n\n";
			fwrite($fd,$str);


			//Activity Tags

			$str="<Activity_Tags_List>\n";
			foreach($subjecttypes as $subjecttype){
				$str=$str."<Activity_Tag>\n";
       				$str=$str."\t<Name>".$subjecttype->subjecttype."</Name>\n";
				$str=$str."</Activity_Tag>\n";
			}
			$str=$str."</Activity_Tags_List>\n\n";
			fwrite($fd,$str);

			//Activities List
			$str="<Activities_List>\n";
			$id=1;
			foreach($activities as $activity){
				$gid=$id;	
				for($i=1; $i<=($activity->hrs/$activity->duration); $i++){
					$str=$str."<Activity>\n";
					$model1->getMSubjectStaffs($activity->sid,$activity->cid,$staffs);
					foreach($staffs as $teacher){
						$str=$str."\t<Teacher>".$teacher->staffcode."</Teacher>\n";
					}
					$str=$str."\t<Subject>".$activity->subjectcode."</Subject>\n";
					$str=$str."\t<Activity_Tag>".$activity->stype."</Activity_Tag>\n";
					$str=$str."\t<Duration>".$activity->duration."</Duration>\n";
					$str=$str."\t<Total_Duration>".$activity->hrs."</Total_Duration>\n";
					$str=$str."\t<Id>".$id++."</Id>\n";
					$str=$str."\t<Activity_Group_Id>".$gid."</Activity_Group_Id>\n";
					$str=$str."\t<Active>true</Active>\n";
					$str=$str."\t<Students>".$activity->coursecode."</Students>\n";
					$str=$str."</Activity>\n";
				}
			}
			fwrite($fd,$str);

			$str='';
			//Combined Activities
			foreach($comids as $cobj){
				$s_staffs='';
				$s_subjects='';
				$s_students='';
				$s_duration='';
				$s_stype='';

				$model1->getWorkloadCombinedActivities($cobj->comid,$carecs);
				foreach ($carecs as $activity){
					$model1->getMSubjectStaffs($activity->sid,$activity->cid,$staffs);
					foreach($staffs as $teacher){
						$s_staffs=$s_staffs."\t<Teacher>".$teacher->staffcode."</Teacher>\n";
					}
					$s_subjects=$s_subjects."\t<Subject>".$activity->subjectcode."</Subject>\n";
					$s_students=$s_students."\t<Students>".$activity->coursecode."</Students>\n";
					$s_duration="\t<Duration>".$activity->duration."</Duration>\n";
					$s_hrs="\t<Total_Duration>".$activity->hrs."</Total_Duration>\n";
					$s_stype="\t<Activity_Tag>".$activity->stype."</Activity_Tag>\n";
				}	

				$gid=$id;
				for($i=1; $i<=($activity->hrs/$activity->duration); $i++){
					$str=$str."<Activity>\n";
					$str=$str.$s_staffs;	
					$str=$str.$s_subjects;	
					$str=$str.$s_students;	
					$str=$str.$s_stype;	
					$str=$str.$s_duration;	
					$str=$str.$s_hrs;	
					$str=$str."\t<Id>".$id++."</Id>\n";
					$str=$str."\t<Activity_Group_Id>".$gid."</Activity_Group_Id>\n";
					$str=$str."\t<Active>true</Active>\n";
					$str=$str."</Activity>\n";
				}
				
			}
			$str=$str."</Activities_List>\n\n";
			fwrite($fd,$str);



			//Time Constraints

			$str="<Time_Constraints_List>\n";
			$str=$str."\t<ConstraintBasicCompulsoryTime>\n";
			$str=$str."\t\t<Weight_Percentage>100</Weight_Percentage>\n";
			$str=$str."\t</ConstraintBasicCompulsoryTime>\n";
			fwrite($fd,$str);

                        $id=1;
                        foreach($activities as $activity){
				$str='';
				$n=$activity->hrs/$activity->duration;
                                $str=$str."\t<ConstraintMinDaysBetweenActivities>\n";
                                $str=$str."\t\t<Weight_Percentage>".$activity->rate."</Weight_Percentage>\n";
				$str=$str."\t\t<Number_of_Activities>".$n."</Number_of_Activities>\n";
                                for($i=1; $i<=$n; $i++){
                                        $str=$str."\t\t<Activity_Id>".$id++."</Activity_Id>\n";
                                }
//				if(trim($activity->stype)=="Practical"){
				$str=$str."\t\t<MinDays>".$activity->mindays."</MinDays>\n";
				if($activity->consecutive=='0') $consecutive="false";
				else $consecutive="true";
                                	$str=$str."\t\t<Consecutive_If_Same_Day>".$consecutive."</Consecutive_If_Same_Day>\n";
                                $str=$str."\t</ConstraintMinDaysBetweenActivities>\n";
                        
				fwrite($fd,$str);
                        }



			//Combined Classes
			foreach($comids as $cobj){
				$str='';
				$model1->getWorkloadCombinedActivities($cobj->comid,$carecs);
				foreach ($carecs as $activity){
					$n=$activity->hrs/$activity->duration;
                                	$str=$str."\t<ConstraintMinDaysBetweenActivities>\n";
	                                $str=$str."\t\t<Weight_Percentage>".$activity->rate."</Weight_Percentage>\n";
					$str=$str."\t\t<Number_of_Activities>".$n."</Number_of_Activities>\n";
                	                for($i=1; $i<=$n; $i++){
                        	                $str=$str."\t\t<Activity_Id>".$id++."</Activity_Id>\n";
                                	}
					$str=$str."\t\t<MinDays>".$activity->mindays."</MinDays>\n";
					if($activity->consecutive=='0') $consecutive="false";
					else $consecutive="true";
                                		$str=$str."\t\t<Consecutive_If_Same_Day>".$consecutive."</Consecutive_If_Same_Day>\n";
	                                $str=$str."\t</ConstraintMinDaysBetweenActivities>\n";
                        		fwrite($fd,$str);

					
					break;
				}	

			}
				


			$str="\t<ConstraintTeachersActivityTagMaxHoursContinuously>\n";
        		$str=$str."\t\t<Weight_Percentage>99.88</Weight_Percentage>\n";
	        	$str=$str."\t\t<Activity_Tag_Name>Theory</Activity_Tag_Name>\n";
	        	$str=$str."\t\t<Maximum_Hours_Continuously>3</Maximum_Hours_Continuously>\n";
			$str=$str."\t\t</ConstraintTeachersActivityTagMaxHoursContinuously>\n";
                        fwrite($fd,$str);

/*
			$str='';
			foreach($classtotals as $class){
				$str=$str."<ConstraintStudentsSetNotAvailableTimes>\n";
	        		$str=$str."\t<Weight_Percentage>100</Weight_Percentage>\n";
        			$str=$str."\t<Students>".$class->coursecode."</Students>\n";
        			$str=$str."\t<Number_of_Not_Available_Times>".count($days)."</Number_of_Not_Available_Times>\n";
				foreach($days as $d){
					$str=$str."\t<Not_Available_Time>\n";
			             	$str=$str."\t\t<Day>".$d->code."</Day>\n";
        	       	 		$str=$str."\t\t<Hour>".'S5'."</Hour>\n";
	        			$str=$str."\t</Not_Available_Time>\n";
				}
				$str=$str."</ConstraintStudentsSetNotAvailableTimes>\n\n";
			}
                        fwrite($fd,$str);
*/


			//Break Session - Not available for students
			$str='';
			foreach ($bsessions as  $bsession){
			foreach($classtotals as $class){
                                $model->getclassnotavailableslots($class->classid,$crecs);
				$str=$str."\t<ConstraintStudentsSetNotAvailableTimes>\n";
	        		$str=$str."\t\t<Weight_Percentage>100</Weight_Percentage>\n";
        			$str=$str."\t\t<Students>".$class->coursecode."</Students>\n";
        			$str=$str."\t\t<Number_of_Not_Available_Times>".(count($days)+count($crecs))."</Number_of_Not_Available_Times>\n";
				foreach($days as $d){
					$str=$str."\t\t<Not_Available_Time>\n";
			             	$str=$str."\t\t\t<Day>".$d->code."</Day>\n";
        	       	 		$str=$str."\t\t\t<Hour>".$bsession->code."</Hour>\n";
	        			$str=$str."\t\t</Not_Available_Time>\n";
				}
                                        foreach($crecs as $crec){
                                                $str=$str."\t\t<Not_Available_Time>\n";
                                                $str=$str."\t\t\t<Day>".$crec->daycode."</Day>\n";
                                                $str=$str."\t\t\t<Hour>".$crec->sessioncode."</Hour>\n";
                                                $str=$str."\t\t</Not_Available_Time>\n";
                                        }
				$str=$str."\t</ConstraintStudentsSetNotAvailableTimes>\n\n";
			}
			}
                        fwrite($fd,$str);


			//Activity Preferred Time slots
                        foreach($activities as $activity){
				$model->getactivitytimingslots($activity->id,$actcons);
				if(count($actcons)>0){
					$str="\t<ConstraintActivitiesPreferredTimeSlots>\n";
	        			$str=$str."\t\t<Weight_Percentage>".$activity->psrate."</Weight_Percentage>\n";
        				$str=$str."\t\t<Teacher_Name></Teacher_Name>\n";
					$str=$str."\t\t<Students_Name>".$activity->coursecode."</Students_Name>\n";
        				$str=$str."\t\t<Subject_Name>".$activity->subjectcode."</Subject_Name>\n";
        				$str=$str."\t\t<Activity_Tag_Name>".$activity->stype."</Activity_Tag_Name>\n";
	        			$str=$str."\t\t<Number_of_Preferred_Time_Slots>".count($actcons)."</Number_of_Preferred_Time_Slots>\n";
					foreach($actcons as $acon){
        					$str=$str."\t\t<Preferred_Time_Slot>\n";
                					$str=$str."\t\t\t<Preferred_Day>".$acon->daycode."</Preferred_Day>\n";
	                				$str=$str."\t\t\t<Preferred_Hour>".$acon->sessioncode."</Preferred_Hour>\n";
        					$str=$str."\t\t</Preferred_Time_Slot>\n";
					}
					$str=$str."\t</ConstraintActivitiesPreferredTimeSlots>\n\n";
                        		fwrite($fd,$str);
				}
			}

/*				
			$str="<ConstraintActivitiesPreferredTimeSlots>\n";
		        $str=$str."<Weight_Percentage>100</Weight_Percentage>\n";
        		$str=$str."<Teacher_Name></Teacher_Name>\n";
        		$str=$str."<Students_Name></Students_Name>\n";
        		$str=$str."<Subject_Name></Subject_Name>\n";
        		$str=$str."<Activity_Tag_Name>Practical</Activity_Tag_Name>\n";
        		$str=$str."<Number_of_Preferred_Time_Slots>36</Number_of_Preferred_Time_Slots>\n";
			foreach($days as $d){
	        		$str=$str."<Preferred_Time_Slot>\n";
        	        		$str=$str."<Preferred_Day>".$d->code."</Preferred_Day>\n";
                			$str=$str."<Preferred_Hour>S1</Preferred_Hour>\n";
        			$str=$str."</Preferred_Time_Slot>\n";
	        		$str=$str."<Preferred_Time_Slot>\n";
        	        		$str=$str."<Preferred_Day>".$d->code."</Preferred_Day>\n";
                			$str=$str."<Preferred_Hour>S2</Preferred_Hour>\n";
        			$str=$str."</Preferred_Time_Slot>\n";
	        		$str=$str."<Preferred_Time_Slot>\n";
        	        		$str=$str."<Preferred_Day>".$d->code."</Preferred_Day>\n";
                			$str=$str."<Preferred_Hour>S3</Preferred_Hour>\n";
        			$str=$str."</Preferred_Time_Slot>\n";
	        		$str=$str."<Preferred_Time_Slot>\n";
        	        		$str=$str."<Preferred_Day>".$d->code."</Preferred_Day>\n";
                			$str=$str."<Preferred_Hour>S6</Preferred_Hour>\n";
        			$str=$str."</Preferred_Time_Slot>\n";
	        		$str=$str."<Preferred_Time_Slot>\n";
        	        		$str=$str."<Preferred_Day>".$d->code."</Preferred_Day>\n";
                			$str=$str."<Preferred_Hour>S7</Preferred_Hour>\n";
        			$str=$str."</Preferred_Time_Slot>\n";
	        		$str=$str."<Preferred_Time_Slot>\n";
        	        		$str=$str."<Preferred_Day>".$d->code."</Preferred_Day>\n";
                			$str=$str."<Preferred_Hour>S8</Preferred_Hour>\n";
        			$str=$str."</Preferred_Time_Slot>\n";
			}
			$str=$str."</ConstraintActivitiesPreferredTimeSlots>\n";
                        fwrite($fd,$str);
*/

			//TEACHER NOT AVAILABLE TIMES
			foreach($staffcodes as $teacher){
				$model->getteachernotavailableslots($teacher->id,$trecs);
				if(count($trecs)>0){
					$str="\t<ConstraintTeacherNotAvailableTimes>\n";
        				$str=$str."\t\t<Weight_Percentage>100</Weight_Percentage>\n";
        				$str=$str."\t\t<Teacher>".$teacher->staffcode."</Teacher>\n";
        				$str=$str."\t\t<Number_of_Not_Available_Times>".count($trecs)."</Number_of_Not_Available_Times>\n";
					foreach($trecs as $trec){
			        		$str=$str."\t\t<Not_Available_Time>\n";
        			        	$str=$str."\t\t\t<Day>".$trec->daycode."</Day>\n";
                				$str=$str."\t\t\t<Hour>".$trec->sessioncode."</Hour>\n";
        					$str=$str."\t\t</Not_Available_Time>\n";
					}
					$str=$str."\t</ConstraintTeacherNotAvailableTimes>\n\n";
					fwrite($fd,$str);
				}
			}

			  //STUDENT CLASS NOT AVAILABLE TIMES
                        foreach($classtotals as $class){
                                $model->getclassnotavailableslots($class->classid,$crecs);
                                if(count($crecs)>0){
                                        $str="\t<ConstraintStudentsSetNotAvailableTimes>\n";

                                        $str=$str."\t\t<Weight_Percentage>100</Weight_Percentage>\n";
                                        $str=$str."\t\t<Students>".$class->coursecode."</Students>\n";
                                        $str=$str."\t\t<Number_of_Not_Available_Times>".count($crecs)."</Number_of_Not_Available_Times>\n";
                                        foreach($crecs as $crec){
                                                $str=$str."\t\t<Not_Available_Time>\n";
                                                $str=$str."\t\t\t<Day>".$crec->daycode."</Day>\n";
                                                $str=$str."\t\t\t<Hour>".$crec->sessioncode."</Hour>\n";
                                                $str=$str."\t\t</Not_Available_Time>\n";
                                        }
                                        $str=$str."\t</ConstraintStudentsSetNotAvailableTimes>\n\n";

                                        fwrite($fd,$str);
                                }
                        }


			$str="\t<ConstraintTeachersMaxHoursDaily>\n";
       			$str=$str."\t\t<Weight_Percentage>95</Weight_Percentage>\n";
        		$str=$str."\t\t<Maximum_Hours_Daily>7</Maximum_Hours_Daily>\n";
			$str=$str."\t</ConstraintTeachersMaxHoursDaily>\n";
                        fwrite($fd,$str);
			$str="</Time_Constraints_List>\n\n";
                        fwrite($fd,$str);



			$str="<Space_Constraints_List>\n";
			$str=$str."\t<ConstraintBasicCompulsorySpace>\n";
        		$str=$str."\t\t<Weight_Percentage>100</Weight_Percentage>\n";
			$str=$str."\t</ConstraintBasicCompulsorySpace>\n";
			$str=$str."</Space_Constraints_List>\n\n";
                        fwrite($fd,$str);
			$str="</fet>";

			fwrite($fd,$str);
			fclose($fd);
			//system("killall -9 timetablegen 2>/dev/null");
			$s=system("timetablegen --inputfile=".$ttdir."/tt.fet --outputdir=".$ttdir."/ >/dev/null 2>/dev/null",$rs);
			if($rs==0){
				$rs=$model->storetimetable();	
				if($rs==0){
					$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=classtimetable&courseid='.$courseid.'&Itemid='.$Itemid,false);
					$this->setRedirect($redirectTo,'Timetable has been generated successfully...!');
				}else{
					$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=generatetimetable&courseid='.$courseid.'&Itemid='.$Itemid,false);
					$this->setRedirect($redirectTo,'Failed to load '.$rs.' activities into the database..<br /><Try Again>');
				} 
			}else{
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=master&controller=master&layout=timetable&courseid='.$courseid.'&Itemid='.$Itemid,false);
				$this->setRedirect($redirectTo,'Could not start the timetable engine due to incorrect data. So please verify the data..');
			}
			
		}else{
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=master&controller=master&layout=timetable&courseid='.$courseid.'&Itemid='.$Itemid,false);
			$this->setRedirect($redirectTo,'Technical Problem.[Could not write data to file..], Make sure file permissions for timetable output directory, etc');
		}
	}

	function initworkload(){
		$Itemid=JRequest::getVar('Itemid');
        	$form = JRequest::get('POST');
                $model1 = & $this->getModel('managesubjects');
		$model1->initializeActivities($form['departmentid']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$form['departmentid'].'&Itemid='.$Itemid,false);
		$this->setRedirect($redirectTo,'');

	}



   	function refereshworkload(){
		$Itemid=JRequest::getVar('Itemid');
        	$form = JRequest::get('POST');
                $model1 = & $this->getModel('managesubjects');
                $model1->refereshActivities($form['departmentid']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$form['departmentid'].'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,$c.'');

        }


	function saveworkload(){
		$Itemid=JRequest::getVar('Itemid');
        	$form = JRequest::get('POST');
		$vals=$form['val'];
		foreach($vals  as $vs){
			foreach($vs as $v)
				echo $v.'&nbsp;&nbsp;';
			echo '<br />';
		}
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&Itemid='.$Itemid,false);
		$this->setRedirect($redirectTo,'');
	}

	function processtimetable() {
		$Itemid=JRequest::getVar('Itemid');
        	$form = JRequest::get('POST');
                $courseid = $form['courses'];
                $tttermid = $form['ttterms'];
                if(!$tttermid)
                {
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=createtimetable&tttermid='.$tttermid.'&courseid='.$courseid.'&Itemid='.$Itemid,false);
                	JError::raiseWarning(500,'Please select a term');
                	$this->setRedirect($redirectTo,'');
                	return;
				}
                $Itemid = JRequest::getVar('Itemid');
                $subjectid= $form['cid'][0];
                //$ids = JRequest::getVar('cid',null,'default','array');
                if($form['Go']){
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=createtimetable&tttermid='.$tttermid.'&courseid='.$courseid.'&Itemid='.$Itemid,false);
                	$this->setRedirect($redirectTo,'');
		}
                if($form['Allote']){
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=createtimetable&tttermid='.$tttermid.'&courseid='.$courseid.'&subjectid='.$subjectid.'&Itemid='.$Itemid,false);
                	$this->setRedirect($redirectTo,'');
		}
                if($form['Save']){
                	$model = & $this->getModel('timetable');
                	$model1 = & $this->getModel('managesubjects');
			$dss = $form['ds'];
			foreach($dss as $ds){
				list($dayid,$sessionid) = explode(':',$ds);
 				$rs = $model1->getSubjectTeachers($courseid,$subjectid,$staffrecs);
				foreach($staffrecs as $ffrec){
        				$r=$model->addTimeTableEntry($tttermid,$courseid,$dayid,$sessionid,$subjectid,$ffrec->id);
				}
			}
			
               		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=createtimetable&tttermid='.$tttermid.'&courseid='.$courseid.'&subjectid='.$subjectid.'&Itemid='.$Itemid,false);
                	$this->setRedirect($redirectTo,'');
		}
		
	}

	function institutetimetable() {
        	$viewLayout = JRequest::getCmd('layout', 'default');
        	$form = JRequest::get('POST');
                if($form['Go']){
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout='.$viewLayout.'&Itemid='.$form['Itemid'].'&idate='.$form['idate'],false);
                	$this->setRedirect($redirectTo,'');
		}
                if($form['show']){
				$hstaffid=$form['hstaffid'];
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout='.$viewLayout.'&Itemid='.$form['Itemid'].'&hstaffid='.$hstaffid.'&idate='.$form['idate'],false);
                	$this->setRedirect($redirectTo,'');
		}
	}

	function viewclasstimetable() {
        	$form = JRequest::get('POST');
                $courseid = $form['courses'];
                $Itemid = JRequest::getVar('Itemid');
               	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=classtimetable&courseid='.$courseid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');

	}


	function viewteachertimetable() {
                $form = JRequest::get('POST');
                $hstaffid = $form['hstaffid'];
                $tttermid = $form['ttterms'];
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=teachertimetable&tttermid='.$tttermid.'&hstaffid='.$hstaffid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');

        }

   	function saveteacherconstraints(){
                $Itemid = JRequest::getVar('Itemid');
                $staffid= JRequest::getVar('staffid');
                $form = JRequest::get('POST');
                $departmentid= $form['departmentid'];
                if(isset($form['Cancel'])){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
                        $this->setRedirect($redirectTo,'');
                        return;
                }
                $slots= $form['slot'];
                $model = & $this->getModel('timetable');
		$rs=$model->saveteachernotavailableslots($staffid,$slots);
		if($rs)
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
		else
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=teacherconstraints&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');
	}


        function saveclassconstraints(){
                $Itemid = JRequest::getVar('Itemid');
                $classid= JRequest::getVar('classid');
                $form = JRequest::get('POST');
                $departmentid= $form['departmentid'];
                if(isset($form['Cancel'])){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
                        $this->setRedirect($redirectTo,'');
                        return;
                }
                $slots= $form['slot'];
                $model = & $this->getModel('timetable');
                $rs=$model->saveclassnotavailableslots($classid,$slots);
                if($rs)
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
                else
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=classconstraints&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');
        }


	function saveactivityconstraints(){
                $Itemid = JRequest::getVar('Itemid');
                $form = JRequest::get('POST');
                $departmentid= $form['departmentid'];
//print_r($form);return;
		if(isset($form['Cancel'])){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
                	$this->setRedirect($redirectTo,'');
			return;
		}
		if(isset($form['consecutive'])) $form['consecutive']=1;
		else $form['consecutive']=0;
                $obj->duration= $form['duration'];
                $obj->mindays = $form['mindays'];
                $obj->rate= $form['rate'];
                $obj->psrate= $form['psrate'];
                $obj->consecutive= $form['consecutive'];
                $activityid= $form['activityid'];
                $slots= $form['slot'];
                $model = & $this->getModel('timetable');
		$rs = $model->updateactivityconstraint($activityid,$obj);
		if($rs)
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&departmentid='.$departmentid.'&layout=workload&Itemid='.$Itemid,false);
		else
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=activityconstraints&departmentid='.$departmentid.'&Itemid='.$Itemid,false);

		$rs=$model->saveactivitytimings($activityid,$slots);
		if($rs)
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
		else
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=activityconstraints&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');
	}

        function resetclassconstraints(){
                $Itemid = JRequest::getVar('Itemid');
                $form = JRequest::get('POST');
                $model1 = & $this->getModel('managesubjects');
                $r=$model1->resetClassConstraints($form['departmentid']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$form['departmentid'].'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');

        }

        function resetactivityconstraints(){
                $Itemid = JRequest::getVar('Itemid');
                $form = JRequest::get('POST');
                $model1 = & $this->getModel('managesubjects');
                $r=$model1->resetActivityConstraints($form['departmentid']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$form['departmentid'].'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');

        }


	function resetstaffconstraints(){
                $Itemid = JRequest::getVar('Itemid');
                $form = JRequest::get('POST');
                $model1 = & $this->getModel('managesubjects');
                $r=$model1->resetStaffConstraints($form['departmentid']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=workload&departmentid='.$form['departmentid'].'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');

	}
	function combineclasses(){
	}

	function savecombinedclasses(){
                $form = JRequest::get('POST');
                $Itemid = JRequest::getVar('Itemid');
		if(count($form['com'])<2){
                        JError::raiseWarning(500,'Please select at least two activities to combine...');
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=combineclasses&departmentid='.$form['departmentid'].'&Itemid='.$Itemid,false);
	                $this->setRedirect($redirectTo,'');
		}else{
	                $model1 = & $this->getModel('timetable');
        	        $r=$model1->combineclasses($form['com']);
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=combineclasses&departmentid='.$form['departmentid'].'&Itemid='.$Itemid,false);
	                $this->setRedirect($redirectTo,'Combined Successfully...!');
		}
	}

	function deletecombinedclasses(){
                $Itemid = JRequest::getVar('Itemid');
                $departmentid= JRequest::getVar('departmentid');
                $comid= JRequest::getVar('comid');
	        $model1 = & $this->getModel('timetable');
        	$r=$model1->deletecombinedclasses($comid);
		if($r){
	                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=combineclasses&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
		        $this->setRedirect($redirectTo,'Deleted Successfully...!');
		}else{
                        JError::raiseWarning(500,'Could not delete combined class...');
	                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=combineclasses&departmentid='.$departmentid.'&Itemid='.$Itemid,false);
	                $this->setRedirect($redirectTo,'');
		}
	}

}
