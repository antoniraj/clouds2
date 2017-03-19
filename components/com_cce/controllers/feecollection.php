<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerFeecollection extends JController
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
	switch($view){
		case 'feecollection':
		switch($layout){
			   case 'default':
			switch($task){
				case 'display':
					$this->displaydetails();
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeVdetails($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&layout=addvehicle&task=edit&view=vehicledetails'.'&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&layout=addvehicle&task=add&view=vehicledetails'.'&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
                                	
											}
		   							if($form['limit']){
		   										echo 'hello';
		   										return;
		   									 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$ciid.'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart').'&limit='.JRequest::getVar('limit'),false);
                                                $this->setRedirect($redirectTo,'');
		   								}
											
					break;
					case 'showlimit':
		   					 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=feecollection&controller=feecollection&task=display&layout=default&courseid='.$ciid.'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart').'&limit='.JRequest::getVar('limit'),false);
                         $this->setRedirect($redirectTo,'');
					break;
					case 'managelimit':
		   					 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&task=display&layout=managestudentstaff&courseid='.$ciid.'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart').'&limit='.JRequest::getVar('limit'),false);
                         $this->setRedirect($redirectTo,'');
					break;
				default:
					$this->displaydetails();
			}
			break;
			 case 'enterfee';
			   			switch($task)
						{
							case 'enter':
								$date = JRequest::getVar('date');
								if($date)
								{
									$this->viewdetails();
								}
								else{
										$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=feecollection&layout=default&task=display&view=feecollection&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
										  JError::raiseWarning(500,'Please select a date..');                             
                              $this->setRedirect($redirectTo,'');
								}
								break;
							case 'edit':
								$this->editVdetails();
								break;
							case 'save':
								$this->savefeedetails();
								break;
							default:
								echo "ERROR";
						}
						break;
		   case 'printview';
			   			switch($task)
						{
							case 'print':
							    $insertedid = JRequest::getVar('insertedid');
								$this->printview($insertedid);
								break;
							case 'save':
								$this->savefeedetails();
								break;
							default:
								echo "ERROR";
						}
						break;
			 case 'takeprint';
			   			switch($task)
						{
							case 'print':
							$insertedid = JRequest::getVar('storedid');
								$this->printview($insertedid);
								break;
							case 'save':
								$this->savefeedetails();
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

    function displaydetails()
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
	$view->setLayout($viewLayout);
	$view->display();
    }
    
    function viewdetails()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'enterfee');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
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

      
     function printview($insertedid)
        {  
                //Read cid as an array
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
                $view->displayPrint($insertedid);
        }

       
          //For insert and update
        function savefeedetails()
        {
                $r = JRequest::get('POST');
                $stored = JRequest::getVar('stored');
   				$date = JRequest::getVar('date');

                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=feecollection&controller=feecollection&layout=default&task=display&Itemid='.$term['Itemid'],false);	
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
                					
                					$total=$r['amount']+$r['fine'];
                        		$insertedid = $model->addfeedetails($stored,$r['amount'],$r['fine'],$total,JArrayHelper::mysqlformat($date));
					
                }
                if($insertedid==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                		$printview = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=feecollection&controller=feecollection&layout=printview&task=print&insertedid='.$insertedid.'&Itemid='.$term['Itemid'],false);	
					
                       $this->setRedirect($printview,'Amount Paid');
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

