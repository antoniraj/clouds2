<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewAddGroup extends JView
{

	function display()
	{
		$rec->groupname=JRequest::getVar('groupname');
		$rec->groupcode=JRequest::getVar('groupcode');
		$rec->purpose=JRequest::getVar('purpose');
		$rec->description=JRequest::getVar('description');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		parent::display();
	}

	function displayEdit($id)
	{
		$model = $this->getModel();
		$status = $model->getGroup($id,$rec);
		$this->assignRef(rec,$rec);
		parent::display();
	}
}
