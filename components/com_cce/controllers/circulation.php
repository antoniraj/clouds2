<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerCirculation extends JController
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
		case 'circulation':
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
					break;
				default:
					$this->viewbooks();
			}
			break;
			 case 'returnbook';
			   			switch($task)
						{
							case 'view':
								$this->viewreturnbook();	
								break;
							case 'save':
								$this->savereturnbook();	
								break;
							case 'Go':	
    						  $form = JRequest::get('POST');
    						  $this->returnbookbykey($form['key']);
								break;
							case 'searchstudent':	
    						  $form = JRequest::get('POST');
    						  $this->viewstudentbykey($form['regno'],$form['bookno']);
								break;
							
							default:
								echo "ERROR";
						}
						break;
			
			   case 'renewbook';
			   			switch($task)
						{
							case 'view':
								$this->viewrenewalbook();	
								break;
							case 'save':
								$form = JRequest::get('POST');
							    $issuedate = strtotime($form['renewaldate']);
								$duedate = strtotime($form['duedate']);
								if($issuedate > $duedate)
								{
										    JError::raiseWarning(500,'Due date should be in future..');
										  $this->viewbooktorenew($form['bookno']);
										  return;			
								}
								else{
								$this->savereneveddetails();
								}	
								break;
							case 'Go':	
    						  $form = JRequest::get('POST');
    						  $this->viewbooktorenew($form['key']);
								break;
							case 'searchstudent':	
    						  $form = JRequest::get('POST');
    						  $this->viewstudentbykey($form['regno'],$form['bookno']);
								break;
							
							default:
								echo "ERROR";
						}
						break;
			 case 'issuestudent':
			 			switch($task)
						{
								case 'view':
								$bookid = JRequest::getVar('bookid');			 						
			 						$this->viewstudentstoissue();
			 					break;
			 					case 'Go':
								 $form = JRequest::get('POST');	
			 						$this->searchstudent($form['rollno']);
			 					break;
			 					default:
			 						echo 'ERROR';
			 			}	
			 		break;
		    case 'issuebook':
			   			switch($task)
						{
							case 'view':
								$this->viewissubook();	
								break;
							case 'save':
								$form = JRequest::get('POST');
							    $issuedate = strtotime($form['issuedate']);
								$duedate = strtotime($form['duedate']);
								if($issuedate > $duedate)
								{
										 JError::raiseWarning(500,'Due date should be in future..');
										 $this->viewstudentbykey($form['regno'],$form['bookno']);
										  return;			
								}
								else{
								$this->saveissueddetails();
								}	
								break;
							case 'Go':	
    						  $form = JRequest::get('POST');
    						  $this->viewbookbykey($form['key']);
								break;
							case 'searchstudent':	
    						  $form = JRequest::get('POST');
    						  $this->viewstudentbykey($form['rollno'],$form['bookid']);
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

 function viewissubook()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'issuebook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
    

 function viewstudentstoissue()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'issuestudent');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }    
    
     function viewbookbykey($key)
    {
	$model=& $this->getModel();
    $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=circulation&view=circulation&layout=issuebook&task=view&Itemid='.$term['Itemid'],false);	
    $bookstatus = $model->getbookbykey($key,$bs);
	$sta = $model->getbookstatusbyid($bs->id,$bst);
    if(!$bs)
	{
		 $this->setRedirect($redirectTo,'No books Found!');
		 return;
	}
	
	
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'issuebook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->searchbykey($key);
    }
  
    
    function viewstudentbykey($rollno,$bookid)
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'issuebook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->searchstudentrno($rollno,$bookid);
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
        function saveissueddetails()
        {
                $r = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=circulation&view=circulation&layout=issuebook&task=view&Itemid='.$term['Itemid'],false);	
                $model = & $this->getModel('cce');
                $sta = $model->getbookbyid($r['bookid'],$bst);
                if($r['id']){
                        $status = $model->updatebook($r);
                }else{
                        $status = $model->issuebook($r);
                        if($status)
                        {
                         $st = $model->insertbookstatus($r['bookid'],$bst->isbn,$bst->bookno,$r['studentid'],$r['regno'],JArrayHelper::mysqlformat($r['issuedate']),JArrayHelper::mysqlformat($r['duedate']),1,$status);
						}
					
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Book has been Issued');
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
                $status=$model->deletebook($ids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=librarymanagebooks&controller=librarymanagebooks&layout=listbook&task=view&Itemid='.$Itemid,false);
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
 

/* Return book*/

function viewreturnbook()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'returnbook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }


 function returnbookbykey($key)
    {
	$model=& $this->getModel(); 
	  $sta = $model->getbookstatusbykey($key,$bstatus);    
	  $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=circulation&view=circulation&layout=returnbook&task=view&Itemid='.$term['Itemid'],false);	
   
	if(!$bstatus){
		 $this->setRedirect($redirectTo,'No Books Found!');
		 return;
	}
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'returnbook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->searchbooktoreturn($key);
    }

  function savereturnbook()
        {
                $r = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=circulation&view=circulation&layout=returnbook&task=view&Itemid='.$term['Itemid'],false);	
                $model = & $this->getModel('cce');
                if($r['id']){
                        $status = $model->updatebook($r);
                }else{
                        $status = $model->returnbook($r);
                        if($status)
                        {
                         $st = $model->deletestatus($r['borrowid']);
						}
					
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Book has been Returned');
                }
        }
/* book Renewal*/
function viewrenewalbook()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'renewbook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel();
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }

 function viewbooktorenew($key)
    {
	$model=& $this->getModel();
    $sta = $model->getbookstatusbykey($key,$bstatus);
    $st = $model->getStudentbyrollno($bstatus->regno,$students);
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=circulation&view=circulation&layout=renewbook&task=view&Itemid='.$term['Itemid'],false);	
   
	if(!$bstatus){
		 $this->setRedirect($redirectTo,'No Books Found!');
		 return;
	}

	if($bstatus->status==2)
    {
		 $this->setRedirect($redirectTo,'This Book is already Renewed by '.$students->firstname.' '.$students->middlename);
		 return;
	}
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'returnbook');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->searchbooktoreturn($key);
    }
  function savereneveddetails()
        {
                $r = JRequest::get('POST');

                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=circulation&view=circulation&layout=renewbook&task=view&Itemid='.$term['Itemid'],false);	
                $model = & $this->getModel('cce');
                
                if($r['id']){
                        $status = $model->updatebook($r);
                }else{
                        $status = $model->renewbook($r);
                        if($status)
                        {
                         $st = $model->updatebookstatus($r,2,$status);
						}
					
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Book has been Renewed');
                }
        }

}

