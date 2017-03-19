<?php
 
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewLSActivities extends JView
{
    function displayLSActivities($tpl = null)
    {
	$model = &$this->getModel();
	$activites= $model->getLSActivities();
        $this->assignRef( 'activities', $activites );
        parent::display($tpl);
    }
}

