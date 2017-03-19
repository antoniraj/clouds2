<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddTGradeBookEntry extends JView
{

	function display($subjectid)
	{
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$this->assignRef(subjectid,$subjectid);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Grade Book Template','index.php?option=com_cce&controller=tgradebook&view=tgradebook');
        	$pathway->addItem('Edit');
		parent::display();
	}

	function displayEdit($id)
	{
		$model = $this->getModel();
		$status = $model->getTGradeBookEntry($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
		$Itemid= JRequest::getVar('Itemid');
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Grade Book Template','index.php?option=com_cce&controller=tgradebook&view=tgradebook&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
