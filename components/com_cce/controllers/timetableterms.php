<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerTimeTableTerms extends JController
{

    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login First');
	}
	$view = JRequest::getVar('view');
        $task=JRequest::getVar('task');
	switch($view){
		case 'timetableterms':
			switch($task){
				case 'displayTerms':
					$this->displayTerms();
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeTerm($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addtimetableterm&controller=timetableterms&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetableterms&task=add'.'&view=addtimetableterm'.'&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
					}
					break;
				default:
					$this->displayTerms();
			}
			break;
		case 'addtimetableterm':
			switch($task)
			{
				case 'add':
					$this->addTerm();
					break;
				case 'edit':
					$this->editTerm();
					break;
				case 'save':
					$this->saveTerm();
					break;
				default:
					echo "ERROR";
			}
			break;

		default:
			echo "ERROR";
	}

     }

    function displayTerms()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('timetable');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
 
    function addTerm()
    {
	
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('timetable');
        if($model==true){
              //Push the model into the view
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

        function editTerm()
        {
                //Read cid as an array
                $ids = JRequest::getVar('cid',null,'default','array');
                if(!$ids[0]){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetableterms&controller=timetableterms&task=display',false);
                        $this->setRedirect($redirectTo,'Please select a record');
                }
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'default');
                $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
                $model = & $this->getModel('timetable');
                if($model==true){
                        //Push the model into the view
                        $view->setModel($model,true);
                }
                $view->setLayout($viewLayout);
                $view->displayEdit($ids[0]);
        }


          //For insert and update
        function saveTerm()
        {
                $term = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetableterms&controller=timetableterms&task=display&Itemid='.$term['Itemid'],false);
                $model = & $this->getModel('timetable');
             $ac1=date('M', strtotime($term['startdate']));
			$ac2=date('M', strtotime($term['stopdate']));
			$academicterm=$ac1.'-'.$ac2;
                if($term['id']){
                        $status = $model->updateTimeTableTerm($term['id'],$term['term'],$term['code'],$academicterm,JArrayHelper::mysqlformat($term['startdate']),JArrayHelper::mysqlformat($term['stopdate']));
                }else{
                        $status = $model->addTimeTableTerm($term['term'],$term['code'],$academicterm,JArrayHelper::mysqlformat($term['startdate']),JArrayHelper::mysqlformat($term['stopdate']),$term['aid']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record');
                        $this->setRedirect($redirectTo,'');
                }else{
                        $this->setRedirect($redirectTo,'Time Table Term Saved');
                }
        }

        function removeTerm($ids=null,$Itemid)
        {
                //Read cid as an array
                //$ids = JRequest::getVar('cid',null,'default','array');
                if($ids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetableterms&controller=timetableterms&task=display&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record');
                        $this->setRedirect($redirectTo,'');
                        return;
                }
                $model = & $this->getModel('timetable');
                $status=$model->deleteTimeTableTerm($ids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetableterms&controller=timetableterms&task=display&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted!');
                else
                        $this->setRedirect($redirectTo,'Could not delete');
        }

}

