<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerTNGradebook extends JController
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
		case 'tngradebook':
        		switch($task)
        		{
                		case 'displayTNGradebook':
                        		$this->displayTNGradebook();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeTNGradebook($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addtngradebookentry&controller=tngradebook&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addtngradebookentry&controller=tngradebook&task=add&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
					}
					break;
				default:
                        		$this->displayTNGradebook();
			}
			break;
		case 'addtngradebookentry':
			switch($task)
			{
				case 'add':
					$this->addTNGradebook();
					break;
				case 'edit':
					$this->editTNGradebook();
					break;
				case 'save':
					$this->saveTNGradebook();
					break;
				default:
					echo "ERROR-1";
			}
			break;
		default:
			echo "ERROR-2";
	}

     }

    function displayTNGradebook()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('tngradebook');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display();
    }

 
    function addTNGradebook()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('tngradebook');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editTNGradebook()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tngradebook&controller=tngradebook&task=display',false);
			$this->setRedirect($redirectTo,'Please select a record...');
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('tngradebook');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($ids[0]);
	}

                //For insert and update
	function saveTNGradebook()
	{
		$tngradebook = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tngradebook&controller=tngradebook&task=display&Itemid='.$tngradebook['Itemid'],false);
		$model = & $this->getModel('tngradebook');
		if($tngradebook['id']){
			$status = $model->updateTNGradeBookEntry($tngradebook['id'],$tngradebook['title'],$tngradebook['code'],$tngradebook['marks'],JArrayHelper::mysqlformat($tngradebook['duedate']),$tngradebook['description'],$tngradebook['instructions']);
		}else{
			$status = $model->addTNGradeBookEntry($tngradebook['title'],$tngradebook['code'],$tngradebook['marks'],JArrayHelper::mysqlformat($tngradebook['duedate']), $tngradebook['description'],$tngradebook['instructions']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'Exam Saved...');
		}
	}


	function removeTNGradebook($ids=null,$Itemid)
	{
		if($ids==null){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tngradebook&controller=tngradebook&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('tngradebook');
		$status=$model->deleteTNGradeBookEntry($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tngradebook&controller=tngradebook&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}

}

