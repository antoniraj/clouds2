<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerClassAttendance extends JController
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
	$model=& $this->getModel('classattendance');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }


    function go()
    {
        $this->validateuser();
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('classattendance');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

/*
    function saveabsentees()
    {
        $this->validateuser();
	$data = JRequest::get('post');
	$cdate= JRequest::getVar('cdate');
	$courseid = $data['courseid'];
	$Itemid= $data['Itemid'];
	//$courseid = JRequest::getVar('courseid');
	$Itemid= JRequest::getVar('Itemid');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classattendance&Itemid='.$Itemid.'&view=classattendance&task=go&cdate='.$cdate.'&courseid='.$courseid.'&session='.$data['session'],false);
        $model = & $this->getModel('classattendance');
	$a = explode('-',$cdate);
	$c1date=$a[2]."-".$a[1]."-".$a[0];
	$s=$model->deleteAbsentees($c1date,$courseid,$data['session']);
			$presents=$model->getstudentpresent(JArrayHelper::mysqlformat($cdate),$courseid,$data1);
		if(!$data1)
		{
		$model->studentpresent(JArrayHelper::mysqlformat($cdate),$courseid);
		}
	foreach($data['sids'] as $sid){
		if(! in_array($sid,$data['present']) || count($data['present'])==0)
			$r=$model->addAbsentee($c1date,$sid,$courseid,$data['session']);
	}
        $this->setRedirect($redirectTo,'Absentees saved...');
    }



    function quicksave()
    {
        $this->validateuser();
        $data = JRequest::get('post');
        $courses = $data['courses'];
        $cdate= JRequest::getVar('cdate');
        $Itemid= $data['Itemid'];
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classattendance&Itemid='.$Itemid.'&layout=quickattendance&view=classattendance&task=go&cdate='.$cdate.'&courseid='.$courseid.'&session='.$data['session'],false);
        $model = & $this->getModel('classattendance');
        $a = explode('-',$cdate);
        $c1date=$a[2]."-".$a[1]."-".$a[0];
        
	foreach($courses as $cid=>$sids){
           $s=$model->deleteAbsentees($c1date,$cid,$data['session']);
           $presents=$model->getstudentpresent(JArrayHelper::mysqlformat($cdate),$cid,$data1);
           if(!$data1){
                $model->studentpresent(JArrayHelper::mysqlformat($cdate),$cid);
           }
           foreach($sids as $sid){
                $r=$model->addAbsentee($c1date,$sid,$cid,$data['session']);
           }
	}
        $this->setRedirect($redirectTo,'Absentees saved...');
    }
                                    
*/


    function saveabsentees()
    {
        $this->validateuser();
	$data = JRequest::get('post');
	$cdate= JRequest::getVar('cdate');
	$courseid = $data['courseid'];
	$ses= $data['session'];
	$Itemid= $data['Itemid'];
	//$courseid = JRequest::getVar('courseid');
	$Itemid= JRequest::getVar('Itemid');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classattendance&Itemid='.$Itemid.'&view=classattendance&task=go&cdate='.$cdate.'&courseid='.$courseid.'&session='.$data['session'],false);
        $model = & $this->getModel('classattendance');
	$a = explode('-',$cdate);
	$c1date=$a[2]."-".$a[1]."-".$a[0];
	if($ses=='M'){
		$s=$model->deleteAbsentees($c1date,$courseid,'M');
	//	$s=$model->deleteAbsentees($c1date,$courseid,'E');
		
		//to update the status for the class [taken/not taken]
		$presents=$model->getstudentpresent(JArrayHelper::mysqlformat($cdate),$courseid,$data1);
		if(!$data1)
		{
			$model->studentpresent(JArrayHelper::mysqlformat($cdate),$courseid);
		}
		foreach($data['sids'] as $sid){
			if(! in_array($sid,$data['present']) || count($data['present'])==0){
				$r=$model->addAbsentee($c1date,$sid,$courseid,'M');
				$r=$model->addAbsentee($c1date,$sid,$courseid,'E');
			}
		}
	}else{
		$s=$model->deleteAbsentees($c1date,$courseid,$data['session']);
		
		//to update the status for the class [taken/not taken]
		$presents=$model->getstudentpresent(JArrayHelper::mysqlformat($cdate),$courseid,$data1);
		if(!$data1)
		{
			$model->studentpresent(JArrayHelper::mysqlformat($cdate),$courseid);
		}
		foreach($data['sids'] as $sid){
			if(! in_array($sid,$data['present']) || count($data['present'])==0)
				$r=$model->addAbsentee($c1date,$sid,$courseid,$data['session']);
		}
	}
        $this->setRedirect($redirectTo,'Absentees saved...');
    }



    function quicksave()
    {
        $this->validateuser();
        $data = JRequest::get('post');
        $courses = $data['courses'];
        $cdate= JRequest::getVar('cdate');
        $Itemid= $data['Itemid'];
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classattendance&Itemid='.$Itemid.'&layout=quickattendance&view=classattendance&task=go&cdate='.$cdate.'&courseid='.$courseid.'&session='.$data['session'],false);
        $model = & $this->getModel('classattendance');
        $a = explode('-',$cdate);
        $c1date=$a[2]."-".$a[1]."-".$a[0];
        
	$curcourses=$model->getCurrentCourses();
	$ses= $data['session'];

	foreach($curcourses as $curcourse){
        	   $s=$model->deleteAbsentees($c1date,$curcourse->id,$data['session']);
	}
	if($ses=='M'){
		foreach($courses as $cid=>$sids){
	           $presents=$model->getstudentpresent(JArrayHelper::mysqlformat($cdate),$cid,$data1);
        	   if(!$data1){
                	$model->studentpresent(JArrayHelper::mysqlformat($cdate),$cid);
	           }
        	   foreach($sids as $sid){
                	$r=$model->addAbsentee($c1date,$sid,$cid,'M');
                	$r=$model->addAbsentee($c1date,$sid,$cid,'E');
	           }
		}
	}else{
		foreach($courses as $cid=>$sids){
	           $presents=$model->getstudentpresent(JArrayHelper::mysqlformat($cdate),$cid,$data1);
        	   if(!$data1){
                	$model->studentpresent(JArrayHelper::mysqlformat($cdate),$cid);
	           }
        	   foreach($sids as $sid){
                	$r=$model->addAbsentee($c1date,$sid,$cid,$data['session']);
	           }
		}
	}
        $this->setRedirect($redirectTo,'Absentees saved...');
    }
      


}
