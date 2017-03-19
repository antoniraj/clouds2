<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerCoSMarks extends JController
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
	$model=& $this->getModel('cosmarks');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }


    function savelsmarks(){
                $Itemid  =  JRequest::getVar('Itemid');
                $marks = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=cosmarks&view=cosmarks&task=display&layout=lsmarks&courseid='.$marks['courseid'].'&termid='.$marks['termid'].'&activityid='.$marks['aid'].'&Itemid='.$Itemid,false);
					if(!$marks['aid']) {
								    JError::raiseWarning(500,'Please select any life skill');
                        $this->setRedirect($redirectTo,'');
                        return;
						}               
                $model = & $this->getModel('cosmarks');
                $n = count($marks["indicators"]);
                $i=0;
                $urecs='Update-Failed:';
                $irecs='Add-Failed:';
                while($i<$n){
                 if($marks["mid"][$i]){
                        $status=$model->updateLSCoSMarksid($marks["mid"][$i],$marks['marks'][$i],$marks['indicators'][$i]);
                        if($status==false){
                                $urecs=$urecs.$marks["rno"][$i]." ";
                        }
                 }else{
                        $status=$model->addLSCoSMarks($marks['sid'][$i],$marks['aid'],$marks['courseid'],$marks['termid'],$marks['marks'][$i],$marks['indicators'][$i]);
                        if($status==false){
                                $irecs=$irecs.$marks['rno'][$i]." ";
                        }

                 }
                 $i++;
                }
                if(strlen($irecs)>15){
                        JError::raiseWarning(500,$irecs);
                        JError::raiseWarning(500,$urecs);
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Marks Entry Saved...');
                }
    	}


    function saveavmarks(){
                $Itemid  =  JRequest::getVar('Itemid');
                $marks = JRequest::get('POST');

                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=cosmarks&view=cosmarks&task=display&layout=avmarks&courseid='.$marks['courseid'].'&termid='.$marks['termid'].'&activityid='.$marks['aid'].'&Itemid='.$Itemid,false);
                	if(!$marks['aid']) {
								JError::raiseWarning(500,'Please select any life skill');
                        $this->setRedirect($redirectTo,'');
                        return;
						}    
                $model = & $this->getModel('cosmarks');
                $n = count($marks["indicators"]);
                $i=0;
                $urecs='Update-Failed:';
                $irecs='Add-Failed:';
                while($i<$n){
                 if($marks["mid"][$i]){
                        $status=$model->updateAVCoSMarksid($marks["mid"][$i],$marks['marks'][$i],$marks['indicators'][$i]);
                        if($status==false){
                                $urecs=$urecs.$marks["rno"][$i]." ";
                        }
                 }else{
                        $status=$model->addAVCoSMarks($marks['sid'][$i],$marks['aid'],$marks['courseid'],$marks['termid'],$marks['marks'][$i],$marks['indicators'][$i]);
                        if($status==false){
                                $irecs=$irecs.$marks['rno'][$i]." ";
                        }

                 }
                 $i++;
                }
                if(strlen($irecs)>15){
                        JError::raiseWarning(500,$irecs);
                        JError::raiseWarning(500,$urecs);
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Marks Entry Saved...');
                }
    	}


    function savecosamarks(){
                $Itemid  =  JRequest::getVar('Itemid');
                $marks = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=cosmarks&view=cosmarks&task=display&layout=cosamarks&courseid='.$marks['courseid'].'&activityid='.$marks['aid'].'&termid='.$marks['termid'].'&Itemid='.$Itemid,false);
                $model = & $this->getModel('cosmarks');
                $n = count($marks["indicators"]);
                $i=0;
                $urecs='Update-Failed:';
                $irecs='Add-Failed:';
                while($i<$n){
                 if($marks["mid"][$i]){
                        $status=$model->updateCoSAMarksid($marks["mid"][$i],$marks['marks'][$i],$marks['indicators'][$i]);
                        if($status==false){
                                $urecs=$urecs.$marks["rno"][$i]." ";
                        }
                 }else{
                        $status=$model->addCoSAMarks($marks['sid'][$i],$marks['aid'],$marks['courseid'],$marks['termid'],$marks['marks'][$i],$marks['indicators'][$i]);
                        if($status==false){
                                $irecs=$irecs.$marks['rno'][$i]." ";
                        }

                 }
                 $i++;
                }
                if(strlen($irecs)>15){
                        JError::raiseWarning(500,$irecs);
                        JError::raiseWarning(500,$urecs);
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Marks Entry Saved...');
                }
    	}


    function savecosbmarks(){
                $Itemid  =  JRequest::getVar('Itemid');
                $marks = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=cosmarks&view=cosmarks&task=display&layout=cosbmarks&courseid='.$marks['courseid'].'&activityid='.$marks['aid'].'&termid='.$marks['termid'].'&Itemid='.$Itemid,false);
                $model = & $this->getModel('cosmarks');
                $n = count($marks["indicators"]);
                $i=0;
                $urecs='Update-Failed:';
                $irecs='Add-Failed:';
                while($i<$n){
                 if($marks["mid"][$i]){
                        $status=$model->updateCoSBMarksid($marks["mid"][$i],$marks['marks'][$i],$marks['indicators'][$i]);
                        if($status==false){
                                $urecs=$urecs.$marks["rno"][$i]." ";
                        }
                 }else{
                        $status=$model->addCoSBMarks($marks['sid'][$i],$marks['aid'],$marks['courseid'],$marks['termid'],$marks['marks'][$i],$marks['indicators'][$i]);
                        if($status==false){
                                $irecs=$irecs.$marks['rno'][$i]." ";
                        }

                 }
                 $i++;
                }
                if(strlen($irecs)>15){
                        JError::raiseWarning(500,$irecs);
                        JError::raiseWarning(500,$urecs);
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Marks Entry Saved...');
                }
    	}

}
