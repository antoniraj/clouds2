<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
 */
 
class CceViewGradeBookMarks extends JView
{
    function display($subjectid,$termid,$tpl = null)
    {
	$model = &$this->getModel();
	$model->getSubject($subjectid,$srec);
	$model->getTerm($termid,$trec);
	$gradebook= $model->getGradeBook($subjectid,$termid);
        $this->assignRef( 'gradebook', $gradebook);
        $this->assignRef( 'model', $model);
        $this->assignRef( 'srec', $srec);
        $this->assignRef( 'trec', $trec);
        $this->assignRef( 'subjectid', $subjectid);
        $this->assignRef( 'termid', $termid);
 
        parent::display($tpl);
    }
}

