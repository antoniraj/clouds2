<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
require_once('helper.php'); 
class CCEControllerHallTicket extends JController {

        function validateuser(){
                if(! Helper::checkuser()){
                        $redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
                        $this->setRedirect($redirectTo,'Please Login...');
                        return;
                }
        }

   	function display() {
		$this->validateuser();
		$document = JFactory::getDocument();
        	$viewType = $document->getType();
	        $viewName = JRequest::getCmd('view', $this->default_view);
        	$viewLayout = JRequest::getCmd('layout', 'default');
	        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		
		$model=& $this->getModel('sms');
                $model1=& $this->getModel('managesubjects');
                $model2=& $this->getModel('tngradebook');
                if($model==true){
                        $view->setModel($model,true);
                        $view->setModel($model1);
                        $view->setModel($model2);
                }
                $view->setLayout($viewLayout);
	        $view->display();

    	}

	function task(){
		$this->validateuser();
                $data= JRequest::get('POST');
                $examid= JRequest::getVar('examid');
                $Itemid= JRequest::getVar('Itemid');
                $ttid= JRequest::getVar('tt');
                $cid= JRequest::getVar('cid');
                $sid= JRequest::getVar('sid');

		if($data['print2']){
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=hallticket&controller=hallticket&layout=print&task=display&examid='.$examid.'&ttid='.$ttid.'&cid='.$cid.'&sid='.$sid.'&Itemid='.$Itemid,false);
	        	$this->setRedirect($redirectTo);
			return;
			
		}
		if($data['print1']){
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=hallticket&controller=hallticket&layout=printall&task=display&examid='.$examid.'&ttid='.$ttid.'&cid='.$cid.'&sid='.$sid.'&Itemid='.$Itemid,false);
	        	$this->setRedirect($redirectTo);
			return;
		}
			

		if($examid&&!$ttid&&!$cid){
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=hallticket&controller=hallticket&task=display&examid='.$examid.'&ttid=&cid=&sid=&Itemid='.$Itemid,false);
		}else{
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=hallticket&controller=hallticket&task=display&ttid='.$ttid.'&examid='.$examid.'&cid='.$cid.'&sid='.$sid.'&Itemid='.$Itemid,false);
		}
	        $this->setRedirect($redirectTo);
	}
}

