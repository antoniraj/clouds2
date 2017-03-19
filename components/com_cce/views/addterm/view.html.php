<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddTerm extends JView
{

	function display()
	{
		$Itemid=JRequest::getVar('Itemid');
		$rec->term=JRequest::getVar('term');
		$rec->code=JRequest::getVar('code');
		$rec->months=JRequest::getVar('months');
		$rec->aid=JRequest::getVar('aid');
		$this->assignRef(rec,$rec);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	//        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Terms','index.php?option=com_cce&controller=termss&view=terms&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getTerm($id,$rec);
		$this->assignRef(rec,$rec);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	        //$pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Terms','index.php?option=com_cce&controller=termss&view=terms&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
