<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewHallTicket extends JView
{
    function display($tpl = null)
    {
//	$model = &$this->getModel();
//	$tngradebook= $model->getTNGradeBook();
  //      $this->assignRef( 'tngradebook', $tngradebook);
    //    $this->assignRef( 'model', $model);
//	$app =& JFactory::getApplication();
//        $pathway =& $app->getPathway(); 
  //      $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
//	$pathway->addItem('Normal Grade Book Template'); 
   	$model = &$this->getModel();
                $model1 = &$this->getModel('managesubjects');
                $model2 = &$this->getModel('tngradebook');
                $this->assignRef( 'model', $model);
                $this->assignRef( 'model1', $model1);
                $this->assignRef( 'model2', $model2);

 
        parent::display($tpl);
    }




}

