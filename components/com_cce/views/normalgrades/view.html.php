<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewNormalGrades extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$normalgrades= $model->getNormalGrades();
        $this->assignRef( 'normalgrades', $normalgrades );
	$app =& JFactory::getApplication();
 //       $pathway =& $app->getPathway(); 
   //     $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
//	$pathway->addItem('Normal Grades'); 
 
        parent::display($tpl);
    }
}

