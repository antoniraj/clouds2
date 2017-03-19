<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 


jimport('joomla.application.component.controller');


require_once('helper.php'); 

class CCEControllerManageSubjects extends JController
{
    function display()
    {
	if(! Helper::checkuser()){ 
		$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        	$this->setRedirect($redirectTo,'Please Login First');
	}

        $task = JRequest::getVar('task');
	switch($task)
	{
         	case 'display':
                	$this->displaySubjects();
                        break;
		case 'action':
			$form = JRequest::get('POST');
			$ids = JRequest::getVar('cid',null,'default','array');
			$validate = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=managesubjects&controller=managesubjects&task=display',false);
	
			if(count($form['cid']) == 0 AND !$form['Add']){
				JError::raiseWarning(500,'Please select a record');
				$this->setRedirect($validate,'');
			}
			else if((count($form['cid']) > 1) AND (!$form['Delete']) AND !$form['Add']){
					JError::raiseWarning(500,'Please select any one of the record');
					$this->setRedirect($validate,'');
			}
			else{
			if($form['Delete']) $this->removeSubject($ids,$form['Itemid']);
			if($form['Edit']){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=managesubjects&controller=managesubjects&layout=addeditsubject&task=edit&sid='.$ids[0].'&Itemid='.$form['Itemid'],false);
				$this->setRedirect($redirectTo,'');
			}
			if($form['Add']){
				$redirectTo = JRoute::_('index.php?option=com_cce&view=managesubjects&controller=managesubjects&layout=addeditsubject&task=add&Itemid='.$form['Itemid'],false);
				$this->setRedirect($redirectTo,'');
				
			}
		}
			break;
		default:
			$this->displaySubjects();
	}
    }	
    
    function add() {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('managesubjects');
        if($model==true){
                $view->setModel($model,true);
        }       
        $view->setLayout($viewLayout);
        $view->addSubject();
    }

    function edit() {
        $sid = JRequest::getVar('sid');

        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('managesubjects');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->editSubject($sid);
    }


    function displaySubjects()
    {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model= & $this->getModel('managesubjects');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }


    function back()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login First');
	}
	$referer = JRequest::getString('referer', JURI::base(), 'post');
	$referer = base64_decode($referer);
	$this->setRedirect($referer); 
    }

          //For insert and update
   function save()
   {
	$subject = JRequest::get('POST');
	
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=managesubjects&controller=managesubjects&task=display&Itemid='.$subject['Itemid'],false);
        $model = & $this->getModel('managesubjects');
        if($subject['id']){
        	$status = $model->updateMSubject($subject['id'],$subject['subjecttitle'],$subject['subjectcode'],$subject['subjecttype'],$subject['acronym'],$subject['credits'],$subject['sessionduration'],$subject['marks'],$subject['passmark']);
        }else{
        	$status = $model->addMSubject($subject['subjecttitle'],$subject['subjectcode'],$subject['subjecttype'],$subject['acronym'],$subject['credits'],$subject['sessionduration'],$subject['marks'],$subject['passmark']);
        }
        if($status==false){
        	JError::raiseWarning(500,'Could not save record');
        	$this->setRedirect($redirectTo,'');
        }else{
                $this->setRedirect($redirectTo,'Record has been Saved');
        }
     }



    function removeSubject($ids=null,$Itemid)
    {
	$model = & $this->getModel('managesubjects');
	$status=$model->deleteMSubjects($ids);
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=managesubjects&controller=managesubjects&&task=display&Itemid='.$Itemid,false);
	if($status==true)
		$this->setRedirect($redirectTo,'Record has been deleted!');
	else
		$this->setRedirect($redirectTo,'Could not delete');
    }
}


