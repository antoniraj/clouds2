<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerSendmail extends JController
{
    function validateuser()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
    }

   function sendmail()
    {
	$this->validateuser();
	$form = JRequest::get('POST');
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=principal&controller=principal&task=display&Itemid='.$Itemid,false);
	
	$model1=& $this->getModel('cce');
    // use wordwrap() if lines are longer than 70 characters
	$msg = wordwrap($form['message'],70);
	foreach($form['To'] as $staffid){
		$status = $model1->getStaff($staffid,$to);
		$Emailto = $to->email;
		 if ($Emailto != '' && $form['subject'] != '' && $msg !='' && $form['from'] != '') {                
            if (mail ($Emailto, $form['subject'],$msg,$form['from'])) { 
            $this->setRedirect($redirectTo,'Your message has been sent!');
			} else { 
           
            JError::raiseWarning(500,'Something went wrong, go back and try again!');
			$this->setRedirect($redirectTo,'Retry...');
        }
		} else {
			JError::raiseWarning(500,'Please fill in all required fields!!');
			$this->setRedirect($redirectTo,'Retry...');
		}
	}
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
	$view->setModel($model1,true);
	$view->setModel($model2,true);
	$view->setModel($model3,true);
	$view->setModel($model4,true);
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }

}
