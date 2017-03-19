<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

require_once('helper.php'); 

class CCEControllerExams extends JController
{

	function validateuser()
	{
		if(! Helper::checkuser()){ 
			$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
	        	$this->setRedirect($redirectTo,'Please Login...');
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
        	$model=& $this->getModel('exams');
	        if($model==true){
        	        $view->setModel($model,true);
	        }
        	$view->setLayout($viewLayout);
	        $view->display();
    	}


//GRADE BOOKS
	function gradebookactions(){
		$ids = JRequest::getVar('cid',null,'default','array');
		$form = JRequest::get('POST');

		if($form['Delete']){
	                $model = & $this->getModel('exams');
                	$Itemid= JRequest::getVar('Itemid');
                	$gbid= JRequest::getVar('gbid');
	                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradebooks&gbid='.$gbid.'&Itemid='.$Itemid,false);
        	        $rs=$model->deleteTGradeBookEntry($ids);
                	if($rs)
                        	$this->setRedirect($redirectTo,'Deleted...');
	                else
        	                $this->setRedirect($redirectTo,'Operation Failed');		
		}

		if($form['Edit']){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=addeditgradebookentry&task=display&gbid='.$form['gbid'].'&Itemid='.$form['Itemid'].'&gbeid='.$ids[0],false);
			$this->setRedirect($redirectTo,'');
		}
		if($form['Add']){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=addeditgradebookentry&gbid='.$form['gbid'].'&Itemid='.$form['Itemid'],false);
			$this->setRedirect($redirectTo,'');
		}

	}


	function savegradebookentry(){
		$gbeid='';
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
       		$status = $model->addTGradeBookEntry($sc['title'],$sc['code'],$sc['marks'],$sc['description'],$sc['gsno'],$sc['required'],$sc['parentid'],$sc['duedate'],$sc['gbid'],$sc['subtotal'],$gbeid);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradebooks&Itemid='.$sc['Itemid'].'&gbid='.$sc['gbid'].'&cmdf='.$sc['cmdf'],false);
		if($status){
	                $this->setRedirect($redirectTo,'Saved...');
                        if($sc['subtotal']=="1"){
                                foreach($sc['gbeids'] as $sb){
                                        $model->addSubTotalFields($gbeid,$sb);
                                }
                        }

		}else{
	                $this->setRedirect($redirectTo,'Could not save grade book...');
		}
	}


        function updategradebookentry(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->updateTGradeBookEntry($sc['id'],$sc['title'],$sc['code'],$sc['marks'],$sc['description'],$sc['gsno'],$sc['required'],$sc['parentid'],$sc['duedate'],$sc['gbid'],$sc['subtotal']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradebooks&Itemid='.$sc['Itemid'].'&gbid='.$sc['gbid'].'&cmdf='.$sc['cmdf'],false);
                if($status){
			$res = $model->deleteSubTotalFields($sc['id']);
			if($sc['subtotal']=="1"){
				foreach($sc['gbeids'] as $sb){
					$model->addSubTotalFields($sc['id'],$sb);
				}
			}
                        $this->setRedirect($redirectTo,'Saved...');
                }else{
                        $this->setRedirect($redirectTo,'Could not save grade book...');
                }
        }



	function savegradebook(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
		$status = $model->updateTGradeBook($sc['gbid'],$sc['title']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradebooks&Itemid='.$sc['Itemid'].'&gbid='.$sc['gbid'].'&cmdf='.$sc['cmdf'],false);
		if($status){
	                $this->setRedirect($redirectTo,'');
		}else{
	                $this->setRedirect($redirectTo,'Could not save grade book...');
		}
	}

	function showgradebook(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradebooks&Itemid='.$sc['Itemid'].'&gbid='.$sc['gbid'].'&cmdf='.$sc['cmdf'],false);
                $this->setRedirect($redirectTo,'');
	}

	function deletegradebook(){
                $model = & $this->getModel('exams');
		$gbid = JRequest::getVar('gbid');
		$Itemid= JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradebooks&gbid='.$gbid.'&Itemid='.$Itemid,false);
		$rs=$model->deleteTGradeBook($gbid);
		if($rs)
	                $this->setRedirect($redirectTo,'Deleted...');
		else
                	$this->setRedirect($redirectTo,'Operation Failed');
	
	}
	
	function savenewgradebook(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->addTGradeBook('New Grade Book - please update',$gbid);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradebooks&Itemid='.$sc['Itemid'].'&gbid='.$gbid.'&cmdf='.$sc['cmdf'],false);
                $this->setRedirect($redirectTo,'');
        }


//GRADING SYSTEM

     	function gradingsystemactions(){
                $ids = JRequest::getVar('cid',null,'default','array');
                $form = JRequest::get('POST');

                if($form['Delete']){
                        $model = & $this->getModel('exams');
                        $Itemid= JRequest::getVar('Itemid');
                        $gsid= JRequest::getVar('gsid');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradingsystems&gsid='.$gsid.'&Itemid='.$Itemid,false);
                        $rs=$model->deleteGradingSystemEntry($ids);
                        if($rs)
                                $this->setRedirect($redirectTo,'Deleted...');
                        else
                                $this->setRedirect($redirectTo,'Operation Failed');
                }

                if($form['Edit']){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=addeditgradingsystementry&task=display&gsid='.$form['gsid'].'&Itemid='.$form['Itemid'].'&gseid='.$ids[0],false);
                        $this->setRedirect($redirectTo,'');
                }
                if($form['Add']){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=addeditgradingsystementry&gsid='.$form['gsid'].'&Itemid='.$form['Itemid'],false);
                        $this->setRedirect($redirectTo,'');
                }

        }


	function savegradingsystem(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
		$status = $model->updateGradingSystem($sc['gsid'],$sc['title']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradingsystems&Itemid='.$sc['Itemid'].'&gsid='.$sc['gsid'].'&cmdf='.$sc['cmdf'],false);
		if($status){
	                $this->setRedirect($redirectTo,'');
		}else{
	                $this->setRedirect($redirectTo,'Could not save grade book...');
		}
	}

	function showgradingsystem(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradingsystems&Itemid='.$sc['Itemid'].'&gsid='.$sc['gsid'].'&cmdf='.$sc['cmdf'],false);
                $this->setRedirect($redirectTo,'');
	}

	function deletegradingsystem(){
                $model = & $this->getModel('exams');
		$gsid = JRequest::getVar('gsid');
		$Itemid= JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradingsystems&gsid='.$gsid.'&Itemid='.$Itemid,false);
		$rs=$model->deleteGradingSystem($gsid);
		if($rs)
	                $this->setRedirect($redirectTo,'Deleted...');
		else
                	$this->setRedirect($redirectTo,'Operation Failed');
	
	}
	
	function savenewgradingsystem(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->addGradingSystem('New Grading System - please update',$gsid);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradingsystems&Itemid='.$sc['Itemid'].'&gsid='.$gsid.'&cmdf='.$sc['cmdf'],false);
		if($status){
                	$this->setRedirect($redirectTo,'Saved...');
		}else{
                	$this->setRedirect($redirectTo,'Failed to save...');
		}
        }

        function savegradingsystementry(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->addGradingSystemEntry($sc['from'],$sc['to'],$sc['letter'],$sc['description'],$sc['points'],$sc['gsid']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradingsystems&Itemid='.$sc['Itemid'].'&gsid='.$sc['gsid'].'&cmdf='.$sc['cmdf'],false);
                if($status){
                        $this->setRedirect($redirectTo,'Saved...');
                }else{
                        $this->setRedirect($redirectTo,'Could not save grading system entry...');
                }
        }


        function updategradingsystementry(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->updateGradingSystemEntry($sc['id'],$sc['from'],$sc['to'],$sc['letter'],$sc['description'],$sc['points'],$sc['gsid']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=gradingsystems&Itemid='.$sc['Itemid'].'&gsid='.$sc['gsid'].'&cmdf='.$sc['cmdf'],false);
                if($status){
                        $this->setRedirect($redirectTo,'Saved...');
                }else{
                        $this->setRedirect($redirectTo,'Could not save grade book...');
                }
        }


	//COURSE BOOK
        function savecoursebook(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->updateCourseBook($sc['cbid'],$sc['title']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'].'&cmdf='.$sc['cmdf'],false);
                if($status){
                        $this->setRedirect($redirectTo,'');
                }else{
                        $this->setRedirect($redirectTo,'Could not save course book...');
                }
        }

        function showcoursebook(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'].'&cmdf='.$sc['cmdf'],false);
                $this->setRedirect($redirectTo,'');
        }

        function deletecoursebook(){
                $model = & $this->getModel('exams');
                $cbid = JRequest::getVar('cbid');
                $Itemid= JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&cbid='.$cbid.'&Itemid='.$Itemid,false);
                $rs=$model->deleteCourseBook($cbid);
                if($rs)
                        $this->setRedirect($redirectTo,'Deleted...');
                else
                        $this->setRedirect($redirectTo,'Operation Failed');

        }


        function enableediting(){
                $cbid = JRequest::getVar('cbid');
                $Itemid= JRequest::getVar('Itemid');
                $eon= JRequest::getVar('eon');
                if($eon=='1') $eon='0';
                else $eon='1';
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&eon='.$eon.'&cbid='.$cbid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');

        }

        function savenewcoursebook(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->addCourseBook('New Course Book - please update',$cbid);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$cbid.'&cmdf='.$sc['cmdf'],false);
                $this->setRedirect($redirectTo,'');
        }


//PARTS
	function savepart(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->addPart($sc,$partid);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'].'&cmdf='.$sc['cmdf'],false);
  		if($status)
                        $this->setRedirect($redirectTo,'Saved...');
                else
                        $this->setRedirect($redirectTo,'Operation Failed');
        }

	function deletepart(){
                $model = & $this->getModel('exams');
                $partid= JRequest::getVar('partid');
                $cbid= JRequest::getVar('cbid');
                $Itemid= JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&cbid='.$cbid.'&Itemid='.$Itemid,false);
                $rs=$model->deletePart($partid);
                if($rs)
                        $this->setRedirect($redirectTo,'Deleted...');
                else
                        $this->setRedirect($redirectTo,'Operation Failed');

        }

        function updatepart(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->updatePart($sc);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'],false);
                if($status){
                        $this->setRedirect($redirectTo,'Saved...');
                }else{
                        $this->setRedirect($redirectTo,'Could not save part...');
                }
        }


//TERM
	function saveterm(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->addTTerm($sc);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'],false);
  		if($status)
                        $this->setRedirect($redirectTo,'Saved...');
                else
                        $this->setRedirect($redirectTo,'Operation Failed');

	}


        function updateterm(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->updateTTerm($sc);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'],false);
                if($status){
                        $this->setRedirect($redirectTo,'Saved...');
                }else{
                        $this->setRedirect($redirectTo,'Could not save term...');
                }
        }

        function deleteterm(){
                $model = & $this->getModel('exams');
                $termid= JRequest::getVar('termid');
                $cbid= JRequest::getVar('cbid');
                $Itemid= JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&cbid='.$cbid.'&Itemid='.$Itemid,false);
                $rs=$model->deleteTTerm($termid);
                if($rs)
                        $this->setRedirect($redirectTo,'Deleted...');
                else
                        $this->setRedirect($redirectTo,'Operation Failed');

        }



//SUBJECT
  	function savesubject(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->addTSubject($sc,$subjectid);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'].'&cmdf='.$sc['cmdf'],false);
                $this->setRedirect($redirectTo,'');
        }


        function updatesubject(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('exams');
                $status = $model->updateTSubject($sc);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'],false);
                if($status){
                        $this->setRedirect($redirectTo,'Saved...');
                }else{
                        $this->setRedirect($redirectTo,'Could not save subject...');
                }
        }

        function deletesubject(){
                $model = & $this->getModel('exams');
                $subjectid= JRequest::getVar('subjectid');
                $cbid= JRequest::getVar('cbid');
                $Itemid= JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&cbid='.$cbid.'&Itemid='.$Itemid,false);
                $rs=$model->deleteTSubject($subjectid);
                if($rs)
                        $this->setRedirect($redirectTo,'Deleted...');
                else
                        $this->setRedirect($redirectTo,'Operation Failed');

        }



//SUBJECT GRADE BOOK
     	function deletesubjectgradebook(){
                $model = & $this->getModel('exams');
                $subjectid= JRequest::getVar('subjectid');
                $termid= JRequest::getVar('termid');
                $cbid= JRequest::getVar('cbid');
                $Itemid= JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&cbid='.$cbid.'&Itemid='.$Itemid,false);
                $rs=$model->deleteSubjectGradeBook($subjectid,$termid);
                if($rs)
                        $this->setRedirect($redirectTo,'Deleted...');
                else
                        $this->setRedirect($redirectTo,'Operation Failed');

	}

	
    	function savesubjectgradebook(){
                $subjectid = JRequest::getVar('subjectid');
                $termid= JRequest::getVar('termid');
                $gbid = JRequest::getVar('gbid');
                $cbid= JRequest::getVar('cbid');
		$sc['subjectid']=$subjectid;
		$sc['termid']=$termid;
		$sc['cbid']=$cbid;
		$sc['gbid']=$gbid;
                $model = & $this->getModel('exams');
                $status = $model->addSubjectTermGradeBook($sc);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'],false);
                $this->setRedirect($redirectTo,'');
        }


//SUBJECT GRADING SYSTEM

   	function deletesubjectgradingsystem(){
                $model = & $this->getModel('exams');
                $subjectid= JRequest::getVar('subjectid');
                $gsid= JRequest::getVar('gsid');
                $cbid= JRequest::getVar('cbid');
                $Itemid= JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&cbid='.$cbid.'&Itemid='.$Itemid,false);
                $rs=$model->deleteSubjectGradingSystem($subjectid,$gsid);
                if($rs)
                        $this->setRedirect($redirectTo,'Deleted...');
                else
                        $this->setRedirect($redirectTo,'Operation Failed');

        }


        function savesubjectgradingsystem(){
                $subjectid = JRequest::getVar('subjectid');
                $gsid = JRequest::getVar('gsid');
                $cbid= JRequest::getVar('cbid');
                $sc['subjectid']=$subjectid;
                $sc['cbid']=$cbid;
                $sc['gsid']=$gsid;
                $model = & $this->getModel('exams');
                $status = $model->addSubjectGradingSystem($sc);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&task=display&layout=coursebooks&Itemid='.$sc['Itemid'].'&cbid='.$sc['cbid'],false);
                $this->setRedirect($redirectTo,'');
        }


	//COURSE BOOK COURSES
	function assigncourses()
	{
                $form = JRequest::get('POST');
                $Itemid= JRequest::getVar('Itemid');
                $cids = $form['cid'];
                $model=& $this->getModel('exams');
                foreach($cids as $cid){
                        $model->addCourseBookCourse($cid,$form['cbid']);
                }
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=coursebooks&cbid='.$form['cbid'].'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');

	}
	
	function deletecoursebookcourses(){
                $form = JRequest::get('POST');
   		$Itemid= JRequest::getVar('Itemid');
                $cids = $form['cid'];
                $model=& $this->getModel('exams');
                foreach($cids as $cid){
                        $model->deleteCourseBookCourse($cid,$form['cbid']);
                }
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=coursebooks&cbid='.$form['cbid'].'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');

	}



	function loadCourseGradeBookEntries($model,$cid,$sid,$tid,$gbeid,$newparentid){
			$crecs = $model->getTGradeBookChildEntries($gbeid);
			if(count($crecs)>0){
				foreach($crecs as $crec){
					$rs=$model->addCourseGradeBookChildEntry($cid,$sid,$tid,$crec->title,$crec->code,$crec->weightage,$crec->description,$crec->required,$crec->gsno,$crec->duedate,$newparentid,$crec->id,$cnewparentid);
					if($rs){
						$this->loadCourseGradeBookEntries($model,$cid,$sid,$tid,$crec->id,$cnewparentid);
					}
				}
				return;
			}else{
				return;
			}
	}


	function generategradebooks()
	{
                $model=& $this->getModel('exams');
   		$cbid= JRequest::getVar('cbid');
		$parts = $model->getParts($cbid);
		$courses = $model->getCourseBookCourses($cbid);
		foreach($courses as $course){
			foreach($parts as $part){
				$terms = $model->getTTerms($part->id);
				$subjects  = $model->getTSubjects($part->id);
				foreach($subjects as $subject){
					foreach($terms as $term){
        					if($model->getSubjectTermGradeBook($subject->id,$term->id,$stgbrec)){
        						$gberecs = $model->getTGradeBookParentEntries($stgbrec->gbid);
							foreach($gberecs as $gberec){
								if($model->addCourseGradeBookParentEntry($course->id,$subject->id,$term->id,$gberec->title,$gberec->code,$gberec->weightage,$gberec->description,$gberec->required,$gberec->gsno,$gberec->duedate,$gberec->id,$gberec->subtotalfield,$newparentid)){
									$this->loadCourseGradeBookEntries($model,$course->id,$subject->id,$term->id,$gberec->id,$newparentid);
								}else{
								//	echo 'failed'.'<br />';
								}

							}//gberecs
						}
					}//term
				}//subjects
			}//parts
		}//courses
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=coursebooks&cbid='.$cbid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'Course Grade Books have been generated...');
		
	}


	function deleteallsubjectmarks(){
		$form['gbeid']=JRequest::getVar('gbeid');
		$form['subjectid']=JRequest::getVar('subjectid');
		$form['classid']=JRequest::getVar('courseid');
		$form['termid']=JRequest::getVar('termid');
		$form['eon']=JRequest::getVar('eon');
		$Itemid =JRequest::getVar('Itemid');
                $model=& $this->getModel('exams');
	        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=marksentry&gbeid='.$form['gbeid'].'&subjectid='.$form['subjectid'].'&termid='.$form['termid'].'&classid='.$form['classid'].'&eon='.$form['eon'].'&Itemid='.$Itemid,false);
		$r = $model->deleteAllSubjectMarks($form['gbeid']);
		if($r){
                	$this->setRedirect($redirectTo,'');
		}else{
                	$this->setRedirect($redirectTo,'Could not reset..');
		}
	}

	function savemarksentry(){
                $form = JRequest::get('POST');
                $Itemid= JRequest::getVar('Itemid');
		$gbeid= $form['gbeid'];
		$mark = $form['mark'];
		$fl= $form['fl'];
		$comment= $form['comment'];
                $model=& $this->getModel('exams');
                foreach($mark as $k=>$v){
			$arr['studentid']=$k;
			$arr['gbeid']=$gbeid;
			$arr['marks']=$v;
			$arr['comments']=$comment[$k];
			$flag = $fl[$k];
			if($flag=='a')
				$model->addStudentMark($arr);
			if($flag=='u')
				$model->updateStudentMark($arr);
                }
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=marksentry&gbeid='.$form['gbeid'].'&subjectid='.$form['subjectid'].'&termid='.$form['termid'].'&classid='.$form['classid'].'&eon=1&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');

	}

	function savesubjectgradebookentry(){
                $form = JRequest::get('POST');
                $model=& $this->getModel('exams');
		$cid=$form['classid'];
		$sid=$form['subjectid'];
		$tid=$form['termid'];
		$title=$form['title'];
		$code=$form['code'];
		$weightage=$form['marks'];
		$description=$form['description'];
		$required=0;
		$gsno=$form['gsno'];
		$duedate=$form['duedate'];
		$parentid=$form['parentid'];
		$r = $model->addSubjectGradeBookEntry($cid,$sid,$tid,$title,$code,$weightage,$description,$required,$gsno,$duedate,$parentid,$cnewparentid);
	        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=subjectgradebook&gbeid='.$gbeid.'&subjectid='.$sid.'&termid='.$tid.'&courseid='.$cid.'&eon='.$eon.'&Itemid='.$Itemid,false);
		if($r){
                	$this->setRedirect($redirectTo,'');
		}else{
                	$this->setRedirect($redirectTo,'Could not save..');
		}
	}


	function deletesubjectgradebookentry(){
                $gbeid= JRequest::getVar('gbeid');
                $subjectid= JRequest::getVar('subjectid');
                $termid= JRequest::getVar('termid');
                $eon= JRequest::getVar('eon');
                $classid= JRequest::getVar('classid');
                $model=& $this->getModel('exams');
	        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=subjectgradebook&gbeid='.$gbeid.'&subjectid='.$subjectid.'&termid='.$termid.'&courseid='.$classid.'&eon='.$eon.'&Itemid='.$Itemid,false);
		$r=$model->deleteSubjectGradeBookEntry($gbeid);
		if($r){
                	$this->setRedirect($redirectTo,'');
		}else{
                	$this->setRedirect($redirectTo,'Could not delete..');
		}
	}

	function updatesubjectgradebookentry(){
                $form = JRequest::get('POST');
	        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=subjectgradebook&subjectid='.$form['subjectid'].'&termid='.$form['termid'].'&courseid='.$form['classid'].'&eon='.$form['eon'].'&Itemid='.$Itemid,false);
                $model=& $this->getModel('exams');
		$r=$model->updateSubjectGradeBookEntry($form);
		if($r){
                	$this->setRedirect($redirectTo,'');
		}else{
                	$this->setRedirect($redirectTo,'Could not update..');
		}
	}


	function savesummarycols(){
                $form = JRequest::get('POST');
                $model=& $this->getModel('exams');
	        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=coursebooks&cbid='.$form['cbid'].'&subjectid='.$form['subjectid'].'&Itemid='.$form['Itemid'],false);
		if(strlen($form['id'])>0){
			$r=$model->updateSummaryEntry($form['id'],$form['title'],$form['code'],$form['summarytype'],$form['subjectid']);
			if($r){
				//Delere summary col entries for this summaryid
				$model->deleteSummaryColEntries($form['id']);
				//Insert ids in summary cols table
				foreach($form['gbeids'] as $gbeid){
					$a=explode(":",$gbeid);
					$model->addSummaryCols($form['id'],$a[0],$a[1]);	
				}	
                		$this->setRedirect($redirectTo,'');
			}else{
        	        	$this->setRedirect($redirectTo,'Could not save..');
			}
		}else{
			$r=$model->addSummaryEntry($form['title'],$form['code'],$form['summarytype'],$form['subjectid'],$summaryid);
			if($r){
				//Insert ids in summary cols table
				foreach($form['gbeids'] as $gbeid){
					$model->addSummaryCols($summaryid,$gbeid);	
				}	
                		$this->setRedirect($redirectTo,'');
			}else{
        	        	$this->setRedirect($redirectTo,'Could not save..');
			}
		}
	}

	function deletesummaryentry(){
		$id = JRequest::getVar('id');
		$cbid = JRequest::getVar('cbid');
                $model=& $this->getModel('exams');
	        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=exams&controller=exams&layout=coursebooks&cbid='.$cbid.'&Itemid='.$Itemid,false);
		$r = $model->deleteSummaryEntry($id);
		if($r){
                	$this->setRedirect($redirectTo,'');
		}else{
                	$this->setRedirect($redirectTo,'Could not delete..');
		}
	}
}


