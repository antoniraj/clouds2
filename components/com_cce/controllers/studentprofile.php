<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerStudentProfile extends JController
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
	$model = & $this->getModel('marks');
        $model2 = & $this->getModel('managesubjects');
	$m3= & $this->getModel('cosmarks');
	$m4= & $this->getModel('scholasticbgrades');
	$m5= & $this->getModel('classattendance');
	$m6= & $this->getModel('classleave');
	$m7= & $this->getModel('nmarks');
	$m8= & $this->getModel('tngradebook');
	$m9= & $this->getModel('classleave');
	$m10= & $this->getModel('classattendance');
	$m11= & $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
		$view->setModel($model2);
		$view->setModel($m3);
		$view->setModel($m4);
		$view->setModel($m5);
		$view->setModel($m6);
		$view->setModel($m7);
		$view->setModel($m8);
		$view->setModel($m9);
		$view->setModel($m10);
		$view->setModel($m11);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }

}
