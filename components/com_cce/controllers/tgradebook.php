<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerTGradeBook extends JController
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
		case 'tgradebook':
        		switch($task)
        		{
                		case 'displayTGradeBook':
                        		$this->displayTGradeBook();
     	               			break;
				case 'actions':
                        		$id = JRequest::getVar('cid');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeTGradeBookEntry($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addtgradebookentry&controller=tgradebook&task=edit&cid='.$id.'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Grade Book Entry - Edit Dialog');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addtgradebookentry&controller=tgradebook&task=add&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'Grade Book Entry - Add Dialog');
					}
					break;
//Manage GradeBookDetailEntry
				case 'removeentry':
					$id = JRequest::getVar('entryid');
					$Itemid = JRequest::getVar('Itemid');
					$this->removeTGradeBookDetailEntry($id,$Itemid);
					break;
				default:
                        		$this->displayTGradeBook();
			}
			break;
		case 'addtgradebookentry':
			switch($task)
			{
				case 'add':
					$this->addTGradeBookEntry();
					break;
				case 'edit':
					$this->editTGradeBookEntry();
					break;
				case 'save':
					$this->saveTGradeBookEntry();
					break;
				default:
					echo "Wrong task: addtgradebookentry";
			}
			break;
		case 'addtgradebookdetailentry':
			$Itemid = JRequest::getVar('Itemid');
			switch($task)
			{
				case 'addentry':
					$catid = JRequest::getVar('categoryid');
					$this->addTGradeBookDetailEntry($catid);
					break;
				case 'editentry':
					$id = JRequest::getVar('entryid');
					$this->editTGradeBookDetailEntry($id);
					break;
				case 'save':
					$this->saveTGradeBookDetailEntry();
					break;
				default:
					echo "Wrong task for addtgradebookdetailentry..";

			}
			break;
		default:
			echo "Wrong view: TGrade Book ";
	}

     }

    function displayTGradeBook()
    {

 // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
//	$viewName=JRequest::getVar('view','tgradebook');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('tgradebook');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display();
    }

 
    function addTGradeBookEntry()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('tgradebook');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editTGradeBookEntry()
	{
		//Read cid as an array
		$id = JRequest::getVar('cid');
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('tgradebook');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($id);
	}

                //For insert and update
	function saveTGradeBookEntry()
	{
		$tgradebookentry = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tgradebook&controller=tgradebook&task=display&Itemid='.$tgradebookentry['Itemid'],false);
		$model = & $this->getModel('tgradebook');
		if($tgradebookentry['id']){
			$status = $model->updateTGradeBookEntry($tgradebookentry['id'],$tgradebookentry['title'],$tgradebookentry['code'],$tgradebookentry['weightage'],$tgradebookentry['bestof'],$tgradebookentry['description'],$tgradebookentry['grouptag'],$tgradebookentry['gsno']);
		}else{
			$status = $model->addTGradeBookEntry($tgradebookentry['title'],$tgradebookentry['code'],$tgradebookentry['weightage'],$tgradebookentry['bestof'],$tgradebookentry['description'],$tgradebookentry['grouptag'],$tgradebookentry['gsno']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'Grade Book Entry Saved...');
		}
	}


	function removeTGradeBookEntry($ids=null,$Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tgradebook&controller=tgradebook&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('tgradebook');
		$status=$model->deleteTGradeBookEntry($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tgradebook&controller=tgradebook&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}


//Manage GradeBook Detail Entry
	function addTGradeBookDetailEntry($catid)
    	{
        	$document = JFactory::getDocument();
	        $viewType = $document->getType();
        	$viewName = JRequest::getCmd('view', $this->default_view);
	        $viewLayout = JRequest::getCmd('layout', 'default');
        	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	        $model = $this->getModel('tgradebook');
        	if($model==true){
	              //Push the model into the view
        	        $view->setModel($model,true);
	        }
        	$view->setLayout($viewLayout);
	        $view->display($catid);
    	}


        function editTGradeBookDetailEntry($id)
        {
                if($id==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tgradebook&controller=tgradebook&task=display',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
               	} 
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'default');
                $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
                $model = & $this->getModel('tgradebook');
                if($model==true){
                        //Push the model into the view
                        $view->setModel($model,true);
                }
                $view->setLayout($viewLayout);
                $view->displayEdit($id);
        }


          //For insert and update
        function saveTGradeBookDetailEntry()
        {
                $tgradebookdetailentry = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tgradebook&controller=tgradebook&task=display&Itemid='.$tgradebookdetailentry['Itemid'],false);
                $model = & $this->getModel('tgradebook');
                if($tgradebookdetailentry['id']){
                        $status = $model->updateTGradeBookDetailEntry($tgradebookdetailentry['id'],$tgradebookdetailentry['title'],$tgradebookdetailentry['code'],$tgradebookdetailentry['marks'],JArrayHelper::mysqlformat($tgradebookdetailentry['duedate']),$tgradebookdetailentry['description']);
                }else{
                        $status = $model->addTGradeBookDetailEntry($tgradebookdetailentry['title'],$tgradebookdetailentry['code'],$tgradebookdetailentry['marks'],JArrayHelper::mysqlformat($tgradebookdetailentry['duedate']),$tgradebookdetailentry['description'],$tgradebookdetailentry['catid']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Grade Book Entry Saved...');
                }
        }


        function removeTGradeBookDetailEntry($id=null,$Itemid)
        {
                //Read cid as an array
                //$ids = JRequest::getVar('cid',null,'default','array');
                if($id==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tgradebook&controller=tgradebook&task=display&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('tgradebook');
                $status=$model->deleteTGradeBookDetailEntry($id);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=tgradebook&controller=tgradebook&task=display&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }

}

