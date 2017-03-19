<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerCoScholasticAActivities extends JController
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
		case 'coscholasticaactivities':
        		switch($task)
        		{
                		case 'displayCoScholasticAActivities':
                        		$this->displayCoScholasticAActivities();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeCoScholasticAActivity($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addcoscholasticaactivity&controller=coscholasticaactivities&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'CoScholasticA Activity - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=add'.'&controller=coscholasticaactivities&view=addcoscholasticaactivity&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'CoScholasticA Activity - Add Dialog');
					}
					break;
				default:
                        		$this->displayCoScholasticAActivities();
			}
			break;
		case 'addcoscholasticaactivity':
			switch($task)
			{
				case 'add':
					$this->addCoScholasticAActivity();
					break;
				case 'edit':
					$this->editCoScholasticAActivity();
					break;
				case 'save':
					$this->saveCoScholasticAActivity();
					break;
				default:
					echo "ERROR";
			}
			break;
	}

     }

    function displayCoScholasticAActivities()
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
//	$viewName=JRequest::getVar('view','coscholasticaactivities');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('coscholastica');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display();
    }

 
    function addCoScholasticAActivity()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('coscholastica');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editCoScholasticAActivity()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=coscholasticaactivities&controller=coscholasticaactivities&task=display',false);
			$this->setRedirect($redirectTo,'Please select a record...');
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('coscholastica');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($ids[0]);
	}

                //For insert and update
	function saveCoScholasticAActivity()
	{
		$coscholasticaactivity = JRequest::get('POST');
		//$s = preg_match("/[a-zA-Z]+/",$coscholasticaactivity['coscholasticaactivity']);
		//if($s==1){
		//	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addcoscholasticaactivity&controller=coscholasticaactivities&task=add'.'&coscholasticaactivity='.$coscholasticaactivity['coscholasticaactivity'].'&status='.$coscholasticaactivity['status']);
		//	JError::raiseWarning(500,'Wrong coscholasticaactivity..');
		//	$this->setRedirect($redirectTo,'Retry...');
		//	return;
		//}

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=coscholasticaactivities&controller=coscholasticaactivities&task=display&Itemid='.$coscholasticaactivity['Itemid'],false);
		$model = & $this->getModel('coscholastica');
		if($coscholasticaactivity['id']){
			$status = $model->updateCoScholasticAActivity($coscholasticaactivity['id'],$coscholasticaactivity['activityname'],$coscholasticaactivity['activitycode'],$coscholasticaactivity['description']);
		}else{
			$status = $model->addCoScholasticAActivity($coscholasticaactivity['activityname'],$coscholasticaactivity['activitycode'],$coscholasticaactivity['description']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'CoScholasticA Activity Saved...');
		}
	}


	function removeCoScholasticAActivity($ids=null,$Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=coscholasticaactivities&controller=coscholasticaactivities&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('coscholastica');
		$status=$model->deleteCoScholasticAActivity($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=coscholasticaactivities&controller=coscholasticaactivities&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}
}

