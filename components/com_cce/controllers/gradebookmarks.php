<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerGradeBookMarks extends JController
{
    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$view = JRequest::getVar('view');
        $task = JRequest::getVar('task');
	switch($view){
		case 'marklist':
        		switch($task)
        		{
                		case 'display':
                        		$this->displayMarks();
     	               			break;
				default:
                        		$this->displayMarks();
			}
			break;
		default:
			echo "Wrong view: Marks ";
	}

    }

    function displayMarks()
    {
	$subjectid = JRequest::getVar('subjectid');
	$termid= JRequest::getVar('termid');
	$courseid= JRequest::getVar('courseid');
	$max= JRequest::getVar('max');
	$gid= JRequest::getVar('gid');
	$sacdid= JRequest::getVar('entryid');
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('marks');
	if($model==true){
		$view->setModel($model,true);
	}
	$subjectmodel=& $this->getModel('managesubjects');
	$view->setModel($subjectmodel);
	$view->setLayout($viewLayout);
	$view->display($subjectid,$courseid,$termid,$max,$gid,$sacdid);
    }

 
    function addmarks()
    {
	$courseid = JRequest::getVar('courseid');
	$studentid = JRequest::getVar('studentid');
	$sacdid= JRequest::getVar('sacdid');
	$rno= JRequest::getVar('rno');
	$firstname= JRequest::getVar('firstname');
	$atitle = JRequest::getVar('atitle');
	$termid = JRequest::getVar('termid');
	$subjectid = JRequest::getVar('subjectid');
	$gid= JRequest::getVar('gid');
	$marksid= JRequest::getVar('marksid');
	$max= JRequest::getVar('max');
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'addmarks');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('marks');
        if($model==true){
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->addMarksForm($marksid,$studentid,$rno,$firstname,$atitle,$courseid, $subjectid,$termid,$gid,$max,$sacdid);
    }



	function savemarkss()
	{
		$Itemid  =  JRequest::getVar('Itemid');
		$profile=  JRequest::getVar('profile');
		$marks = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebookmarks&view=marklist&task=display&subjectid='.$marks['subjectid'].'&courseid='.$marks['courseid'].'&termid='.$marks['termid'].'&gid='.$marks['gid'].'&entryid='.$marks['sacdid'].'&max='.$marks['max'].'&Itemid='.$Itemid.'&profile='.$profile,false);
		$model = & $this->getModel('marks');
		$n = count($marks["desc"]);
		$i=0;
		$urecs='Update-Failed for:';
		$irecs='Add-Failed for:';
		$vrecs='Invalid Marks for:';

		while($i<$n){
			//Validate Marks
			if($marks['marks'][$i] > $marks['max']) {
				$vrecs = $vrecs.' '.$marks['rno'][$i]."[".$marks['marks'][$i].'/'.$marks['max']."]";
			}else{
				if($marks["mid"][$i]){
					$status=$model->updateScholasticAMarks($marks["mid"][$i],$marks['desc'][$i],$marks['marks'][$i],$marks['comments'][$i]);
					if($status==false){
						$urecs=$urecs.$marks[""][$i]." ";
					}
				}else{
					$status=$model->addScholasticAMarks($marks['desc'][$i],$marks['marks'][$i],$marks['comments'][$i],$marks['sid'][$i],$marks['sacdid']);
					if($status==false){
						$irecs=$irecs.$marks['rno'][$i]." ";
					}
				}
			}	
			$i++;
		}
		if(strlen($irecs)>16)
			JError::raiseWarning(500,$irecs);
		if(strlen($urecs)>19)
			JError::raiseWarning(500,$urecs);
		if(strlen($vrecs)>19)
			JError::raiseWarning(500,$vrecs);
		$this->setRedirect($redirectTo,'Marks Entry Saved...');
	}


        //For insert and update
	function savemarks()
	{
		$marks = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebookmarks&view=marklist&task=display&subjectid='.$marks['subjectid'].'&courseid='.$marks['courseid'].'&termid='.$marks['termid'].'&gid='.$marks['gid'].'&entryid='.$marks['sacdid'].'&max='.$marks['max'],false);
		$model = & $this->getModel('marks');
		if($marks['id']){
			$status=$model->updateScholasticAMarks($marks['id'],$marks['description'],$marks['marks'],$marks['comments']);
		}else{
			$status=$model->addScholasticAMarks($marks['description'],$marks['marks'],$marks['comments'],$marks['studentid'],$marks['sacdid']);

		}
		if($status==false){
			JError::raiseWarning(500,'Could not save record..');
			$this->setRedirect($redirectTo,'Retry...');
		}else{
			$this->setRedirect($redirectTo,'Marks Entry Saved...');
		}
	}
 	
	function back()
    	{
		$referer = JRequest::getString('referer', JURI::base(), 'post');
		$referer = base64_decode($referer);
		$this->setRedirect($referer); 
    	}

}

