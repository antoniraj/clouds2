<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
 */
 
class CceViewAddGradeBookEntry extends JView
{

	function display($subjectid,$courseid,$termid)
	{
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$this->assignRef(subjectid,$subjectid);
		$this->assignRef(courseid,$courseid);
		$this->assignRef(termid,$termid);
		parent::display();
	}

	function displayEdit($subjectid,$courseid,$termid,$id)
	{
		$model = $this->getModel();
		$status = $model->getGradeBookEntry($id,$rec);
		$this->assignRef(rec,$rec);
		$this->assignRef(subjectid,$subjectid);
		$this->assignRef(courseid,$courseid);
		$this->assignRef(termid,$termid);
		parent::display();
	}
}
