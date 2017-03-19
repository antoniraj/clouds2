<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddScholasticBGrade extends JView
{

	function display()
	{
		$Itemid  = JRequest::getVar('Itemid'); 
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Scholastic-B Grades','index.php?option=com_cce&controller=scholasticbgrades&view=scholasticbgrades&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid  = JRequest::getVar('Itemid'); 
		$model = $this->getModel();
		$status = $model->getScholasticBGrade($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Scholastic-B Grades','index.php?option=com_cce&controller=scholasticbgrades&view=scholasticbgrades&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
