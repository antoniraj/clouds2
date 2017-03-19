<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewTimeTableTerms extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$terms = $model->getCurrentTimeTableTerms();
	$cay = $model->getCurrentAcademicYear();
        $this->assignRef( 'terms', $terms );
        $this->assignRef( 'cay', $cay );
//	$app =& JFactory::getApplication();
 //       $pathway =& $app->getPathway(); 
  //      $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
    //    $pathway->addItem('Academic Terms');
 
        parent::display($tpl);
    }
}

