<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewFAGrades extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$fagrades= $model->getFAGrades();
        $this->assignRef( 'fagrades', $fagrades );
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
 
        parent::display($tpl);
    }
}

