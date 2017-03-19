<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddNormalGrade extends JView
{

	function display()
	{
		$Itemid = JRequest::getVar('Itemid');
		$rec->from =JRequest::getVar('from');
		$rec->to =JRequest::getVar('to');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	      //  $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Normal Grades','index.php?option=com_cce&controller=normalgrades&view=normalgrades&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$model = $this->getModel();
		$status = $model->getNormalGrade($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Normal Grades','index.php?option=com_cce&controller=normalgrades&view=normalgrades');
        	$pathway->addItem('Edit');
		parent::display();
	}
}
