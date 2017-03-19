<?php
 
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAcademicYears extends JView
{
    function displayAcademicYears($tpl = null)
    {
	$model = &$this->getModel();
	$years = $model->getAcademicYears();

        $this->assignRef( 'years', $years );
 
    $app =& JFactory::getApplication();
    $pathway =& $app->getPathway(); 
    $pathway->addItem('Dashboard','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard');
    $pathway->addItem('Master Settings','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master');
 
        parent::display($tpl);
    }
}

