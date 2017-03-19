<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerFAActivities extends JController
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
		case 'faactivities':
        		switch($task)
        		{
                		case 'displayFAActivities':
                        		$this->displayFAActivities();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeFAActivity($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addfaactivity&controller=faactivities&task=edit&cid='.$ids[0].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'FA Activity - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=add'.'&controller=faactivities&view=addfaactivity&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'FA Activity - Add Dialog');
					}
					break;
				default:
                        		$this->displayFAActivities();
			}
			break;
		case 'addfaactivity':
			switch($task)
			{
				case 'add':
					$this->addFAActivity();
					break;
				case 'edit':
					$this->editFAActivity();
					break;
				case 'save':
					$this->saveFAActivity();
					break;
				default:
					echo "ERROR";
			}
			break;
	}

     }

    function displayFAActivities()
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
//	$viewName=JRequest::getVar('view','faactivities');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->displayFAActivities();
    }

 
    function addFAActivity()
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

	function editFAActivity()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=faactivities&controller=faactivities&task=display',false);
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
	function saveFAActivity()
	{
		$faactivity = JRequest::get('POST');
		//$s = preg_match("/[a-zA-Z]+/",$faactivity['faactivity']);
		//if($s==1){
		//	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addfaactivity&controller=faactivities&task=add'.'&faactivity='.$faactivity['faactivity'].'&status='.$faactivity['status']);
		//	JError::raiseWarning(500,'Wrong faactivity..');
		//	$this->setRedirect($redirectTo,'Retry...');
		//	return;
		//}

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=faactivities&controller=faactivities&task=display&Itemid='.$faactivity['Itemid'],false);
		$model = & $this->getModel('cce');
		if($faactivity['id']){
			$status = $model->updateFAActivity($faactivity['id'],$faactivity['activityname'],$faactivity['activitycode'],$faactivity['description']);
		}else{
			$status = $model->addFAActivity($faactivity['activityname'],$faactivity['activitycode'],$faactivity['description']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'FA Activity Saved...');
		}
	}


	function removeFAActivity($ids=null,$Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=faactivities&controller=faactivities&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('cce');
		$status=$model->deleteFAActivity($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=faactivities&controller=faactivities&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}
}

