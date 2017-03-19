<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerGroupMembers extends JController
{

    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login First');
	}
	$view = JRequest::getVar('view');
        $task = JRequest::getVar('task');
	$groupid = JRequest::getVar('groupid');
	$courseid = JRequest::getVar('courseid');
	$Itemid= JRequest::getVar('Itemid');
	switch($view){
		case 'groupmembers':
        		switch($task)
        		{
                		case 'displaymembers':
                        		$this->displayGroupMembers($groupid);
     	               			break;
				case 'actions':
                        		$form = JRequest::get('POST');
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		if($form['go']){
								$this->displayGroupMembers($form['groupid']);
					}else
                        		if($form['Delete']) $this->removeGroupMember($ids,$form['Itemid']);
                        		if($form['Add']){
                                		$redirectTo = JRoute::_(htmlspecialchars('index.php?option=com_cce&view=assignmembers&controller=groupmembers&task=add&groupid='.$form['groupid'].'&Itemid='.$form['Itemid']),false);
                                		$this->setRedirect($redirectTo,'');
					}else{
						// $this->displayGroupMembers($form['groupid']);
                                		$redirectTo = JRoute::_(htmlspecialchars('index.php?option=com_cce&view=groupmembers&controller=groupmembers&groupid='.$form['groupid'].'&Itemid='.$form['Itemid']),false);
                                		$this->setRedirect($redirectTo,'');
					}
					break;
				default:
					//Add New Group ->user selected add new group option from combo box 
					if($groupid=="-1"){
                                		$redirectTo = JRoute::_(htmlspecialchars('index.php?option=com_cce&view=addgroup&controller=groups&groupid='.$groupid.'&task=add&Itemid='.$Itemid.'&from=groupmembers'),false);
                                		$this->setRedirect($redirectTo,'');
					}else{
	                        		$this->displayGroupMembers($groupid);
					}
			}
			break;
		case 'assignmembers':
			switch($task)
			{
				case 'add':
					$this->addGroupMember();
					break;
				case 'save':
					$this->saveGroupMember();
					break;
				case 'actions':
				        $form = JRequest::get('POST');
				        if($form['Assign']){
							
						}
						
				        $ciid=($form['courses'])?$form['courses']:$courseid;
					//	 $this->displayStudents($form['courses']);
                                                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=assignmembers&task=add&controller=groupmembers&groupid='.$groupid.'&courseid='.$ciid.'&Itemid='.$form['Itemid'].'',false);
                                                $this->setRedirect($redirectTo,'');
				break;
				default:
					echo "Wrong Option..";
			}
			break;
		default:
			echo "Wrong Option...";
	}

     }

    function displayGroupMembers($groupid=null)
    {
 // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('groups');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display($groupid);
    }

 
    function addGroupMember()
    {
        $groupid = JRequest::getVar('groupid');
        if(($groupid=='--Select a Group--')||(!$groupid)){
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=groupmembers&controller=groupmembers&groupid='.JRequest::getVar('groupid').'&task=display',false);
                $this->setRedirect($redirectTo,'Please select the group');
                return;
        }
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('groups');
        if($model==true){
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
	$view->display($groupid);
    }

                //For insert and update
	function saveGroupMember() {
		$group = JRequest::get('POST');

                $ids = JRequest::getVar('cid',null,'default','array');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=groupmembers&controller=groupmembers&task=display&groupid='.$group['groupid'].'&Itemid='.$group['Itemid'],false);
		$model = & $this->getModel('groups');
		foreach($ids as $id){
		$status = $model->assignGroupMember($group['groupid'],$id);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record');
			$this->setRedirect($redirectTo,'');
		}else{
			$this->setRedirect($redirectTo,'GroupMembers have been assigned');
		}
	}

	function removeGroupMember($ids=null) {
		
        $form = JRequest::get('POST');
		if($ids==null){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=groupmembers&controller=groupmembers&groupid='.$form['groupid'].'&task=display&Itemid='.$form['Itemid'],false);
			JError::raiseWarning(500,'Please select a record');
			$this->setRedirect($redirectTo,'');
			return;
		}
		$model = & $this->getModel('groups');
		foreach($ids as $id){
			$status=$model->deleteGroupMember($form['groupid'],$id);
		}
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=groupmembers&controller=groupmembers&groupid='.$form['groupid'].'&task=display&Itemid='.$form['Itemid'],false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted!');
		else
			$this->setRedirect($redirectTo,'Could not delete');
	}

}

