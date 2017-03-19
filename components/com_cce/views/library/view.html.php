<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewLibrary extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
        $this->assignRef( 'model', $model);

        $app =& JFactory::getApplication();
 //       $pathway =& $app->getPathway();
   //     $pathway->addItem('Manage', 'index.php?option=com_cce&view=cce');
     //   $pathway->addItem('Attendance');

 
        parent::display($tpl);
    }
}

