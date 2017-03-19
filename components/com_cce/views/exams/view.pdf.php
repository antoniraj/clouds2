<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewExams extends JView
{
    function display($tpl = null)
    {
//	$app =& JFactory::getApplication();
 //       $pathway =& $app->getPathway(); 
  //      $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
    //    $pathway->addItem('Academic Terms');
 $regno = JRequest::getVar('regno');
$document = JFactory::getDocument();
$document->setName('FEE - '.$regno);
        parent::display($tpl);
    }
}

