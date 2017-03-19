<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewTGradeBook extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$tgradebook= $model->getTGradeBook();
        $this->assignRef( 'tgradebook', $tgradebook);
        $this->assignRef( 'model', $model);
	$app =& JFactory::getApplication();
 
        parent::display($tpl);
    }
}

