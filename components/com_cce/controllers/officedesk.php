<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
/**
 */
class CCEControllerOfficeDesk extends JController
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
		$model=& $this->getModel('officedesk');
		if($model==true){
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->display();
    	}
    }

    function setofficedesk()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('officedesk');
	$model1=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
		$view->setModel($model1);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }


    function save()
    {
                $desk = JRequest::get('POST');
		$desk['message']=JRequest::getVar( 'message', '', 'post', 'string', JREQUEST_ALLOWHTML );
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=officedesk&controller=officedesk&task=setofficedesk&Itemid='.$desk['Itemid'],false);
                $model = & $this->getModel('officedesk');
                if($desk['id']){
                        $status = $model->updateDeskInfo($desk['id'],$desk['message']);
                }else{
                        $status = $model->saveDeskInfo($desk['message']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Office Desk has been Saved...');
                }
    }

}

