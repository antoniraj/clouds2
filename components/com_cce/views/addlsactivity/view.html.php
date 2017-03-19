<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddLSActivity extends JView
{

	function display()
	{
		$Itemid=JRequest::getVar('Itemid');
		$rec->activityname=JRequest::getVar('activityname');
		$rec->activitycode=JRequest::getVar('activitycode');
		$rec->description=JRequest::getVar('description');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Life Skills','index.php?option=com_cce&controller=lsactivities&view=lsactivities&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getLSActivity($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Life Skills','index.php?option=com_cce&controller=lsactivities&view=lsactivities&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
