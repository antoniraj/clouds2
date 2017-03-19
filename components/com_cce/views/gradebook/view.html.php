<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewGradeBook extends JView
{
    function display($courseid,$subjectid,$termid,$tpl = null)
    {
	$model = &$this->getModel();
	$subjectmodel = &$this->getModel('managesubjects');
	$subjectmodel->getMSubject($subjectid,$srec);
	$Itemid = JRequest::getVar('Itemid');
	$profile= JRequest::getVar('profile'); //Used for Teachers' portal
	$model->getTerm($termid,$trec);
	$gradebook= $model->getGradeBook($subjectid,$courseid,$termid);

        $this->assignRef( 'gradebook', $gradebook);
        $this->assignRef( 'model', $model);
        $this->assignRef( 'srec', $srec);
        $this->assignRef( 'trec', $trec);
        $this->assignRef( 'subjectid', $subjectid);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'termid', $termid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        //$pathway->addItem('Classes', 'index.php?option=com_cce&controller=courses&task=showCourses&view=showcourses&Itemid='.$Itemid);
        if($profile!=1) $pathway->addItem('Profile', 'index.php?option=com_cce&controller=courses&view=showcourseprofile&courseid='.$courseid.'&Itemid='.$Itemid);
        $pathway->addItem('Scheme'); 

 
        parent::display($tpl);
    }
}

