<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerSubjects extends JController
{

    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$view = JRequest::getVar('view');
        $task = JRequest::getVar('task');
	$courseid = JRequest::getVar('courseid');
	$Itemid = JRequest::getVar('Itemid');
	switch($view){
		case 'subjects':
        		switch($task)
        		{
                		case 'displaySubjects':
                        		$this->displaySubjects($courseid);
     	               			break;
				case 'actions':
                        		$form = JRequest::get('POST');
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		if($form['go']){
						 $this->displaySubjects($form['courses']);
					}else
                        		if($form['Delete']) $this->removeSubject($ids,$form['Itemid']);
					else
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addsubject&controller=subjects&courseid='.$form['courses'].'&task=edit&cid='.$ids[0].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Subject - Edit Dialog');
                        		}else
                        		if($form['Add']){
						$this->subjectList();
					}else
						 $this->displaySubjects($form['courses']);
					break;
				default:
                        		$this->displaySubjects($courseid);
			}
			break;
		case 'addsubject':
			switch($task)
			{
				case 'add':
					$this->addSubject();
					break;
				case 'assignsubjects':
					$this->saveSubjects();
					break;
				case 'edit':
					$this->editSubject();
					break;
				case 'save':
					$this->saveSubject();
					break;
				default:
					echo "ERROR";
			}
			break;
		case 'subjectteachers':
			$form = JRequest::get('POST');
                	switch($task){
				case 'assignstaff':
					$this->addSubjectTeacher($form['courses']);
					break;
				case 'save':
					$this->saveSubjectTeacher();
					break;
				case 'remove':
					$this->removeSubjectTeacher();
					break;
				default:
					if(!$form['courses']) $courseid=JRequest::getVar('courseid');
					else $courseid=$form['courses'];
					$this->showSubjectTeachers($courseid);
			}
			break;
		
		default:
			echo "ERROR";
	}

     }

    function displaySubjects($courseid=null)
    {
 // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
//	$viewName=JRequest::getVar('view','subjects');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('managesubjects');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display($courseid);
    }

    function addSubjectTeacher($courseid)
    {
        $courseid = JRequest::getVar('courseid');
        $subjectid = JRequest::getVar('subjectid');
        if(($courseid=='--Select a Course--')||(!$courseid)){
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjectteachers&controller=subjects&courseid='.JRequest::getVar('courseid').'&task=display',false);
                $this->setRedirect($redirectTo,'Please select the course/class...');
                return;
        }
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = "assignsubjectteacher";//JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        $model1 = $this->getModel('managesubjects');
        if($model==true){
                $view->setModel($model,true);
                $view->setModel($model1);
        }
        $view->setLayout($viewLayout);
        $view->display($courseid,$subjectid);
    }
	
	function saveSubjectTeacher() {
                $subjectteacher = JRequest::get('POST');
                $ids = JRequest::getVar('cid',null,'default','array');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=subjects&view=subjectteachers&courseid='.$subjectteacher['courseid'].'&Itemid='.$subjectteacher['Itemid'],false);
                $model = & $this->getModel('cce');
		foreach($ids as $id){
                	$status = $model->addSubjectTeacher($subjectteacher['courseid'],$subjectteacher['subjectid'],$id);
		}
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'ClassTeacher Saved...');
                }
        }


        function removeSubjectTeacher($ids=null) {
        	$courseid = JRequest::getVar('courseid');
	        $subjectid = JRequest::getVar('subjectid');
	        $staffid = JRequest::getVar('staffid');
		$Itemid = JRequest::getVar('Itemid');
        
	        $model = & $this->getModel('cce');
                $status=$model->deleteSubjectTeacher($courseid,$subjectid,$staffid);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=subjects&view=subjectteachers&courseid='.$courseid.'&task=display&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }


   function showSubjectTeachers($courseid=null)
    {
 // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
//      $viewName=JRequest::getVar('view','subjects');
//      $layoutName=JRequest::getVar('layout','default');
//      $view = & $this->getView($viewName);
        $model=& $this->getModel('managesubjects');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($layoutName);
        $view->display($courseid);
    }

    function subjectList() {
	$Itemid = JRequest::getVar('Itemid');
        $courseid = JRequest::getVar('courseid');
        if(($courseid=='--Select a Course--')||(!$courseid)){
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjects&controller=subjects&courseid='.JRequest::getVar('courseid').'&task=display&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'Please select the course/class');
                return;
        }
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = 'addsubject';
        $viewLayout = JRequest::getCmd('layout', 'list');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('managesubjects');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->displayList($courseid,null);
    }
 

    function addSubject() {
        $courseid = JRequest::getVar('courseid');
        if(($courseid=='--Select a Course--')||(!$courseid)){
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjects&controller=subjects&courseid='.JRequest::getVar('courseid').'&task=display',false);
                $this->setRedirect($redirectTo,'Please select the course/class...');
                return;
        }
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        if($model==true){
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editSubject()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjects&controller=subjects&courseid='.JRequest::getVar('courseid').'&task=display',false);
			$this->setRedirect($redirectTo,'Please select a record...');
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('cce');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($ids[0]);
	}


	/*
		Saves each subject with the grade book template
	*/
	function saveSubject()
	{
		$subject = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjects&controller=subjects&task=display&courseid='.$subject['courseid'].'&Itemid='.$subject['Itemid'],false);
		$model = & $this->getModel('cce');
		if($subject['id']){
			$status = $model->updateSubject($subject['id'],$subject['subjectname'],$subject['subjectcode'],$subject['hoursperweek']);
		}else{
			$status = $model->addSubject($subject['subjectname'],$subject['subjectcode'],$subject['hoursperweek'],$subject['courseid']);
			//Add Assessment Template
			if($status == true){
				$rs=$model->getSubjectId($subject['courseid'],$subject['subjectcode'],$sid);		
				if($rs==true){
					$model0 = & $this->getModel('cce');
					$model1 = & $this->getModel('tgradebook');
					$model2 = & $this->getModel('gradebook');
					$terms = $model0->getCurrentTerms();
					foreach($terms as $term){
						$categories=$model1->getTGradeBook();
						foreach($categories as $category)
						{
       							$st1=$model2->addGradeBookEntry($category->title,$category->code,$category->weightage,$category->bestof,$category->description,$sid,$term->id,$category->grouptag,$category->gsno);
							if($st1==true){
								$st0=$model2->getCategoryId($category->code,$sid,$term->id,$catid);
								if($st0==false) break;
								$categorydetails = $model1->getTGradeBookDetails($category->id);
								foreach($categorydetails as $cdrec)
								{
									$ar = explode('-',$cdrec->duedate);
									$iduedate="$ar[2]-$ar[1]-$ar[0]";
									$st2=$model2->addGradeBookDetailEntry($cdrec->title,$cdrec->code,$cdrec->marks,$iduedate,$cdrec->description,$catid);
									if($st2==false) {
	break;
}
								}	
							}else{
								//Error
								break;
							}
						}
					}
				}
			}
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'Subject Saved...');
		}
	}


	function removeSubject($ids=null,$Itemid)
	{
                $form = JRequest::get('POST');
		if($ids==null){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjects&controller=subjects&courseid='.$form['courseid'].'&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('cce');
		foreach($ids as $sid){
			$status=$model->deleteCourseSubject($form['courseid'],$sid);
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjects&controller=subjects&courseid='.$form['courseid'].'&task=display&Itemid='.$Itemid,false);
			if($status==true)
				$this->setRedirect($redirectTo,'Record has been deleted...!');
			else
				$this->setRedirect($redirectTo,'Could not delete..');
		}
	}

	function saveSubjects()
	{
		$subject = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=subjects&controller=subjects&task=display&courseid='.$subject['courseid'].'&Itemid='.$subject['Itemid'],false);
		$model = & $this->getModel('cce');
		//-----------------------------------
		$model0 = & $this->getModel('cce');
		$model1 = & $this->getModel('tgradebook');
		$model2 = & $this->getModel('gradebook');
		$model4 = & $this->getModel('ngradebook');
		$terms = $model0->getCurrentTerms();
		$model3 = & $this->getModel('tngradebook');
		$exams = $model3->getTNGradeBook();
		//Add Assessment Template
		foreach($subject['cid']  as $sid)
		{
			$rs = $model0->assignCourseSubject($subject['courseid'],$sid);
			if($rs==true)
			{
			    $model->getCourse($subject['courseid'],$ccrec);
			    if($ccrec->assessmenttype=='CCE'){
				foreach($terms as $term){
					$categories=$model1->getTGradeBook();
					foreach($categories as $category)
					{
       						$st1=$model2->addGradeBookEntry($category->title,$category->code,$category->weightage,$category->bestof,$category->description,$sid,$subject['courseid'],$term->id,$category->grouptag,$category->gsno);
						if($st1==true){
							$st0=$model2->getCategoryId($category->code,$sid,$subject['courseid'],$term->id,$catid);
							if($st0==false) break;
							$categorydetails = $model1->getTGradeBookDetails($category->id);
							foreach($categorydetails as $cdrec)
							{
								$ar = explode('-',$cdrec->duedate);
								$iduedate="$ar[2]-$ar[1]-$ar[0]";
								$st2=$model2->addGradeBookDetailEntry($cdrec->title,$cdrec->code,$cdrec->marks,$iduedate,$cdrec->description,$catid);
								if($st2==false) {
									break;
								}//if
							}//for	
						}else{
							//Error
							break;
						}//if
					}//for
				}//term				
			    }else{
				//Normal Exam
				foreach($exams as $exam){
       					$s=$model4->addNGradeBookEntry($exam->title,$exam->code,$exam->marks,$exam->duedate,$exam->description,$subject['courseid'],$sid); 
				}
			    }//if
			}//if
			//if($rs==false){
			//	JError::raiseNotice(100,'Could not save record..');
			//	$this->setRedirect($redirectTo,'Retry...');
			//}else{
			//	$this->setRedirect($redirectTo,'Subject Saved...');
			//}
		}//For
		$this->setRedirect($redirectTo,'Subject Saved...');
	}
}

