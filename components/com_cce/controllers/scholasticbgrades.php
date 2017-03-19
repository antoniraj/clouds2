<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerScholasticBGrades extends JController
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
		case 'scholasticbgrades':
        		switch($task)
        		{
                		case 'displayScholasticBGrades':
                        		$this->displayScholasticBGrades();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeScholasticBGrade($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addscholasticbgrade&controller=scholasticbgrades&task=edit&cid='.$ids[0].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Scholastic-B-Grade - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addscholasticbgrade&controller=scholasticbgrades&task=add&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Scholastic-B-Grade - Add Dialog');
					}
					break;
				default:
                        		$this->displayScholasticBGrades();
			}
			break;
		case 'addscholasticbgrade':
			switch($task)
			{
				case 'add':
					$this->addScholasticBGrade();
					break;
				case 'edit':
					$this->editScholasticBGrade();
					break;
				case 'save':
					$this->saveScholasticBGrade();
					break;
				default:
					echo "ERROR";
			}
			break;
		default:
			echo "ERROR";
	}

     }

    function displayScholasticBGrades()
    {

 // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
//	$viewName=JRequest::getVar('view','scholasticbgrades');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('scholasticbgrades');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display();
    }

 
    function addScholasticBGrade()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('scholasticbgrades');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editScholasticBGrade()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=scholasticbgrades&controller=scholasticbgrades&task=display',false);
			$this->setRedirect($redirectTo,'Please select a record...');
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('scholasticbgrades');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($ids[0]);
	}

                //For insert and update
	function saveScholasticBGrade()
	{
		$scholasticbgrade = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=scholasticbgrades&controller=scholasticbgrades&task=display&Itemid='.$scholasticbgrade['Itemid'],false);
		$model = & $this->getModel('scholasticbgrades');
		if($scholasticbgrade['id']){
			$status = $model->updateScholasticBGrade($scholasticbgrade['id'],$scholasticbgrade['points'],$scholasticbgrade['title'],$scholasticbgrade['letter'],$scholasticbgrade['description']);
		}else{
			$status = $model->addScholasticBGrade($scholasticbgrade['points'],$scholasticbgrade['title'],$scholasticbgrade['letter'],$scholasticbgrade['description']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'Scholastic-B-Grade Saved...');
		}
	}


	function removeScholasticBGrade($ids=null,$Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=scholasticbgrades&controller=scholasticbgrades&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('scholasticbgrades');
		$status=$model->deleteScholasticBGrade($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=scholasticbgrades&controller=scholasticbgrades&task=display',false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}

}

