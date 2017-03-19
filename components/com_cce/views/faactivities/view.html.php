<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewFAActivities extends JView
{
    function displayFAActivities($tpl = null)
    {
	$model = &$this->getModel();
	$activites= $model->getFAActivities();
        $this->assignRef( 'activities', $activites );
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        parent::display($tpl);
    }
}

