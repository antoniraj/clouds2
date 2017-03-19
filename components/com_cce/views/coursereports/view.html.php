<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
 */
 
class CceViewCourseReports extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$courses = $model->getCurrentCourses();
	$cay = $model->getCurrentAcademicYear();
        $this->assignRef( 'courses', $courses );
        $this->assignRef( 'cay', $cay );

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Classes'); 
 
        parent::display($tpl);
    }
}

