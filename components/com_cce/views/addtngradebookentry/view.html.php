<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddTNGradeBookEntry extends JView
{

	function display($catid)
	{
		$Itemid = JRequest::getVar('Itemid');
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$this->assignRef(catid,$catid);
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid = JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getTNGradeBookEntry($id,$rec);
		$this->assignRef(rec,$rec);
		parent::display();
	}
}
