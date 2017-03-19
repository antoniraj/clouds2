<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewScholasticBGrades extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$scholasticbgrades= $model->getScholasticBGrades();
        $this->assignRef( 'scholasticbgrades', $scholasticbgrades );
	$app =& JFactory::getApplication();
 
        parent::display($tpl);
    }
}

