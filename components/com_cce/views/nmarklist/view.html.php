<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewNMarkList extends JView
{
    function display($subjectid,$courseid,$max,$tpl = null)
    {
	$model = &$this->getModel();
	$Itemid = JRequest::getVar('Itemid');
	$profile = JRequest::getVar('profile');
	$subjectmodel= &$this->getModel('managesubjects');
	$subjectmodel->getMSubject($subjectid,$srec);
	$students=$model->getStudents($courseid);
	$layout=JRequest::getVar('layout');
	$model->getCourse($courseid,$crec);
        $this->assignRef( 'model', $model);
        $this->assignRef( 'srec', $srec);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'max', $max);
        $this->assignRef( 'students', $students);
        $this->assignRef( 'subjectid', $subjectid);
        $this->assignRef( 'crec', $crec);
        $this->assignRef( 'code', $crec->code);
        

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
     //   $pathway->addItem('Classes', 'index.php?option=com_cce&controller=classreports&task=display&view=coursereports&Itemid='.$Itemid);
	
        if($layout=='default'){
		if($profile!=1)
        	$pathway->addItem('Profile', 'index.php?option=com_cce&controller=courses&view=showcourseprofilenormal&courseid='.$courseid.'&Itemid='.$Itemid);
	}
	else{
		if($profile!=1)
        	$pathway->addItem('Profile', 'index.php?option=com_cce&controller=classreports&view=rshowcourseprofilenormal&task=showcourseprofilenormal&courseid='.$courseid.'&Itemid='.$Itemid);
	}
        $pathway->addItem('Marks'); 
        parent::display();
    }
	
    function addMarksForm($marksid,$studentid,$rno,$firstname,$atitle,$courseid,$subjectid,$max,$examid)
    {
	$Itemid = JRequest::getVar('Itemid');
	$model = &$this->getModel();
	$model->getNMarks($studentid,$examid,$mrec);
        $this->assignRef( 'studentid', $studentid);
        $this->assignRef( 'marksid', $marksid);
        $this->assignRef( 'rno', $rno);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'firstname', $firstname);
        $this->assignRef( 'atitle', $atitle);
        $this->assignRef( 'subjectid', $subjectid);
        $this->assignRef( 'max', $max);
        $this->assignRef( 'examid', $examid);
        $this->assignRef( 'mrec', $mrec);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
 //       $pathway->addItem('Classes', 'index.php?option=com_cce&controller=courses&task=showCourses&view=showcourses&Itemid='.$Itemid);
        $pathway->addItem('Profile', 'index.php?option=com_cce&controller=courses&view=showcourseprofile&courseid='.$courseid.'&Itemid='.$Itemid);
        $pathway->addItem('Scheme', 'index.php?option=com_cce&controller=gradebook&view=gradebook&task=display&termid='.$termid.'&subjectid='.$subjectid.'&courseid='.$courseid.'&Itemid='.$Itemid);
        $pathway->addItem('Marks', 'index.php?option=com_cce&controller=gradebookmarks&view=marklist&termid='.$termid.'&courseid='.$courseid.'&subjectid='.$subjectid.'&gid='.$gid.'&max='.$max.'&task=entermarks&entryid='.$sacdid.'&Itemid='.$Itemid);
        $pathway->addItem('Add'); 
	parent::display($tpl);
    }

}

