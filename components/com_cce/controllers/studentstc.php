<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerStudentstc extends JController
{

    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$view = JRequest::getVar('view');
        $task=JRequest::getVar('task');
		 $layout=JRequest::getVar('layout');
		$courseid=JRequest::getVar('courseid');
	switch($view){
		case 'studentstc':
		switch($layout){
			   case 'default':
			switch($task){
				case 'display':
					$this->displayStudents($courseid);
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        			$form = JRequest::get('POST');
		        				   $print = JRequest::get('print');
						           $this->displayStudents($form['courses']);
						 	 
					 		   if($form[go]) {
							   if($form['courses']=="se") {					    	
								$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentstc&controller=studentstc&layout=default&task=display&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart'),false);
                                                $this->setRedirect($redirectTo,'Please select any course');
												    	
					 								   	}
											 }
					break;
				default:
					$this->displaydetails();
			}
			break;
			 case 'entertc';
			   			switch($task)
						{
							case 'display':
							     $sid=JRequest::getVar('sid');
								$this->printview($sid);
								break;
							case 'edit':
								$this->editVdetails();
								break;
							case 'save':
								$this->saveVdetails();
								break;
							default:
								echo "ERROR";
						}
						break;
			default:
			   echo "ERROR";
			   			
			}
			break;
		default:
			echo "ERROR";
	}

     }

    function printview($sid=null)
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'entertc');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->printview($sid);
    }
	   function displayStudents($courseid=null)
    {
    // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
//	$viewName=JRequest::getVar('view','students');
//	$layoutName=JRequest::getVar('layout','default');
//	$view = & $this->getView($viewName);
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display($courseid);
    }
 
    function addVdetails()
    {
	
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'addvehicle');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        if($model==true){
              //Push the model into the view
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

        function editVdetails()
        {  
                //Read cid as an array
                $ids = JRequest::getVar('cid',null,'default','array');
                if(!$ids[0]){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=vehicledetails&controller=vehicledetails&layout=default&task=display',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
						return;
                }
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'addvehicle');
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
        function saveVdetails()
        {
                $r = JRequest::get('POST');
				$id=$r['id'];
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=vehicledetails&controller=vehicledetails&layout=default&task=display&Itemid='.$term['Itemid'],false);	
                $model = & $this->getModel('cce');
				if($r['route']=="select"){
						$redirect = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=vehicledetails&controller=vehicledetails&layout=default&task=edit&cid='.$id.'&Itemid='.$term['Itemid'],false);	
						 JError::raiseWarning(500,'Please select any main route..');
                        $this->setRedirect($redirect,'Retry...');
				}
				else{
                if($r['id']){
                        $status = $model->updateVdetails($r['id'],$r['vno'],$r['vcode'],$r['noofseats'],$r['max_seats'],$r['vtype'],$r['address'],$r['city'],$r['state'],$r['phone'],$r['Insurance'],$r['tax'],$r['permit'],$r['status'],$r['color']);
                }else{
                        		$status = $model->addVdetails($r['vno'],$r['vcode'],$r['noofseats'],$r['max_seats'],$r['vtype'],$r['address'],$r['city'],$r['state'],$r['phone'],$r['Insurance'],$r['tax'],$r['permit'],$r['status'],$r['color']);
					
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Rcord has been Saved...');
                }
				}
        }

        function removeVdetails($ids=null,$Itemid)
        {
                //Read cid as an array
                //$ids = JRequest::getVar('cid',null,'default','array');
                if($ids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=vehicledetails&controller=vehicledetails&layout=default&task=display&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('cce');
                $status=$model->deleteVdetails($ids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=vehicledetails&controller=vehicledetails&layout=default&task=display&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }

}

