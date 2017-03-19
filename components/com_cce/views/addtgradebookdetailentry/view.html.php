<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewAddTGradeBookDetailEntry extends JView
{

	function display($catid)
	{
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$this->assignRef(catid,$catid);
		$Itemid=JRequest::getVar('Itemid');
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Grade Book Template','index.php?option=com_cce&controller=tgradebook&view=tgradebook&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$model = $this->getModel();
		$status = $model->getTGradeBookDetailEntry($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
		$Itemid=JRequest::getVar('Itemid');
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Grade Book Template','index.php?option=com_cce&controller=tgradebook&view=tgradebook&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
