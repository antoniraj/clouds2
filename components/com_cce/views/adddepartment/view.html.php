<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddDepartment extends JView
{

	function display()
	{
		$Itemid=JRequest::getVar('Itemid');
		$rec->departmentname=JRequest::getVar('departmentname');
		$rec->departmentcode=JRequest::getVar('departmentcode');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	//        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Department','index.php?option=com_cce&controller=departments&view=departments&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getDepartment($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	        //$pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Department','index.php?option=com_cce&controller=departments&view=departments&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
