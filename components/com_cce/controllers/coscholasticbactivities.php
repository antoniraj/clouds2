<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerCoScholasticBActivities extends JController
{

    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$view = JRequest::getVar('view');
        $task = JRequest::getVar('task');
	switch($view){
		case 'coscholasticbactivities':
        		switch($task)
        		{
                		case 'displayCoScholasticBActivities':
                        		$this->displayCoScholasticBActivities();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeCoScholasticBActivity($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addcoscholasticbactivity&controller=coscholasticbactivities&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'CoScholasticB Activity - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=add'.'&controller=coscholasticbactivities&view=addcoscholasticbactivity&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'CoScholasticB Activity - Add Dialog');
					}
					break;
				default:
                        		$this->displayCoScholasticBActivities();
			}
			break;
		case 'addcoscholasticbactivity':
			switch($task)
			{
				case 'add':
					$this->addCoScholasticBActivity();
					break;
				case 'edit':
					$this->editCoScholasticBActivity();
					break;
				case 'save':
					$this->saveCoScholasticBActivity();
					break;
				default:
					echo "ERROR";
			}
			break;
	}

     }

    function displayCoScholasticBActivities()
    {


/*
        $user =& JFactory::getUser();
        $fl=0;
        foreach ($user->groups as $groupId => $value){
                $db = JFactory::getDbo();
                $db->setQuery(
                    'SELECT `title`' .
                    ' FROM `#__usergroups`' .
                    ' WHERE `id` = '. (int) $groupId
                );
                $groupName = $db->loadResult();
                if($groupName=='0ffice Manager'){
                         $fl=1;
                         break;
                }
                
        }

        if($fl==0) {
                echo "ERROR";
                return;
        }
*/


	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
//	$viewName=JRequest::getVar('view','coscholasticbactivities');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('coscholasticb');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display();
    }

 
    function addCoScholasticBActivity()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('coscholasticb');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editCoScholasticBActivity()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=coscholasticbactivities&controller=coscholasticbactivities&task=display',false);
			$this->setRedirect($redirectTo,'Please select a record...');
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('coscholasticb');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($ids[0]);
	}

                //For insert and update
	function saveCoScholasticBActivity()
	{
		$coscholasticbactivity = JRequest::get('POST');
		//$s = preg_match("/[a-zA-Z]+/",$coscholasticbactivity['coscholasticbactivity']);
		//if($s==1){
		//	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addcoscholasticbactivity&controller=coscholasticbactivities&task=add'.'&coscholasticbactivity='.$coscholasticbactivity['coscholasticbactivity'].'&status='.$coscholasticbactivity['status']);
		//	JError::raiseWarning(500,'Wrong coscholasticbactivity..');
		//	$this->setRedirect($redirectTo,'Retry...');
		//	return;
		//}

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=coscholasticbactivities&controller=coscholasticbactivities&task=display&Itemid='.$coscholasticbactivity['Itemid'],false);
		$model = & $this->getModel('coscholasticb');
		if($coscholasticbactivity['id']){
			$status = $model->updateCoScholasticBActivity($coscholasticbactivity['id'],$coscholasticbactivity['activityname'],$coscholasticbactivity['activitycode'],$coscholasticbactivity['description']);
		}else{
			$status = $model->addCoScholasticBActivity($coscholasticbactivity['activityname'],$coscholasticbactivity['activitycode'],$coscholasticbactivity['description']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'CoScholasticB Activity Saved...');
		}
	}


	function removeCoScholasticBActivity($ids=null,$Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=coscholasticbactivities&controller=coscholasticbactivities&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('coscholasticb');
		$status=$model->deleteCoScholasticBActivity($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=coscholasticbactivities&controller=coscholasticbactivities&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}
}

