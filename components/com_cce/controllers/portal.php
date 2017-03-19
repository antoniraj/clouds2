<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
/**
 */
class CCEControllerPortal extends JController
{
    function display()
    {
	if(! Helper::checkuser()){ 
                $redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        	$this->setRedirect($redirectTo,'Please Login1...');
	}else{	
		$model=& $this->getModel('cce');
		if(Helper::checkgroup('Teacher')){
			$Itemid=$model->getMenuItemId('teachermenu','TeacherMenu');	
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=teacherlogin&controller=teacherlogin&Itemid='.JRequest::getVar('Itemid'),false);
			$this->setRedirect($redirectTo,'Teacher\'s Portal');
		}else if(Helper::checkgroup('Principal')){
			$Itemid=$model->getMenuItemId('principal','Principal');	
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=principal&controller=principal&Itemid='.$Itemid,false);
			$this->setRedirect($redirectTo,'Principal\'s Portal');
		}else if(Helper::checkgroup('Office')){
			$Itemid=$model->getMenuItemId('manageschool','Portal');	
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=master&controller=master&layout=dashboard&Itemid='.JRequest::getVar('Itemid'),false);
			$this->setRedirect($redirectTo,'Office Admin\'s Portal');
		}else if(Helper::checkgroup('Super Users')){
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=master&controller=master&layout=dashboard&Itemid='.JRequest::getVar('Itemid'),false);
			$this->setRedirect($redirectTo,'Admin\'s Portal');
		}
	}
	
    }
}

