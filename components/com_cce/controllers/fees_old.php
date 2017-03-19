<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

require_once('helper.php'); 

class CCEControllerFees extends JController
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
        	$model=& $this->getModel('fees');
	        if($model==true){
        	        $view->setModel($model,true);
	        }
        	$view->setLayout($viewLayout);
	        $view->display();
    	}

	function savefeecategory(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('fees');
                if($sc['id']==-1){
                        $status = $model->addFeeCategory($sc['name'],$sc['description']);
                }else{
                        $status = $model->updateFeeCategory($sc['id'],$sc['name'],$sc['description']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Fee Category has been Saved...');
                }
	}

	function deletefeecategory()
        {
		$fcid = JRequest::getVar('fcid');
		$Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&Itemid='.$Itemid,false);
                if($fcid==null){
                        //Make sure the id parameter was in the request
                        JError::raiseWarning(500,'Record not found..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeCategory($fcid);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }



	
	function deletefeecourse()
        {
		$fcid = JRequest::getVar('fcid');
		$cid = JRequest::getVar('cid');
		$Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeCourse($fcid,$cid);
                $this->setRedirect($redirectTo,'Deleted...');
	}

	function assigncourses()
	{
                $fcid = JRequest::getVar('fcid');	
                $Itemid = JRequest::getVar('Itemid');	
		//Read cid as an array
                $cids = JRequest::getVar('cid',null,'default','array');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&Itemid='.$Itemid,false);
                if($cids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('fees');
		foreach($cids as $cid){
                	$status=$model->assignFeeCourse($fcid,$cid);
		}
                $this->setRedirect($redirectTo,'');
	}

        function savefeeparticular(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&fcid='.$sc['fcid'].'&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('fees');
                if($sc['id']==-1){
                        $status = $model->addFeeParticular($sc['name'],$sc['description'],$sc['amount'],$sc['fcid']);
                }else{
                        $status = $model->updateFeeParticular($sc['id'],$sc['name'],$sc['description'],$sc['amount']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Fee has been Saved...');
                }
        }


	function deletefeeparticular()
        {
                $fcid = JRequest::getVar('fcid');
                $fpid = JRequest::getVar('fpid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&fcid='.$fcid.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeParticular($fpid);
                $this->setRedirect($redirectTo,'Deleted...');
        }
}
