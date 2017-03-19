<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewPromotion extends JView
{
    function display($tpl = null)
    {
//	$app =& JFactory::getApplication();
 //       $pathway =& $app->getPathway(); 
  //      $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
    //    $pathway->addItem('Academic Terms');
 
//$document = JFactory::getDocument();
//$document->setName('mypdf');
        parent::display($tpl);
    }
}

