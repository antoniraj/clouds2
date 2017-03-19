<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerNGradeBookMarks extends JController
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
		case 'nmarklist':
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
	$courseid= JRequest::getVar('courseid');
	$max= JRequest::getVar('max');
	$examid= JRequest::getVar('examid');
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('nmarks');
	$model2=& $this->getModel('tngradebook');
	$model1=& $this->getModel('managesubjects');
	if($model==true){
		$view->setModel($model,true);
		$view->setModel($model1);
		$view->setModel($model2);
	}
	$view->setLayout($viewLayout);
	$view->display($subjectid,$courseid,$max,$examid);
    }

 
    function addnmarks()
    {
	$courseid = JRequest::getVar('courseid');
	$subjectid = JRequest::getVar('subjectid');
	$studentid = JRequest::getVar('studentid');
	$rno= JRequest::getVar('rno');
	$firstname= JRequest::getVar('firstname');
	$atitle = JRequest::getVar('atitle');
	$marksid= JRequest::getVar('marksid');
	$max= JRequest::getVar('max');
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'addnmarks');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('nmarks');
        if($model==true){
        	$view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->addNMarksForm($marksid,$studentid,$rno,$firstname,$atitle,$courseid, $subjectid,$gid,$max,$sacdid);
    }

	function savemarkss() {
		$Itemid  =  JRequest::getVar('Itemid');
		$marks = JRequest::get('POST');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=ngradebookmarks&view=nmarklist&task=display&layout=default&subjectid='.$marks['subjectid'].'&courseid='.$marks['courseid'].'&examid='.$marks['examid'].'&max='.$marks['max'].'&title='.$marks['title'].'&Itemid='.$Itemid,false);
		$model = & $this->getModel('nmarks');
		$n = count($marks["comments"]);
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
					$status=$model->updateNMarks($marks["mid"][$i],$marks['marks'][$i],$marks['comments'][$i]);
					if($status==false){
						$urecs=$urecs.$marks['rno'][$i]." ";
					}
				}else{
					$status=$model->addNMarks($marks['marks'][$i],$marks['comments'][$i],$marks['sid'][$i],$marks['examid'],$marks['subjectid'],$marks['courseid']);
					if($status==false){
						$irecs=$irecs.$marks['rno'][$i]." ";
					}
				}
			}
			$i++;
		}
		if(strlen($irecs)>17)
			JError::raiseWarning(500,$irecs);
		if(strlen($urecs)>19)
			JError::raiseWarning(500,$urecs);
		if(strlen($vrecs)>19)
			JError::raiseWarning(500,$vrecs);
		$this->setRedirect($redirectTo,'Marks Entry Saved...');
	}


	function back()
    	{
		$referer = JRequest::getString('referer', JURI::base(), 'post');
		$referer = base64_decode($referer);
		$this->setRedirect($referer); 
    	}

}

