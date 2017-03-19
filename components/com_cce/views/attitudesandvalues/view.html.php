<?php
 
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAttitudesAndValues extends JView
{
    function displayAttitudesAndValues($tpl = null)
    {
	$model = &$this->getModel();
	$activities= $model->getAttitudesAndValues();
        $this->assignRef( 'activities', $activities );
	$app =& JFactory::getApplication();
        parent::display($tpl);
    }
}

