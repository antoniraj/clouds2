<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerAllotdriver extends JController
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
		case 'allotdriver':
		switch($layout){
			   case 'default':
			switch($task){
				case 'display':
					$this->displaydetails();
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeDdetails($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=vehicledetails&controller=vehicledetails&layout=addvehicle&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$this->savealloteddetails();
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
								if($form['type']=='select')
								{
										$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&layout=default&task=display',false);
             							$this->setRedirect($redirectTo,'Please select a type...');
								}
								if($form['save']){
								$this->saveVdetails();
							   	}
								$this->searchdetails($courseid);
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


          //For insert and update
        function savealloteddetails()
        {
                $r = JRequest::get('POST');
		        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotdriver&controller=allotdriver&layout=default&task=display',false);
				 $ids = JRequest::getVar('cid',null,'default','array');
                 $model = & $this->getModel('cce');
				   $status = $model->allot_driver($r['did'],$r['vid'], JArrayHelper::mysqlformat($r['date']));
				

                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Rcord has been Saved...');
                }
        }

        function removeDdetails($ids=null,$Itemid)
        {
                //Read cid as an array
                //$ids = JRequest::getVar('cid',null,'default','array');
                if($ids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotdriver&controller=allotdriver&layout=default&task=display&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('cce');
                $status=$model->deleteallotdetails($ids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotdriver&controller=allotdriver&layout=default&task=display&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }

}

