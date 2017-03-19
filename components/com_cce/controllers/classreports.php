<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
class CCEControllerClassReports extends JController
{
    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model= & $this->getModel('managesubjects');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

    function showcourseprofile()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$document = JFactory::getDocument();
	$courseid = JRequest::getVar('courseid');
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model= & $this->getModel('managesubjects');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($layoutName);
        $view->display($courseid);

    }

    function showcourseprofilenormal()
    {
        if(! Helper::checkuser()){
                        $redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
                        $this->setRedirect($redirectTo,'Please Login...');
        }
        $document = JFactory::getDocument();
        $courseid = JRequest::getVar('courseid');
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model= & $this->getModel('managesubjects');
        $model1= & $this->getModel('nmarks');
        $model2= & $this->getModel('tngradebook');
        if($model==true){
                $view->setModel($model,true);
                $view->setModel($model1);
                $view->setModel($model2);
        }
        $view->setLayout($layoutName);
        $view->display($courseid);

    }


    function classtermreport()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
        $courseid = JRequest::getVar('courseid');
        $subjectid = JRequest::getVar('subjectid');
        $termid= JRequest::getVar('termid');
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('marks');
        if($model==true){
                $view->setModel($model,true);
        }
        $subjectsmodel=& $this->getModel('managesubjects');
        $view->setModel($subjectsmodel);
        $view->setLayout($viewLayout);
        $view->display($courseid,$subjectid,$termid);
     }

    function studenttermreport()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
        $courseid = JRequest::getVar('courseid');
        $reportid= JRequest::getVar('report');
        $studentid = JRequest::getVar('studentid');
        $termid= JRequest::getVar('termid');
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('marks');
        $model1=& $this->getModel('classattendance');
        $model2=& $this->getModel('classleave');
        $model3=& $this->getModel('schoolcal');
        if($model==true){
                $view->setModel($model,true);
                $view->setModel($model1);
                $view->setModel($model2);
                $view->setModel($model3);
        }
        $cosmarks=& $this->getModel('cosmarks');
        $view->setModel($cosmarks);
        $sbgrades=& $this->getModel('scholasticbgrades');
        $view->setModel($sbgrades);
        $subjectsmodel=& $this->getModel('managesubjects');
        $view->setModel($subjectsmodel);
        $view->setLayout($viewLayout);
        $view->studentreports($courseid,$studentid,$termid,$reportid);
     }


    function back()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$referer = JRequest::getString('referer', JURI::base(), 'post');
	$referer = base64_decode($referer);
	$this->setRedirect($referer); 
    }
}


