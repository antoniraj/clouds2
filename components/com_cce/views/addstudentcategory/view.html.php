<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddStudentCategory extends JView
{

	function display()
	{
		$Itemid=JRequest::getVar('Itemid');
		$rec->categoryname=JRequest::getVar('categoryname');
		$rec->categorycode=JRequest::getVar('categorycode');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	//        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('StudentCategory','index.php?option=com_cce&controller=studentcategories&view=studentcategories&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getStudentCategory($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	        //$pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('StudentCategory','index.php?option=com_cce&controller=studentcategories&view=studentcategories&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
