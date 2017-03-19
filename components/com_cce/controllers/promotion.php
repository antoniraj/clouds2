<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

require_once('helper.php'); 

class CCEControllerPromotion extends JController
{

	function validateuser()
	{
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
        	$model=& $this->getModel('promotion');
	        if($model==true){
        	        $view->setModel($model,true);
	        }
        	$view->setLayout($viewLayout);
	        $view->display();
    	}

	function promoteandtransfer(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=promotion&controller=promotion&task=display&layout=promotion&courses='.$sc['courseid'].'&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('promotion');
		if($sc['command']=='Restart'){
			$this->restart($sc['courseid']);
			return;
		}
		if($sc['command']=='Promote'){
			foreach ($sc['status'] as $st)
			{
				list($sid,$sta)=explode(':',$st);
				if($sta=='1')
	                		$status = $model->addPromotion($sc['courseid'],$sid,$sta,$sc['pcourses']);
				if($sta=='0')
	                		$status = $model->addPromotion($sc['courseid'],$sid,$sta,$sc['npcourses']);
			}	
	                $status = $model->addPromotionStatus($sc['courseid'],'1');
		}
                $this->setRedirect($redirectTo,'');
	}

	function restart($cid)
        {
		$Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=promotion&controller=promotion&task=display&layout=promotion&courses='.$cid.'&Itemid='.$sc['Itemid'],false);
                if($cid==null){
                        //Make sure the id parameter was in the request
                        JError::raiseWarning(500,'Record not found..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('promotion');
                $status=$model->deletePromotion($cid);
                $status=$model->deletePromotionStatus($cid);
                if($status==true)
                        $this->setRedirect($redirectTo,'Records have been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }
}
