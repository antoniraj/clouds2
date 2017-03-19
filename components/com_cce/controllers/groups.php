<?php
 
// No direct agroupsss
 
defined( '_JEXEC' ) or die( 'Restricted agroupsss' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerGroups extends JController
{
    /**
     */


    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$view = JRequest::getVar('view');
        $task=JRequest::getVar('task');
	switch($view){
		case 'groups':
			switch($task){
				case 'displayGroups':
					$this->displayGroups();
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
           					    $validate = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=groups&controller=groups&task=display&Itemid='.JRequest::getVar('Itemid'),false);
         
								if(count($form['cid']) == 0 AND !$form['Add']){
										JError::raiseWarning(500,'Please select a record');
										$this->setRedirect($validate,'');
								}
								else if((count($form['cid']) > 1) AND (!$form['Delete']) AND !$form['Add']){
										JError::raiseWarning(500,'Please select any one of the record');
										$this->setRedirect($validate,'');
								}
								else{
                        		if($form['Delete']) $this->removeGroup($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addgroup&controller=groups&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=groups&task=add'.'&view=addgroup'.'&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
								}
							}
					break;
				default:
					$this->displayGroups();
			}
			break;
		case 'addgroup':
			switch($task)
			{
				case 'add':
					$this->addGroup();
					break;
				case 'edit':
					$this->editGroup();
					break;
				case 'save':
					$this->saveGroup();
					break;
				default:
					echo "ERROR";
			}
			break;

		default:
			echo "ERROR";
	}

     }

    function displayGroups()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('groups');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
 
    function addGroup()
    {
	
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('groups');
        if($model==true){
              //Push the model into the view
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

        function editGroup()
        {
                //Read cid as an array
                $ids = JRequest::getVar('cid',null,'default','array');
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'default');
                $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
                $model = & $this->getModel('groups');
                if($model==true){
                        //Push the model into the view
                        $view->setModel($model,true);
                }
                $view->setLayout($viewLayout);
                $view->displayEdit($ids[0]);
        }


          //For insert and update
        function saveGroup()
        {
		$Itemid = JRequest::getVar('Itemid');
                $group = JRequest::get('POST');
		if($group['from']=='groupmembers')
	                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=groupmembers&controller=groupmembers&task=display&Itemid='.$Itemid.'&groupid=%s',false);
        	else
		        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=groups&controller=groups&task=display&Itemid='.$Itemid,false);
                $model = & $this->getModel('groups');
                if($group['id']){
                        $status = $model->updateGroup($group['id'],$group['groupname'],$group['groupcode'],$group['purpose'],$group['description']);
                }else{
                        $status = $model->addGroup($group['groupname'],$group['groupcode'],$group['purpose'],$group['description']);
			if($group['from']=='groupmembers')
				$redirectTo=sprintf($redirectTo,$status);
                }

                if($status==false){
                        JError::raiseWarning(500,'Could not save record');
                        $this->setRedirect($redirectTo,'');
                }else{
                        $this->setRedirect($redirectTo,'Academic Group Saved');
                }
        }

        function removeGroup($ids=null,$Itemid)
        {
                $model = & $this->getModel('groups');
                $status=$model->deleteGroup($ids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=groups&controller=groups&task=display&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted!');
                else
                        $this->setRedirect($redirectTo,'Could not delete');
        }

}

