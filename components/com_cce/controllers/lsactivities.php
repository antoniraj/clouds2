<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerLSActivities extends JController
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
		case 'lsactivities':
        		switch($task)
        		{
                		case 'displayLSActivities':
                        		$this->displayLSActivities();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeLSActivity($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addlsactivity&controller=lsactivities&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'Life Skills Activity - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addlsactivity&controller=lsactivities&task=add&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Life Skills Activity - Add Dialog');
					}
					break;
				default:
                        		$this->displayLSActivities();
			}
			break;
		case 'addlsactivity':
			switch($task)
			{
				case 'add':
					$this->addLSActivity();
					break;
				case 'edit':
					$this->editLSActivity();
					break;
				case 'save':
					$this->saveLSActivity();
					break;
				default:
					echo "Wrong Task..[addlsactivity]";
			}
			break;
	}

     }

    function displayLSActivities()
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
//	$viewName=JRequest::getVar('view','lsactivities');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->displayLSActivities();
    }

 
    function addLSActivity()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editLSActivity()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=lsactivities&controller=lsactivities&task=display',false);
			$this->setRedirect($redirectTo,'Please select a record...');
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('cce');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($ids[0]);
	}

                //For insert and update
	function saveLSActivity()
	{
		$lsactivity = JRequest::get('POST');
		//$s = preg_match("/[a-zA-Z]+/",$lsactivity['lsactivity']);
		//if($s==1){
		//	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addlsactivity&controller=lsactivities&task=add'.'&lsactivity='.$lsactivity['lsactivity'].'&status='.$lsactivity['status']);
		//	JError::raiseWarning(500,'Wrong lsactivity..');
		//	$this->setRedirect($redirectTo,'Retry...');
		//	return;
		//}

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=lsactivities&controller=lsactivities&task=display&Itemid='.$lsactivity['Itemid'],false);
		$model = & $this->getModel('cce');
		if($lsactivity['id']){
			$status = $model->updateLSActivity($lsactivity['id'],$lsactivity['activityname'],$lsactivity['activitycode'],$lsactivity['description']);
		}else{
			$status = $model->addLSActivity($lsactivity['activityname'],$lsactivity['activitycode'],$lsactivity['description']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'Life Skills Activity Saved...');
		}
	}


	function removeLSActivity($ids=null,$Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=lsactivities&controller=lsactivities&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('cce');
		$status=$model->deleteLSActivity($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=lsactivities&controller=lsactivities&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}
}

