<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerAllotstudent extends JController
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
		case 'allotstudent':
		switch($layout){
			    case 'managestudentstaff':
					 $this->managedetails();
					break;

			    case 'viewroutes':
					$this->displayroutes();
					break;
			   case 'default':
			switch($task){
				case 'display':
					
					$this->displaydetails();
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removemanagedetails($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=vehicledetails&controller=vehicledetails&layout=addvehicle&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=allotstudent&layout=default&task=display&view=allotstudent&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
								}
					break;
				default:
					$this->displaydetails();
			}
			break;
			 case 'searchstudent';
			   			switch($task)
						{
							case 'display':
								$form = JRequest::get('POST');
								$courseid=$form['courses'];
								if($form['save']){

										$this->saveVdetails();
							   	}
								$this->searchdetails($courseid);
								break;
							case 'edit':
								$this->editVdetails();
								break;
							case 'searchstop':
								 $this->searchStop();
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
	
	
	 function managedetails()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'managestudentstaff');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
	
	
	  function displayroutes()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'viewroutes');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
	
	 function searchdetails($courseid=null)
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'searchstudent');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->search($courseid);
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
					$this->searchdetails($courseid);
					$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&layout=searchstudent&task=display',false);
             		$this->setRedirect($redirectTo,'Please select a student...');
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
		      function searchStop()
        {
                //Read cid as an array
                $form = JRequest::get('POST');
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
                $view->displayStop($form['namekey']);
        }



          //For insert and update
        function saveVdetails()
        {
                $r = JRequest::get('POST');
				$courseid = JRequest::getVar('courseid');
				$vid = JRequest::getVar('vid');
				$stopid = JRequest::getVar('stopid');
				$did = JRequest::getVar('did');
				$type = JRequest::getVar('type');
				$max_seats = JRequest::getVar('a_seats');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&layout=default&task=display',false);
				 $ids = JRequest::getVar('cid',null,'default','array');
				 if($r['type']=='select')
				{			
					$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&layout=default&task=display',false);
       				$this->setRedirect($redirectTo,'Please select a type...');
				}
									
				if(count($ids) > $max_seats)
				{
					   JError::raiseWarning(500,'You are exceeding  more than the seats  available. Available seats <span style="color:#296caa;font-weight:bold; font-size:15px;"> '.$max_seats.'</span>');
					
				}
                if(!$ids[0]){
					   JError::raiseWarning(500,'Please Select a student..');
					   return;
                }

				$id=$r['id'];
                 $model = & $this->getModel('cce');
				foreach($ids as $st_id)
				 {  
					 	$result = $model->checkstudent($st_id);
					    if($result)
							{
								 JError::raiseWarning(500,$result->firstname.' is already alloted to another route..');
							}
						else{
							  date_default_timezone_set('Indian/Christmas');
							  $date = date('Y/m/d h:i:s a');
							  $status = $model->add_trans_student($st_id,$vid,$stopid,$did,$date);
							}
			   }

                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Record has been Saved...');
                }
        }

        function removemanagedetails($ids=null,$Itemid)
        {
                //Read cid as an array;
                //$ids = JRequest::getVar('cid',null,'default','array');
                if($ids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&layout=managestudentstaff&task=display&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('cce');
                $status=$model->deleteallotstudent($ids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&layout=managestudentstaff&task=display&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }

}

