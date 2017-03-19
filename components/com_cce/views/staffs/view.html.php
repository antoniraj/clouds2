<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewStaffs extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$staffs = $model->getStaffs();
        $this->assignRef( 'staffs', $staffs );
        $this->assignRef( 'model', $model );
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
    //    $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
      //  $pathway->addItem('Staff');
 
        parent::display($tpl);
    }
}

