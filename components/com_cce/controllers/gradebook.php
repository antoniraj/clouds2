<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerGradeBook extends JController
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
		case 'gradebook':
        		switch($task)
        		{
                		case 'displayGradeBook':
                        		$this->displayGradeBook();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeGradeBookEntry($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addgradebookentry&controller=gradebook&termid='.$form['termid'].'&courseid='.$form['courseid'].'&subjectid='.$form['subjectid'].'&task=edit&cid='.$ids[0].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Grade Book Entry - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addgradebookentry&controller=gradebook&task=add&termid='.$form['termid'].'&courseid='.$form['courseid'].'&subjectid='.$form['subjectid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Grade Book Entry - Add Dialog');
					}
					break;
//Manage GradeBookDetailEntry
				case 'removeentry':
					$id = JRequest::getVar('entryid');
					$this->removeGradeBookDetailEntry($id);
					break;
				default:
                        		$this->displayGradeBook();
			}
			break;
		case 'addgradebookentry':
			switch($task)
			{
				case 'add':
					$this->addGradeBookEntry();
					break;
				case 'edit':
					$this->editGradeBookEntry();
					break;
				case 'save':
					$this->saveGradeBookEntry();
					break;
				default:
					echo "Wrong task: addgradebookentry";
			}
			break;
		case 'addgradebookdetailentry':
			$subjectid = JRequest::getVar('subjectid');
			$courseid= JRequest::getVar('courseid');
			$termid = JRequest::getVar('termid');
			switch($task)
			{
				case 'addentry':
					$catid = JRequest::getVar('categoryid');
					$this->addGradeBookDetailEntry($subjectid,$courseid,$termid,$catid);
					break;
				case 'editentry':
					$id = JRequest::getVar('entryid');
					$this->editGradeBookDetailEntry($subjectid,$courseid,$termid,$id);
					break;
				case 'save':
					$this->saveGradeBookDetailEntry();
					break;
				default:
					echo "Wrong task for addgradebookdetailentry..";

			}
			break;
		default:
			echo "Wrong view: Grade Book ";
	}

    }

    function displayGradeBook()
    {
	$courseid = JRequest::getVar('courseid');
	$subjectid = JRequest::getVar('subjectid');
	$termid= JRequest::getVar('termid');
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('gradebook');
	if($model==true){
		$view->setModel($model,true);
	}
	$subjectmodel=& $this->getModel('managesubjects');
	$view->setModel($subjectmodel);
	$view->setLayout($viewLayout);
	$view->display($courseid,$subjectid,$termid);
    }

 
    function addGradeBookEntry()
    {
	$subjectid = JRequest::getVar('subjectid');
	$courseid = JRequest::getVar('courseid');
	$termid= JRequest::getVar('termid');
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('gradebook');
        if($model==true){
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display($subjectid,$courseid,$termid);
    }

	function editGradeBookEntry()
	{
		$subjectid = JRequest::getVar('subjectid');
		$courseid = JRequest::getVar('courseid');
		$termid= JRequest::getVar('termid');
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=gradebook&controller=gradebook&task=display',false);
			$this->setRedirect($redirectTo,'Please select a record...');
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('gradebook');
                if($model==true){
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($subjectid,$courseid,$termid,$ids[0]);
	}

                //For insert and update
	function saveGradeBookEntry()
	{
		$gradebookentry = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=gradebook&controller=gradebook&task=display&subjectid='.$gradebookentry['subjectid'].'&courseid='.$gradebookentry['courseid'].'&termid='.$gradebookentry['termid'].'&Itemid='.$gradebookentry['Itemid'],false);
		$model = & $this->getModel('gradebook');
		if($gradebookentry['id']){
			$status = $model->updateGradeBookEntry($gradebookentry['id'],$gradebookentry['title'],$gradebookentry['code'],$gradebookentry['weightage'],$gradebookentry['bestof'],$gradebookentry['description'],$gradebookentry['grouptag'],$gradebookentry['gsno']);
		}else{
			$status = $model->addGradeBookEntry($gradebookentry['title'],$gradebookentry['code'],$gradebookentry['weightage'],$gradebookentry['bestof'],$gradebookentry['description'],$gradebookentry['subjectid'],$gradebookentry['courseid'],$gradebookentry['termid'],$gradebookentry['grouptag'],$gradebookentry['gsno']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'Grade Book Entry Saved...');
		}
	}


	function removeGradeBookEntry($ids=null,$Itemid)
	{
		$gradebookentry = JRequest::get('POST');
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=gradebook&controller=gradebook&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('gradebook');
		$status=$model->deleteGradeBookEntry($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=gradebook&controller=gradebook&task=display&subjectid='.$gradebookentry['subjectid'].'&courseid='.$gradebookentry['courseid'].'&termid='.$gradebookentry['termid'].'&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}


//Manage GradeBook Detail Entry
	function addGradeBookDetailEntry($subjectid,$courseid,$termid,$catid)
    	{
        	$document = JFactory::getDocument();
	        $viewType = $document->getType();
        	$viewName = JRequest::getCmd('view', $this->default_view);
	        $viewLayout = JRequest::getCmd('layout', 'default');
        	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	        $model = $this->getModel('gradebook');
        	if($model==true){
	              //Push the model into the view
        	        $view->setModel($model,true);
	        }
        	$view->setLayout($viewLayout);
	        $view->display($subjectid,$courseid,$termid,$catid);
    	}


        function editGradeBookDetailEntry($subjectid,$courseid,$termid,$id)
        {
                if($id==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=gradebook&controller=gradebook&task=display',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
               	} 
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'default');
                $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
                $model = & $this->getModel('gradebook');
                if($model==true){
                        //Push the model into the view
                        $view->setModel($model,true);
                }
                $view->setLayout($viewLayout);
                $view->displayEdit($subjectid,$courseid,$termid,$id);
        }


          //For insert and update
        function saveGradeBookDetailEntry()
        {
                $gradebookdetailentry = JRequest::get('POST');
		//echo $subjectid;return;
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=gradebook&controller=gradebook&task=display&termid='.$gradebookdetailentry['termid'].'&courseid='.$gradebookdetailentry['courseid'].'&subjectid='.$gradebookdetailentry['subjectid'].'&Itemid='.$gradebookdetailentry['Itemid'],false);
                $model = & $this->getModel('gradebook');
                if($gradebookdetailentry['id']){
                        $status = $model->updateGradeBookDetailEntry($gradebookdetailentry['id'],$gradebookdetailentry['title'],$gradebookdetailentry['code'],$gradebookdetailentry['marks'],$gradebookdetailentry['duedate'],$gradebookdetailentry['description']);
                }else{
                        $status = $model->addGradeBookDetailEntry($gradebookdetailentry['title'],$gradebookdetailentry['code'],$gradebookdetailentry['marks'],$gradebookdetailentry['duedate'],$gradebookdetailentry['description'],$gradebookdetailentry['catid']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Grade Book Entry Saved...');
                }
        }


        function removeGradeBookDetailEntry($id=null)
        {
                $subjectid= JRequest::getVar('subjectid');
                $courseid= JRequest::getVar('courseid');
                $termid= JRequest::getVar('termid');
                $Itemid= JRequest::getVar('Itemid');
                //Read cid as an array
                //$ids = JRequest::getVar('cid',null,'default','array');
                if($id==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=gradebook&controller=gradebook&task=display&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('gradebook');
                $status=$model->deleteGradeBookDetailEntry($id);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=gradebook&controller=gradebook&task=display&termid='.$termid.'&courseid='.$courseid.'&subjectid='.$subjectid.'&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }

}

