<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddSubject extends JView
{

	function display()
	{
		$rec->subjectname=JRequest::getVar('subjectname');
		$rec->subjectcode=JRequest::getVar('subjectcode');
		$rec->code=JRequest::getVar('hoursperweek');
		$rec->cid=JRequest::getVar('courseid');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	//        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Subjects','index.php?option=com_cce&controller=subjects&view=subjects');
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$model = $this->getModel();
		$status = $model->getSubject($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Subjects','index.php?option=com_cce&controller=subjects&view=subjects');
        	$pathway->addItem('Edit');
		parent::display();
	}

        function displayList($courseid=null)
        {
		$model = $this->getModel();
		$subjects= $model->getMSubjects();
	        $this->assignRef( 'subjects', $subjects);
	        $this->assignRef( 'courseid', $courseid);
		$app =& JFactory::getApplication();
	        $pathway =& $app->getPathway(); 
        	$pathway->addItem('ClassSubjects', 'index.php?option=com_cce&controller=subjects&view=subjects&courseid='.$courseid);
	        $pathway->addItem('Assign'); 
        	parent::display($tpl);
        }
}
