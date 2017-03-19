<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerStudentCategories extends JController
{

    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login First');
	}
	$view = JRequest::getVar('view');
        $task = JRequest::getVar('task');
	switch($view){
		case 'studentcategories':
        		switch($task)
        		{
                		case 'displayStudentCategories':
                        		$this->displayStudentCategories();
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
								$validate = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentcategories&controller=studentcategories&task=display',false);
	
								if(count($form['cid']) == 0 AND !$form['Add']){
										JError::raiseWarning(500,'Please select a record');
										$this->setRedirect($validate,'');
								}
								else if((count($form['cid']) > 1) AND (!$form['Delete']) AND !$form['Add']){
										JError::raiseWarning(500,'Please select any one of the record');
										$this->setRedirect($validate,'');
								}
								else{
                        		if($form['Delete']) $this->removeStudentCategory($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addstudentcategory&controller=studentcategories&task=edit&cid='.$ids[0].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addstudentcategory&controller=studentcategories&task=add&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
								}
							}
					break;
				default:
                        		$this->displayStudentCategories();
			}
			break;
		case 'addstudentcategory':
			switch($task)
			{
				case 'add':
					$this->addStudentCategory();
					break;
				case 'edit':
					$this->editStudentCategory();
					break;
				case 'save':
					$this->saveStudentCategory();
					break;
				default:
					echo "ERROR";
			}
			break;
		default:
			echo "ERROR";
	}

     }

    function displayStudentCategories()
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

 
    function addStudentCategory()
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

	function editStudentCategory()
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
	function saveStudentCategory()
	{
		$studentcategory = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentcategories&controller=studentcategories&task=display&Itemid='.$studentcategory['Itemid'],false);
		$model = & $this->getModel('cce');
		if($studentcategory['id']){
			$status = $model->updateStudentCategory($studentcategory['id'],$studentcategory['categoryname'],$studentcategory['categorycode']);
		}else{
			$status = $model->addStudentCategory($studentcategory['categoryname'],$studentcategory['categorycode']);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'StudentCategory Saved...');
		}
	}


	function removeStudentCategory($ids=null,$Itemid)
	{
		$model = & $this->getModel('cce');
		$status=$model->deleteStudentCategory($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentcategories&controller=studentcategories&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted...!');
		else
			$this->setRedirect($redirectTo,'Could not delete..');
	}

}

