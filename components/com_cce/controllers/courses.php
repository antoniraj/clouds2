<?php
 
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerCourses extends JController
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
	switch($view){
		case 'courses':
        		switch($task)
        		{
                		case 'displayCourses':
                        		$this->displayCourses();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeCourse($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addcourse&controller=courses&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'Course - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&task=add'.'&view=addcourse&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Course - Add Dialog');
					}
					break;
				default:
                        		$this->displayCourses();
			}
			break;
		case 'addcourse':
			switch($task)
			{
				case 'add':
					$this->addCourse();
					break;
				case 'edit':
					$this->editCourse();
					break;
				case 'save':
					$this->saveCourse();
					break;
				default:
					echo "AddCourse-Wrong Task...";
			}
			break;
		case 'showcourses':
			switch($task)
			{
				case 'display':
					$this->showCourses();
					break;
				default:
					$this->showCourses();
			}
			break;	
		case 'showcourseprofile':
			switch($task)
			{
				case 'display':
					$this->showCourseProfile($courseid);
					break;
				default:
					$this->showcourseprofile($courseid);
			}
			break;
		case 'showcourseprofilenormal':
                        switch($task)
                        {
                                case 'display':
								       $form = JRequest::get('POST');   
                                        $this->showCourseProfileNormal($form['courses']);
                                        break;
                                default:
                                        $this->showcourseprofilenormal($courseid);
                        }
                        break;

		default:
			echo "Courses-Wrong View..";
	}

     }

    function displayCourses()
    {

 // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
//	$viewName=JRequest::getVar('view','courses');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display();
    }


    function showCourses()
    {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('cce');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

    function showCourseProfileNormal($courseid)
    {

        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('managesubjects');
        $model2=& $this->getModel('tngradebook');
        //$model3=& $this->getModel('ngradebook');
        if($model==true){
                $view->setModel($model,true);
                $view->setModel($model2);
                //$view->setModel($model3);
        }
        $view->setLayout($layoutName);
        $view->display($courseid);
    }




    function showCourseProfile($courseid)
    {

        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('managesubjects');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($layoutName);
        $view->display($courseid);
    }


 
    function addCourse()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editCourse()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=courses&controller=courses&task=display',false);
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

                //For insert and update
	function saveCourse()
	{
		$course = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=courses&controller=courses&task=display&Itemid='.$course['Itemid'],false);
		$model = & $this->getModel('cce');
		if($course['id']){
			$status = $model->updateCourse($course['id'],$course['coursename'],$course['sectionname'],$course['code'],$course['assessmenttype'],$course['filename'],$course['courseno']);
		}else{
			$status = $model->addCourse($course['coursename'],$course['sectionname'],$course['code'],$course['assessmenttype'],$course['filename'],$course['aid'],$course['courseno']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'Course Saved...');
		}
	}


	function removeCourse($ids=null, $Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=courses&controller=courses&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('cce');
		$status=$model->deleteCourse($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=courses&controller=courses&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}

}

