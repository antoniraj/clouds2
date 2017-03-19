<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewTerms extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$terms = $model->getCurrentTerms();
	$cay = $model->getCurrentAcademicYear();
        $this->assignRef( 'terms', $terms );
        $this->assignRef( 'cay', $cay );
    $app =& JFactory::getApplication();
    $pathway =& $app->getPathway(); 
 			$pathway->addItem('Dashboard','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard');
			$pathway->addItem('Master Settings','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master');

        parent::display($tpl);
    }
}

