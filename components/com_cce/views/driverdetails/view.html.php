<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
jimport('joomla.html.pagination');
 
 
class CceViewDriverdetails extends JView
{
     function display($tpl = null)
    {
	$model = &$this->getModel();
	$routes = $model->getdriverdetails($rec);
        $this->assignRef( 'list', $rec);
		
		
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
    //    $pathway->addItem('Management', 'index.php?option=com_cce&view=cce');
      //  $pathway->addItem('Student Groups');
        parent::display($tpl);
    }
	function displayEdit($id)
	{
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getdriver($id,$recs);
		$this->assignRef(rec,$recs);
		$app =& JFactory::getApplication();
		parent::display();
	}
	
}

