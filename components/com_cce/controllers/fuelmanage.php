<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
class CCEControllerFuelmanage extends JController
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
		case 'fuelmanage':
			
		switch($layout){
			   case 'default':
			
			switch($task){
				case 'display':
					$this->displaydetails();
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                        		if($form['Delete']) $this->removeFdetails($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fuelmanage&layout=addfuel&task=edit&view=fuelmanage&Itemid='.$form['Itemid'].'&cid='.$ids[0],false);
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fuelmanage&layout=addfuel&task=add&view=fuelmanage'.'&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
					}
					break;
				default:
					$this->displaydetails();
			}
			break;
			 case 'addfuel';
			   			switch($task)
						{
							case 'add':
								$this->addFdetails();
								break;
							case 'edit':
								$this->editFdetails();
								break;
							case 'save':
								$this->saveFdetails();
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
 
    function addFdetails()
    {
	
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'addfuel');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        if($model==true){
              //Push the model into the view
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

        function editFdetails()
        {  
                //Read cid as an array
                $ids = JRequest::getVar('cid',null,'default','array');
                if(!$ids[0]){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fuelmanage&controller=fuelmanage&layout=default&task=display',false);
                        $this->setRedirect($redirectTo,'Please select a record...');
						return;
                }
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'addfuel');
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
        function saveFdetails()
        {
                $r = JRequest::get('POST');
				$id=$r['id'];
	
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fuelmanage&controller=fuelmanage&layout=default&task=display&Itemid='.$term['Itemid'],false);	
                $model = & $this->getModel('cce');
				if($r['route']=="select"){
						$redirect = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fuelmanage&controller=fuelmanage&layout=default&task=edit&cid='.$id.'&Itemid='.$term['Itemid'],false);	
						 JError::raiseWarning(500,'Please select any main route..');
                        $this->setRedirect($redirect,'Retry...');
				}
				else{
                if($r['id']){
                        $status = $model->updateFdetails($r['id'],$r['vcode'],$r['litres'],$r['amount'],$r['date']);
                }else{
                        		$status = $model->addFdetails($r['vcode'],$r['litres'],$r['amount'],$r['date']);
					
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Rcord has been Saved...');
                }
				}
        }

        function removeFdetails($ids=null,$Itemid)
        {
                //Read cid as an array
                //$ids = JRequest::getVar('cid',null,'default','array');
                if($ids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fuelmanage&controller=fuelmanage&layout=default&task=display&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('cce');
                $status=$model->deleteFdetails($ids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fuelmanage&controller=fuelmanage&layout=default&task=display&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }

}

