<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewAddNGradeBookEntry extends JView
{

	function display($subjectid,$courseid)
	{
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$this->assignRef(subjectid,$subjectid);
		$this->assignRef(courseid,$courseid);
		parent::display();
	}

	function displayEdit($subjectid,$courseid,$id)
	{
		$model = $this->getModel();
		$status = $model->getNGradeBookEntry($id,$rec);
		$this->assignRef(rec,$rec);
		$this->assignRef(subjectid,$subjectid);
		$this->assignRef(courseid,$courseid);
		parent::display();
	}
}
