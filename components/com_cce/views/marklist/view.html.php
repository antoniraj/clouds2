<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewMarkList extends JView
{
    function display($subjectid,$courseid,$termid,$max,$gid,$sacdid,$tpl = null)
    {

	$model = &$this->getModel();
	$subjectmodel = &$this->getModel('managesubjects');
	$subjectmodel->getMSubject($subjectid,$srec);
	$students=$model->getStudents($courseid);
	$Itemid=JRequest::getVar('Itemid');
	$profile=JRequest::getVar('profile');
	$model->getCourse($courseid,$crec);
	$model->getTerm($termid,$trec);
        $this->assignRef( 'model', $model);
        $this->assignRef( 'srec', $srec);
        $this->assignRef( 'trec', $trec);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'max', $max);
        $this->assignRef( 'students', $students);
        $this->assignRef( 'subjectid', $subjectid);
        $this->assignRef( 'termid', $termid);
        $this->assignRef( 'crec', $crec);
        $this->assignRef( 'gid', $gid);
        $this->assignRef( 'sacdid', $sacdid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        //$pathway->addItem('Classes', 'index.php?option=com_cce&controller=courses&task=showCourses&view=showcourses&Itemid='.$Itemid);
        if($profile!=1)$pathway->addItem('Profile', 'index.php?option=com_cce&controller=courses&view=showcourseprofile&courseid='.$courseid.'&Itemid='.$Itemid);
        $pathway->addItem('Scheme', 'index.php?option=com_cce&controller=gradebook&view=gradebook&task=display&termid='.$termid.'&subjectid='.$subjectid.'&courseid='.$courseid.'&Itemid='.$Itemid,'&profile='.$profile);
        $pathway->addItem('Marks'); 

        parent::display($tpl);
    }
	
    function addMarksForm($marksid,$studentid,$rno,$firstname,$atitle,$courseid,$subjectid,$termid,$gid,$max,$sacdid)
    {
	$profile=JRequest::getVar('profile');
	$Itemid=JRequest::getVar('Itemid');
	$model = &$this->getModel();
	$model->getScholasticAMarks($studentid,$sacdid,$mrec);
        $this->assignRef( 'studentid', $studentid);
        $this->assignRef( 'marksid', $marksid);
        $this->assignRef( 'rno', $rno);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'firstname', $firstname);
        $this->assignRef( 'atitle', $atitle);
        $this->assignRef( 'subjectid', $subjectid);
        $this->assignRef( 'termid', $termid);
        $this->assignRef( 'max', $max);
        $this->assignRef( 'gid', $gid);
        $this->assignRef( 'sacdid', $sacdid);
        $this->assignRef( 'mrec', $mrec);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
       // $pathway->addItem('Classes', 'index.php?option=com_cce&controller=courses&task=showCourses&view=showcourses&Itemid='.$Itemid);
       if($profile!=1) $pathway->addItem('Profile', 'index.php?option=com_cce&controller=courses&view=showcourseprofile&courseid='.$courseid.'&Itemid='.$Itemid);
        $pathway->addItem('Scheme', 'index.php?option=com_cce&controller=gradebook&view=gradebook&task=display&termid='.$termid.'&subjectid='.$subjectid.'&courseid='.$courseid.'&Itemid='.$Itemid.'&profile='.$profile);
        $pathway->addItem('Marks', 'index.php?option=com_cce&controller=gradebookmarks&view=marklist&termid='.$termid.'&courseid='.$courseid.'&subjectid='.$subjectid.'&gid='.$gid.'&max='.$max.'&task=entermarks&entryid='.$sacdid.'&Itemid='.$Itemid);
        $pathway->addItem('Add'); 
	parent::display($tpl);
    }

}

