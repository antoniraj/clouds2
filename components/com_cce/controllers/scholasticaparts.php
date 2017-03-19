<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
 */
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
/**
 * Hello World Component Controller
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class CCEControllerScholasticAPGrades extends JController
{
    /**
     * Method to display the view
     *
     * @access    public
     */


    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$view = JRequest::getVar('view');
        $task = JRequest::getVar('task');
	switch($view){
		case 'scholasticapgrades':
        		switch($task)
        		{
                		case 'displayScholasticAPGrades':
                        		$this->displayScholasticAPGrades();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeScholasticAPGrade($ids);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addfagrade&controller=scholasticapgrades&task=edit&cid='.$ids[0]);
                                		$this->setRedirect($redirectTo,'ScholasticAP-Grade - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addfagrade&controller=scholasticapgrades&task=add');
                                		$this->setRedirect($redirectTo,'ScholasticAP-Grade - Add Dialog');
					}
					break;
				default:
                        		$this->displayScholasticAPGrades();
			}
			break;
		case 'addfagrade':
			switch($task)
			{
				case 'add':
					$this->addScholasticAPGrade();
					break;
				case 'edit':
					$this->editScholasticAPGrade();
					break;
				case 'scholasticapve':
					$this->scholasticapveScholasticAPGrade();
					break;
				default:
					echo "ERROR";
			}
			break;
		default:
			echo "ERROR";
	}

     }

    function displayScholasticAPGrades()
    {

 // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
//	$viewName=JRequest::getVar('view','scholasticapgrades');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('scholasticapgrades');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display();
    }

 
    function addScholasticAPGrade()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('scholasticapgrades');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editScholasticAPGrade()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=scholasticapgrades&controller=scholasticapgrades&task=display');
			$this->setRedirect($redirectTo,'Please select a record...');
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('scholasticapgrades');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($ids[0]);
	}

                //For insert and update
	function scholasticapveScholasticAPGrade()
	{
		$fagrade = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=scholasticapgrades&controller=scholasticapgrades&task=display');
		$model = & $this->getModel('scholasticapgrades');
		if($fagrade['id']){
			$status = $model->updateScholasticAPGrade($fagrade['id'],$fagrade['from'],$fagrade['to'],$fagrade['letter'],$fagrade['points'],$fagrade['description']);
		}else{
			$status = $model->addScholasticAPGrade($fagrade['from'],$fagrade['to'],$fagrade['letter'],$fagrade['points'], $fagrade['description']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not scholasticapve record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'ScholasticAP-Grade Saved...');
		}
	}


	function removeScholasticAPGrade($ids=null)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=scholasticapgrades&controller=scholasticapgrades&task=display');
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('scholasticapgrades');
		$status=$model->deleteScholasticAPGrade($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=scholasticapgrades&controller=scholasticapgrades&task=display');
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}

}

