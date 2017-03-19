<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerLibrarysettings extends JController
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
		 	$courseid = JRequest::getVar('courseid');
	switch($view){
		case 'librarysettings':
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
					break;
				default:
					$this->displaydetails();
			}
			break;
			 case 'bookcategory';
			   			switch($task)
						{
							case 'view':
								$this->viewcategory();
								break;
							case 'Edit':
							  $id = JRequest::getVar('cid');
								echo $id; return;
								$this->editcategory();
								break;
							case 'save':
								$this->savecategory();
								break;
							case 'delete':
							$id = JRequest::getVar('cid');
								$this->deletecategory($id);
								break;
							default:
								echo "ERROR";
						}
						break;
						
			 case 'studentdetails';
			   			switch($task)
						{
							case 'view':
								$this->viewstudents($courseid);
								break;
						    case 'Go':
						    $form = JRequest::get('POST');

							$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarysettings&controller=librarysettings&layout=studentdetails&task=view&courseid='.$form['courses'].'&Itemid='.$form['Itemid'],false);
                                                $this->setRedirect($redirectTo,'');
									
								break;
							case 'Edit':
							  $id = JRequest::getVar('cid');
								echo $id; return;
								$this->editcategory();
								break;
							case 'save':
								$this->savecategory();
								break;
							case 'delete':
							$id = JRequest::getVar('cid');
								$this->deletecategory($id);
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

    function viewcategory()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'bookcategory');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
 

        function editcategory()
        {  
                //Read cid as an array
                $ids = JRequest::getVar('cid',null,'default','array');
                if(!$ids[0]){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarysettings&controller=librarysettings&layout=bookcategory&task=display',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
						return;
                }
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'bookcategory');
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
        function savecategory()
        {
                $r = JRequest::get('POST');
				$id=$r['id'];
				
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarysettings&controller=librarysettings&layout=bookcategory&task=view&Itemid='.$term['Itemid'],false);	
                $model = & $this->getModel('cce');
                if($r['id']){
                        $status = $model->updatecategory($r['id'],$r['category']);
                }else{

                        $status = $model->addcategory($r['category']);
					
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Rcord has been Saved...');
                }
        }

        function deletecategory($id=null)
        {

                $model = & $this->getModel('cce');
                $status=$model->deletebookcategory($id);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarysettings&controller=librarysettings&layout=bookcategory&task=view&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }

/* student details*/


 function viewstudents($courseid=null)
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'studentdetails');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->studentdetailsview($courseid);
    }
 










}

