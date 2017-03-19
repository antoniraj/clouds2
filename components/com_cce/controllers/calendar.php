<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerCalendar extends JController
{

    function display()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('schoolcal');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }

    function go()
    {
	$monthdate=JRequest::getVar('month');
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('schoolcal');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }

}
