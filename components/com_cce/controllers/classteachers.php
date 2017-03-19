<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerClassTeachers extends JController
{

    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$view = JRequest::getVar('view');
        $task = JRequest::getVar('task');
	$courseid = JRequest::getVar('courseid');
	switch($view){
		case 'classteachers':
        		switch($task)
        		{
                		case 'displayClassTeachers':
                        		$this->displayClassTeachers($courseid);
     	               			break;
				case 'actions':
                        		$form = JRequest::get('POST');
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		if($form['go']){
						 $this->displayClassTeachers($form['courses']);
					}else
                        		if($form['Delete']) $this->removeClassTeacher($ids,$form['Itemid']);
                        		else if($form['Add']){
                                		$redirectTo = JRoute::_(htmlspecialchars('index.php?option=com_cce&view=assignstaff&controller=classteachers&task=add&courseid='.$form['courses'].'&Itemid='.$form['Itemid']),false);
                                		$this->setRedirect($redirectTo,'ClassTeacher - Add Dialog');
					}else{
						 $this->displayClassTeachers($form['courses']);
					}
					break;
				default:
                        		$this->displayClassTeachers($courseid);
			}
			break;
		case 'assignstaff':
			switch($task)
			{
				case 'add':
					$this->addClassTeacher();
					break;
				case 'save':
					$this->saveClassTeacher();
					break;
				default:
					echo "Wrong Option..";
			}
			break;
		default:
			echo "Wrong Option...";
	}

     }

    function displayClassTeachers($courseid=null)
    {
 // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
//	$viewName=JRequest::getVar('view','classteachers');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display($courseid);
    }

 
    function addClassTeacher()
    {
        $courseid = JRequest::getVar('courseid');
        if(($courseid=='--Select a Course--')||(!$courseid)){
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=classteachers&controller=classteachers&courseid='.JRequest::getVar('courseid').'&task=display',false);
                $this->setRedirect($redirectTo,'Please select the course/class...');
                return;
        }
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        if($model==true){
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
	$view->display($courseid);
    }

                //For insert and update
	function saveClassTeacher() {
		$classteacher = JRequest::get('POST');
                $ids = JRequest::getVar('cid',null,'default','array');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=classteachers&controller=classteachers&task=display&courseid='.$classteacher['courseid'].'&Itemid='.$classteacher['Itemid'],false);
		$model = & $this->getModel('cce');
		$status = $model->addClassTeacher($ids[0],$classteacher['courseid']);
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'ClassTeacher Saved...');
		}
	}

	function removeClassTeacher($ids=null) {
                $form = JRequest::get('POST');
		if($ids==null){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=classteachers&controller=classteachers&courseid='.$form['courseid'].'&task=display&Itemid='.$form['Itemid'],false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('cce');
		$status=$model->deleteClassTeacher($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=classteachers&controller=classteachers&courseid='.$form['courseid'].'&task=display&Itemid='.$form['Itemid'],false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}
 	
	function back()
        {
                $referer = JRequest::getString('referer', JURI::base(), 'post');
                $referer = base64_decode($referer);
                $this->setRedirect($referer);
        }


}

