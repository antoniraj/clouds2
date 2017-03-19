<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
/**
 */
class CCEControllerMaster extends JController
{
    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}else{
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model=& $this->getModel('cce');
		$model1=& $this->getModel('classattendance');
		if($model==true){
			$view->setModel($model,true);
			$view->setModel($model1,true);
		}
		$view->setLayout($viewLayout);
		$view->display();
    	}
    }
    
    function schoolSetup()
    	{
        	$model = & $this->getModel('cce');
        	$form = JRequest::get('POST');
        	$status = $model->setSchoolInfo($form);
        	 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=master&controller=master&layout=schoolsetup&task=display&Itemid='.$Itemid,false);
             	
        	if($status==false){
                        JError::raiseWarning(500,'Could not save record');
                        $this->setRedirect($redirectTo,'');
                }else{
                        $this->setRedirect($redirectTo,'Setup has been Updated');
                }
    	}
}

