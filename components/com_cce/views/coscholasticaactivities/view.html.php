<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewCoScholasticAActivities extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$activites= $model->getCoScholasticAActivities();
        $this->assignRef( 'activities', $activites );
	$app =& JFactory::getApplication();
        parent::display($tpl);
    }
}

