<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewTimeTable extends JView
{
    function display($tpl = null)
    {
//	$app =& JFactory::getApplication();
 //       $pathway =& $app->getPathway(); 
  //      $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
    //    $pathway->addItem('Academic Terms');
 
        parent::display($tpl);
    }
}

