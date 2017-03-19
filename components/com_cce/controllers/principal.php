<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerPrincipal extends JController
{
    function validateuser()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
    }

   function display()
    {
	$this->validateuser();
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('classattendance');
	$model1=& $this->getModel('news');
	$model2=& $this->getModel('sms');
	$model3=& $this->getModel('officedesk');
	$model4=& $this->getModel('staffattendance');
	$model5=& $this->getModel('classleave');
	$model6=& $this->getModel('timetable');
	$model7=& $this->getModel('cce');
	$model8=& $this->getModel('managesubjects');
	$model9=& $this->getModel('schoolcal');
	
	$view->setModel($model1,true);
	$view->setModel($model2,true);
	$view->setModel($model3,true);
	$view->setModel($model4,true);
	$view->setModel($model5,true);
	$view->setModel($model6,true);
	$view->setModel($model7,true);
	$view->setModel($model8,true);
		$view->setModel($model9,true);
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }

}
