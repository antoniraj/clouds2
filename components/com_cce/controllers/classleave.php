<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerClassLeave extends JController
{
    function validateuser()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
    }


    function display()
    {
	$this->validateuser();
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('classleave');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }


    function go()
    {
			$data = JRequest::get('post');
		$courseid = $data['courseid'];
		$Itemid= $data['Itemid'];
		$studentid = $data['studentid'];
		  $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classleave&Itemid='.$Itemid.'&view=classleave&task=display&studentid='.$studentid.'&courseid='.$courseid.'&fromdate='.$fromdate.'&todate='.$todate,false);
		if(!$courseid)
		{
			JError::raiseWarning(500,'Kindly Select any Course..');
		   $this->setRedirect($redirectTo,'');
		return;
		}
        $this->validateuser();
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('classleave');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }


    function saveleave()
    {
        $this->validateuser();
	$data = JRequest::get('post');
	$courseid = $data['courseid'];
	$Itemid= $data['Itemid'];
	$studentid = $data['studentid'];
	JArrayHelper::mysqlformat($fromdate = $data['fromdate']);
	JArrayHelper::mysqlformat($todate = $data['todate']);

	$Itemid= JRequest::getVar('Itemid');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classleave&Itemid='.$Itemid.'&view=classleave&task=display&studentid='.$studentid.'&courseid='.$courseid.'&fromdate='.$fromdate.'&todate='.$todate,false);
        $model = & $this->getModel('classleave');
	$r=$model->deleteLeave($fromdate,$todate,$studentid);
	foreach($data['lrec'] as $lrec){
		list($lid,$sid,$courseid,$cdate,$ses) = explode(':',$lrec);
		$r=$model->addLeave($cdate,$sid,$courseid,$ses,$data['reason']);
	}
        $this->setRedirect($redirectTo,'Absentees saved...');
    }



}
