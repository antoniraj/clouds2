<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewCoScholasticBActivities extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$activites= $model->getCoScholasticBActivities();
        $this->assignRef( 'activities', $activites );
	$app =& JFactory::getApplication();
        parent::display($tpl);
    }
}

