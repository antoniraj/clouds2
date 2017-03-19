<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewAddCourse extends JView
{

	function display()
	{
		$Itemid = JRequest::getVar('Itemid'); 
		$rec->coursename=JRequest::getVar('coursename');
		$rec->sectionname=JRequest::getVar('sectionname');
		$rec->code=JRequest::getVar('code');
		$rec->courseno=JRequest::getVar('courseno');
		$rec->assessmenttype=JRequest::getVar('assessmenttype');
		$rec->aid=JRequest::getVar('aid');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	//        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Courses','index.php?option=com_cce&controller=courses&view=courses&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid = JRequest::getVar('Itemid'); 
		$model = $this->getModel();
		$status = $model->getCourse($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	        //$pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Courses','index.php?option=com_cce&controller=courses&view=courses&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
