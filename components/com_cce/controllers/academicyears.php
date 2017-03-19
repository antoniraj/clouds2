<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');

require_once('helper.php'); 
 

class CCEControllerAcademicYears extends JController
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
		case 'academicyears':
        		switch($task)
        		{
                		case 'displayAcademicYears':
                        		$this->displayAcademicYears();
     	               			break;
				case 'actions':

                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
           						$validate = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=academicyears&controller=academicyears&task=display',false);
				
								if(count($form['cid']) == 0 AND !$form['Add']){
										JError::raiseWarning(500,'Please select a record');
										$this->setRedirect($validate,'');
								}
								else if((count($form['cid']) > 1) AND (!$form['Delete']) AND !$form['Add']){
										JError::raiseWarning(500,'Please select any one of the record');
										$this->setRedirect($validate,'');
								}
								else{
                        		
                        		if($form['SetCurrent']) $this->setCurrentAcademicYear($ids[0]);
                        		if($form['Delete']) $this->removeAcademicYear($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addacademicyear&controller=academicyears&task=edit&cid='.$ids[0].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=add'.'&controller=academicyears&view=addacademicyear&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
									}
								}
					break;
				case 'setcurrent':
                        		$ids = JRequest::getVar('cid',null,'default','array');
					$Itemid = JRequest::getVar('Itemid');
                        		$this->setCurrentAcademicYear($ids[0],$Itemid);
					break;
				default:
                        		$this->displayAcademicYears();
			}
			break;
		case 'addacademicyear':
			switch($task)
			{
				case 'add':
					$this->addAcademicYear();
					break;
				case 'edit':
					$this->editAcademicYear();
					break;
				case 'save':
					$this->saveAcademicYear();
					break;
				default:
					echo "ERROR";
			}
			break;
	}

     }

    function displayAcademicYears()
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
	$view->displayAcademicYears();
    }

 
    function addAcademicYear()
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

	function editAcademicYear($x)
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
	function saveAcademicYear()
	{
		$academicyear = JRequest::get('POST');
		$s = preg_match("/[a-zA-Z]+/",$academicyear['academicyear']);
		if($s==1){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addacademicyear&controller=academicyears&task=add'.'&academicyear='.$academicyear['academicyear'].'&startdate='.$academicyear['startdate'].'&stopdate='.$academicyear['stopdate'].'&feeprefix='.$academicyear['feeprefix'].'&status='.$academicyear['status'].'&Itemid='.$academicyear['Itemid'],false);
			JError::raiseWarning(500,'Wrong academicyear');
			$this->setRedirect($redirectTo,'');
			return;
		}
        $startdate=$academicyear['startdate'];
        $enddate=$academicyear['stopdate'];
        if(strtotime($startdate) > strtotime($enddate)) {
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addacademicyear&controller=academicyears&task=add'.'&academicyear='.$academicyear['academicyear'].'&startdate='.$academicyear['startdate'].'&stopdate='.$academicyear['stopdate'].'&feeprefix='.$academicyear['feeprefix'].'&status='.$academicyear['status'].'&Itemid='.$academicyear['Itemid'],false);
			JError::raiseWarning(500,'Start date should not be greater than End date');
			$this->setRedirect($redirectTo,'');
			return;
			
		}
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=academicyears&controller=academicyears&task=display&Itemid='.$academicyear['Itemid'],false);
		$model = & $this->getModel('cce');
        
		$arrayvalues['academicyear'] = $academicyear['academicyear'];
		$arrayvalues['feeprefix'] = $academicyear['feeprefix'];
		$arrayvalues['startdate'] = JArrayHelper::mysqlformat($academicyear['startdate']);
		$arrayvalues['stopdate'] = JArrayHelper::mysqlformat($academicyear['stopdate']);
	    if($academicyear['status']=='')
		{
			$arrayvalues['status'] ='N';
		}
		else{
			$arrayvalues['status'] = $academicyear['status'];
			$model->setotherAcademicYear($id);
		}
		if($academicyear['id']){
			$arrayvalues['id'] = $academicyear['id'];
			$status = $model->updateAcademicYear($arrayvalues);
		}else{
			$status = $model->addAcademicYear($arrayvalues);
		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record');
			$this->setRedirect($redirectTo,'');
		}else{
			$this->setRedirect($redirectTo,'Academic Year Saved');
		}
	}


	function removeAcademicYear($ids=null,$Itemid)
	{
		if($ids==null){
			//Make sure the cid parameter was in the request
			//JError::raiseError(500,'CID parameter is missing');
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=academicyears&controller=academicyears&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record');
			$this->setRedirect($redirectTo,'');
			return;
		}
		$model = & $this->getModel('cce');
		$status=$model->deleteAcademicYear($ids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=academicyears&controller=academicyears&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Record has been deleted!');
		else
			$this->setRedirect($redirectTo,'Could not delete');
	}

	function setCurrentAcademicYear($id,$Itemid)
	{
		//Read cid as an array
		//$ids = JRequest::getVar('cid',null,'default','array');
		if($id==null){
			//Make sure the cid parameter was in the request
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=academicyears&controller=academicyears&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'Retry...');
			return;
		}
		$model = & $this->getModel('cce');
		$status=$model->setCurrentAcademicYear($id);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=academicyears&controller=academicyears&task=display&Itemid='.$Itemid,false);
		if($status==true)
			$this->setRedirect($redirectTo,'Current Academic Year has been set!');
		else
			$this->setRedirect($redirectTo,'Could not set');
	}



}

