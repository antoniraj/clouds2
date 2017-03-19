<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerDepartments extends JController
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
		case 'departments':
        		switch($task)
        		{
                		case 'displayDepartments':
                        		$this->displayDepartments();
     	               			break;
				case 'departmentcourses':
                        		$this->showDepartmentCourses();
					break;
				case 'courselist':
                        		$form = JRequest::get('POST');
					if($form['Add']){
						$this->showCourses();
					}
					if($form['Delete']){
						$this->deleteCourses();
					}
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
           						$validate = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=departments&controller=departments&task=display',false);
								if(count($form['cid']) == 0 AND !$form['Add']){
										JError::raiseWarning(500,'Please select a record');
										$this->setRedirect($validate,'');
								}
								else if((count($form['cid']) > 1) AND (!$form['Delete']) AND !$form['Add']){
										JError::raiseWarning(500,'Please select any one of the record');
										$this->setRedirect($validate,'');
								}
								else{
                        		if($form['Delete']) $this->removeDepartment($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=adddepartment&controller=departments&task=edit&cid='.$ids[0].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=adddepartment&controller=departments&task=add&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
								}
								}
					break;
				default:
                        		$this->displayDepartments();
			}
			break;
		case 'adddepartment':
			switch($task)
			{
				case 'add':
					$this->addDepartment();
					break;
				case 'edit':
					$this->editDepartment();
					break;
				case 'save':
					$this->saveDepartment();
					break;
				default:
					echo "ERROR";
			}
			break;
		default:
			echo "ERROR";
	}

     }

    function displayDepartments()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display();
    }

 
    function addDepartment()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        if($model==true){
              //Push the model into the view
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

	function editDepartment()
	{
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model = & $this->getModel('cce');
		if($model==true){
			//Push the model into the view
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($ids[0]);
	}

                //For insert and update
	function saveDepartment()
	{
		$department = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=departments&controller=departments&task=display&Itemid='.$department['Itemid'],false);
		$model = & $this->getModel('cce');
		if($department['id']){
			$status = $model->updateDepartment($department['id'],$department['departmentname'],$department['departmentcode']);
		}else{
			$status = $model->addDepartment($department['departmentname'],$department['departmentcode']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record');
			$this->setRedirect($redirectTo,'');
		}else{
			$this->setRedirect($redirectTo,'Department Saved');
		}
	}


	function removeDepartment($ids=null,$Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=departments&controller=departments&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'');
			return;
		}
		$model = & $this->getModel('cce');
		$status=$model->deleteDepartment($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=departments&controller=departments&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted!');
		else
			$this->setRedirect($redirectTo,'Could not delete');
	}

	function showCourses(){
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'courselist');
                $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
                $model=& $this->getModel('cce');
                if($model==true){
                        $view->setModel($model,true);
                }
                $view->setLayout($viewLayout);
                $view->courselist();
	}

	function showDepartmentCourses(){
 		$document = JFactory::getDocument();
	        $viewType = $document->getType();
        	$viewName = JRequest::getCmd('view', 'departments');
	        $viewLayout = JRequest::getCmd('layout', 'departmentcourses');
        	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	        $model=& $this->getModel('cce');
        	if($model==true){
                	$view->setModel($model,true);
	        }
        	$view->setLayout($viewLayout);
	        $view->departmentcourses();
	}


	function assigncourses(){
		$form = JRequest::get('POST');
		$Itemid= JRequest::getVar('Itemid');
		$cids = $form['cid'];
	        $model=& $this->getModel('cce');
		foreach($cids as $cid){
			$model->addDepartmentCourse($cid,$form['departmentid']);
		}
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=departments&controller=departments&task=showdepartmentcourses&layout=departmentcourses&departmentid='.$form['departmentid'].'&Itemid='.$Itemid,false);
		$this->setRedirect($redirectTo,'');
	}


        function deleteCourses(){
		$form = JRequest::get('POST');
		$cids = $form['cid'];
		$Itemid= JRequest::getVar('Itemid');
	        $model=& $this->getModel('cce');
		foreach($cids as $cid){
			$model->deleteDepartmentCourse($cid,$form['departmentid']);
		}
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=departments&controller=departments&task=showdepartmentcourses&layout=departmentcourses&departmentid='.$form['departmentid'].'&Itemid='.$Itemid,false);
		$this->setRedirect($redirectTo,'');
        }



}

