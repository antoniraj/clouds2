<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddFAActivity extends JView
{

	function display()
	{
		$Itemid = JRequest::getVar('Itemid');
		$rec->activityname=JRequest::getVar('activityname');
		$rec->activitycode=JRequest::getVar('activitycode');
		$rec->description=JRequest::getVar('description');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('FA Activities','index.php?option=com_cce&controller=faactivities&view=faactivities&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$model = $this->getModel();
		$status = $model->getFAActivity($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('FA Activities','index.php?option=com_cce&controller=faactivities&view=faactivities');
        	$pathway->addItem('Edit');
		parent::display();
	}
}
