<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerSchoolCal extends JController
{
    function validateuser()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login First');
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
	$model=& $this->getModel('schoolcal');
	$model1=& $this->getModel('timetable');
	if($model==true){
		$view->setModel($model,true);
		$view->setModel($model1);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }

    function go()
    {
	$this->validateuser();
	$monthdate=JRequest::getVar('month');
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('schoolcal');
	$model1=& $this->getModel('timetable');
	if($model==true){
		$view->setModel($model,true);
		$view->setModel($model1);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }

    function save()
    {
	$this->validateuser();
	$data = JRequest::get('POST');

	$month= JRequest::getVar('month');
	$Itemid= JRequest::getVar('Itemid');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=schoolcal&view=schoolcal&Itemid='.$Itemid.'&task=display&month='.$month,false);
        $model = & $this->getModel('schoolcal');
	$n = count($data['daytype']); 
        $i=0;
        while($i<$n){
        	if($data['calid'][$i]=="-1"){
                        $status=$model->addCalEntry($data['cdate'][$i],$data['programme'][$i],$data['daytype'][$i],$data['dayorder'][$i]);
                 }else{
                	$status=$model->updateCalEntry($data['calid'][$i],$data['programme'][$i],$data['daytype'][$i],$data['dayorder'][$i]);
		
		}
		$i++;
	}
        $this->setRedirect($redirectTo,'Calendar Entry Saved');
    }
}
