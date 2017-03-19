<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewTNGradeBook extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$tngradebook= $model->getTNGradeBook();
        $this->assignRef( 'tngradebook', $tngradebook);
        $this->assignRef( 'model', $model);
	$app =& JFactory::getApplication();
//        $pathway =& $app->getPathway(); 
  //      $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
//	$pathway->addItem('Normal Grade Book Template'); 
 
        parent::display($tpl);
    }




}

