<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddAcademicYear extends JView
{

	function display()
	{
		$Itemid=JRequest::getVar('Itemid');
		$rec->academicyear=JRequest::getVar('academicyear');
		$rec->status=JRequest::getVar('status');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
			$pathway->addItem('Dashboard','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard');
			$pathway->addItem('Master Settings','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master');
        	$pathway->addItem('Academic Years','index.php?option=com_cce&controller=academicyears&view=academicyears&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getAcademicYear($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Dashboard','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard');
			$pathway->addItem('Master Settings','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master');
        	$pathway->addItem('Academic Years','index.php?option=com_cce&controller=academicyears&view=academicyears&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
