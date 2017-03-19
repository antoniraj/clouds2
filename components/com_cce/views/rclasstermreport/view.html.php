<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewRClassTermReport extends JView
{
    function display($courseid,$subjectid,$termid,$tpl = null)
    {
	$Itemid = JRequest::getVar('Itemid');
	$model = &$this->getModel();
	$subjectsmodel = &$this->getModel('managesubjects');
	$subjectsmodel->getMSubject($subjectid,$srec);
	$students=$model->getStudents($courseid);
	$model->getTerm($termid,$trec);
	$gradebook= $model->getGradeBook($subjectid,$courseid,$termid);
        $this->assignRef( 'gradebook', $gradebook);
        $this->assignRef( 'model', $model);
        $this->assignRef( 'srec', $srec);
        $this->assignRef( 'students', $students);
        $this->assignRef( 'trec', $trec);
        $this->assignRef( 'subjectid', $subjectid);
        $this->assignRef( 'termid', $termid);
        $this->assignRef( 'courseid', $courseid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
 //       $pathway->addItem('Classes', 'index.php?option=com_cce&controller=classreports&task=display&view=coursereports&Itemid='.$Itemid);
        $pathway->addItem('Profile', 'index.php?option=com_cce&controller=classreports&view=rshowcourseprofile&task=showcourseprofile&courseid='.$courseid.'&Itemid='.$Itemid);
        $pathway->addItem('Term Report'); 

        parent::display($tpl);
    }

    function studentreports($courseid,$studentid,$termid,$reportid,$tpl = null)
    {
	$Itemid = JRequest::getVar('Itemid');
        $model = &$this->getModel();
        $subjectsmodel = &$this->getModel('managesubjects');
        $cosmarks = &$this->getModel('cosmarks');
        $model->getStudent($studentid,$srec);
        $status=$subjectsmodel->getMSubjectsByCourse($courseid,$subjects);
        $model->getTerm($termid,$trec);
        //$gradebook= $model->getGradeBook($subjectid,$termid);
        //$this->assignRef( 'gradebook', $gradebook);
        $this->assignRef( 'model', $model);
        $this->assignRef( 'reportid', $reportid);
        $this->assignRef( 'srec', $srec);
        $this->assignRef( 'subjects', $subjects);
        $this->assignRef( 'trec', $trec);
        $this->assignRef( 'studentid', $studentid);
        $this->assignRef( 'termid', $termid);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'reportid', $reportid);

        $app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
   //     $pathway->addItem('Classes', 'index.php?option=com_cce&controller=classreports&task=display&view=coursereports&Itemid='.$Itemid);
        $pathway->addItem('Profile', 'index.php?option=com_cce&controller=classreports&view=rshowcourseprofile&task=showcourseprofile&courseid='.$courseid.'&Itemid='.$Itemid);
        $pathway->addItem('Student Term Report');

        parent::display($tpl);
    }


}

