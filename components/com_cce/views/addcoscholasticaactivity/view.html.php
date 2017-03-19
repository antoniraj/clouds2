<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddCoScholasticAActivity extends JView
{

	function display()
	{
		$rec->activityname=JRequest::getVar('activityname');
		$rec->activitycode=JRequest::getVar('activitycode');
		$rec->description=JRequest::getVar('description');
		$Itemid=JRequest::getVar('Itemid');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Co-Scholastic-A Activities','index.php?option=com_cce&controller=coscholasticaactivities&view=coscholasticaactivities&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getCoScholasticAActivity($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Co-Scholastic-A Activities','index.php?option=com_cce&controller=coscholasticaactivities&view=coscholasticaactivities&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
