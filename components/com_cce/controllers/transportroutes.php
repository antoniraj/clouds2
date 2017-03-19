<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerTransportroutes extends JController
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
		case 'transportroutes':
		switch($layout){
			   case 'default':
			switch($task){
				case 'display':
					$this->displayRoutes();
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->deletedestination($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=transportroutes&controller=transportroutes&layout=addroute&task=edit&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=transportroutes&layout=addroute&task=add&view=transportroutes&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
					}
					break;
				default:
					$this->displayRoutes();
			}
			break;
			 case 'viewstops':
			   		switch($task)
					{
						case 'viewstop':
						$this->viewroutes();
						break;
						case 'delete':

							$sid = JRequest::getVar('sid');
							$this->deleteStop($sid);
						break;
						default:
						echo 'ERROR';
					}
				break;
			 case 'addroute';
			   			switch($task)
						{
							case 'add':
								$this->addRdetails();
								break;
							case 'edit':
								$this->editRdetails();
								break;
							case 'save':
								$this->saveRdetails();
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

        function viewroutes()
        {
                //Read cid as an array
                $ids = JRequest::getVar('cid',null,'default','array');
                if(!$ids[0]){
					
					 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=transportroutes&controller=transportroutes&layout=default&task=display',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
                }
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'viewstops');
                $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
                $model = & $this->getModel('cce');
                if($model==true){
                        //Push the model into the view
                        $view->setModel($model,true);
                }
                $view->setLayout($viewLayout);
                $view->displayEdit($ids[0]);
        }

    function displayRoutes()
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
	
 
    function addRdetails()
    {
	
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'addroute');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        if($model==true){
              //Push the model into the view
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }
  
        function editRdetails()
        {
                //Read cid as an array
                $ids = JRequest::getVar('cid',null,'default','array');
                if(!$ids[0]){
					
					 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=transportroutes&controller=transportroutes&layout=default&task=display',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
                }
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'addroute');
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
          function saveRdetails()
        {
                 $r= JRequest::get('POST');
				// echo '<pre>';
				//print_r($r);
				//exit();
			
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=transportroutes&controller=transportroutes&layout=default&task=display&Itemid='.$term['Itemid'],false);	
                $model = & $this->getModel('cce');
			
                if($r['id']){
					 $model->updateRoute($r);
					foreach ($r['stopname'] as $index=>$val)
				   {
						$arr['routeId'] = $r['id'];
						$arr['stopname'] = $val;
						$arr['fare'] = $r['fare'][$index];
						$arr['m_arrival'] = $r['m_arrival'][$index];
						$arr['e_arrival'] = $r['e_arrival'][$index];
						if(isset($r['ids'][$index]))
						{
							$arr['destId'] = $r['ids'][$index];
							$status = $model->updateRdetails($arr);
						}
						else
						{
							$status = $model->addRdetails($arr);	
						}
						
						
				  }
                       
                }else{
				  $routeId = $model->addRoute($r);
					
				   foreach ($r['stopname'] as $index=>$val)
				   {
						$arr['routeId'] = $routeId;
						$arr['stopname'] = $val;
						$arr['fare'] = $r['fare'][$index];
						$arr['m_arrival'] = $r['m_arrival'][$index];
						$arr['e_arrival'] = $r['e_arrival'][$index];
						$status = $model->addRdetails($arr);
				  }
					
                }
				
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Rcord has been Saved...');
                }
				
        }

         function deletedestination($ids=null,$Itemid)
        {
                //Read cid as an array;
                //$ids = JRequest::getVar('cid',null,'default','array');
		
                if($ids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                       $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=transportroutes&controller=transportroutes&layout=default&task=display&Itemid='.$Itemid,false);
             		    JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('cce');
				foreach($ids as $id)
				{
					  $status=$model->deletedesandstops($id);
				}
                 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=transportroutes&controller=transportroutes&layout=default&task=display&Itemid='.$Itemid,false);
             	 if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else{
						JError::raiseWarning(500,'First you have to delete stops..');		
                        $this->setRedirect($redirectTo,'Could not delete..');
				}
        }
		
		  function deleteStop($id)
        {                   
		           $cid = JRequest::getVar('cid');       
                $model = & $this->getModel('cce');
			       $status=$model->deletestop($id);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=transportroutes&controller=transportroutes&layout=viewstops&task=viewstop&cid='.$cid.'&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else{
						JError::raiseWarning(500,'Please Make sure that you deleted members alloted in this stop..');		
                        $this->setRedirect($redirectTo,'Could not delete..');
				}
        }
		
		


}

