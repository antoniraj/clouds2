<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerAttitudesAndValues extends JController
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
		case 'attitudesandvalues':
        		switch($task)
        		{
                		case 'displayattitudesandvalues':
                        		$this->displayAttitudesAndValues();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeAttitudeAndValue($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addattitudeandvalue&controller=attitudesandvalues&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'Attitudes And Values Activity - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addattitudeandvalue&controller=attitudesandvalues&task=add&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Attitudes And Values Activity - Add Dialog');
					}
					break;
				default:
                        		$this->displayAttitudesAndValues();
			}
			break;
		case 'addattitudeandvalue':
			switch($task)
			{
				case 'add':
					$this->addAttitudeAndValue();
					break;
				case 'edit':
					$this->editAttitudeAndValue();
					break;
				case 'save':
					$this->saveAttitudeAndValue();
					break;
				default:
					echo "Wrong Task..[addlsactivity]";
			}
			break;
	}

     }

    function displayAttitudesAndValues()
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
//	$viewName=JRequest::getVar('view','attitudesandvalues');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('attitudesandvalues');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->displayAttitudesAndValues();
    }

 
    function addAttitudeAndValue()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('attitudesandvalues');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editAttitudeAndValue()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=attitudesandvalues&controller=attitudesandvalues&task=display',false);
			$this->setRedirect($redirectTo,'Please select a record...');
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('attitudesandvalues');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($ids[0]);
	}

                //For insert and update
	function saveAttitudeAndValue()
	{
		$lsactivity = JRequest::get('POST');
		//$s = preg_match("/[a-zA-Z]+/",$lsactivity['lsactivity']);
		//if($s==1){
		//	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addlsactivity&controller=attitudesandvalues&task=add'.'&lsactivity='.$lsactivity['lsactivity'].'&status='.$lsactivity['status']);
		//	JError::raiseWarning(500,'Wrong lsactivity..');
		//	$this->setRedirect($redirectTo,'Retry...');
		//	return;
		//}

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=attitudesandvalues&controller=attitudesandvalues&task=display&Itemid='.$lsactivity['Itemid'],false);
		$model = & $this->getModel('attitudesandvalues');
		if($lsactivity['id']){
			$status = $model->updateAttitudeAndValue($lsactivity['id'],$lsactivity['activityname'],$lsactivity['activitycode'],$lsactivity['description']);
		}else{
			$status = $model->addAttitudeAndValue($lsactivity['activityname'],$lsactivity['activitycode'],$lsactivity['description']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'Attitudes And Values Activity Saved...');
		}
	}


	function removeAttitudeAndValue($ids=null,$Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=attitudesandvalues&controller=attitudesandvalues&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('attitudesandvalues');
		$status=$model->deleteAttitudeAndValue($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=attitudesandvalues&controller=attitudesandvalues&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}
}

