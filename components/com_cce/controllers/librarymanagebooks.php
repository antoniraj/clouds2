<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerLibrarymanagebooks extends JController
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
		case 'librarymanagebooks':
		switch($layout){
			   case 'listbook':
			switch($task){
				case 'display':
					$this->viewbooks();
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->deletebooks($ids);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&layout=addbook&task=edit&view=librarymanagebooks'.'&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&layout=addbook&task=add&view=librarymanagebooks'.'&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
								}
								if($form['Copy']){
										   if(!$ids[0]){
													//Make sure the cid parameter was in the request
													//JError::raiseError(500,'CID parameter is missing');
													$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarymanagebooks&controller=librarymanagebooks&layout=listbook&task=view',false);
													$this->setRedirect($redirectTo,'Please select a record...');
													return;
											}
											else{
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&layout=copybook&task=copy&insertedid='.$ids[0].'&view=librarymanagebooks'.'&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
										}
									}
					
					break;
				default:
					$this->viewbooks();
			}
			break;
		    case 'searchbook':
			   			switch($task)
						{
							case 'view':
								$this->viewbooks();	
								break;
				
							default:
								echo "ERROR";
						}
						break;
		
			case 'mastersearch':
			   			switch($task)
						{
							case 'view':
								$this->viewallbooks();	
								break;
				
							default:
								echo "ERROR";
						}
						break;
			case 'todaysdue':
			   			switch($task)
						{
							case 'view':
								$this->todaysdue();	
								break;
				
							default:
								echo "ERROR";
						}
						break;
			 case 'movementlog';
			   			switch($task)
						{
							case 'view':
								$this->viewlogs();	
								break;
							default:
								echo "ERROR";
						}
						break;
			case 'copybook':
			   			switch($task)
						{
							case 'copy':
							$insertedid = JRequest::getVar('insertedid');
								$this->copybook($insertedid);	
								break;
							case 'add':
								$this->addbooks();	
								break;
							case 'edit':
							 
								$this->editbooks();	
								break;
							case 'save':

								$this->savebook();
								break;
							default:
								echo "ERROR";
						}
						break;
			 case 'addbook':
			   			switch($task)
						{
							case 'add':
								$this->addbooks();	
								break;
							case 'edit':
							 
								$this->editbooks();	
								break;
							case 'save':
								$this->savebook();
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

    function addbooks()
    {
		
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'addbook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
     function copybook($insertedid)
    {
		
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'copybook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->copybookview($insertedid	);
    }
      function viewlogs()
    {
		
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'movementlog');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
 function viewbooks()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'listbook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
	
	 function todaysdue()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'todaysdue');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
	function viewallbooks()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'mastersearch');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }

        function editbooks()
        {  
                //Read cid as an array
                $ids = JRequest::getVar('cid',null,'default','array');
                if(!$ids[0]){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarymanagebooks&controller=librarymanagebooks&layout=listbook&task=view',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
						return;
                }
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'addbook');
                $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
                $model = & $this->getModel('cce');
                if($model==true){
                        //Push the model into the view
                        $view->setModel($model,true);
                }
                $view->setLayout($viewLayout);
                $view->editbookview($ids[0]);
        }


          //For insert and update
        function savebook()
        {
                $r = JRequest::get('POST');
				$id=$r['id'];

                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&view=librarymanagebooks&layout=listbook&task=display&Itemid='.$term['Itemid'],false);	
                $model = & $this->getModel('cce');
                if($r['id']){
                        $status = $model->updatebook($r);
                }else{
                        $status = $model->addbook($r);
                        if($r['Copy'])
                        {	

							    $copy = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&view=librarymanagebooks&layout=copybook&task=copy&insertedid='.$status.'&Itemid='.$term['Itemid'],false);	
							 	$this->setRedirect($copy,'');
							 	return;
						}
					
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Rcord has been Saved...');
                }
        }

        function deletebooks($ids=null)
        {
				 if(!$ids){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarymanagebooks&controller=librarymanagebooks&layout=listbook&task=view',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
						return;
                }
                $model = & $this->getModel('cce');
               // $model->getbookstatus($bstatus);
                $status=$model->deletebook($ids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarymanagebooks&controller=librarymanagebooks&layout=listbook&task=view&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }
            function deletemovement()
        {
				
				$ids = JRequest::getVar('cid',null,'default','array');
				 if(!$ids){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarymanagebooks&controller=librarymanagebooks&layout=movementlog&task=view',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
						return;
                }
                $model = & $this->getModel('cce');
                $status=$model->deletemovementlog($ids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarymanagebooks&controller=librarymanagebooks&layout=movementlog&task=view&Itemid='.$Itemid,false);
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

