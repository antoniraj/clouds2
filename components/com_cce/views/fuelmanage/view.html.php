<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
jimport('joomla.html.pagination');
 
 
class CceViewFuelmanage extends JView
{
     function display($tpl = null)
    {
	$model = &$this->getModel();
	
	$routes = $model->getfuels($rec);
    $this->assignRef( 'list', $rec);
	$routes = $model->getvehicledetails($vehicles);
    $this->assignRef( 'vehicles', $vehicles);
			
		
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
		$status = $model->fuelEdit($id,$recs);
		$this->assignRef(rec,$recs);
		$routes = $model->getvehicledetails($vehicles);
    	$this->assignRef( 'vehicles', $vehicles);
		$app =& JFactory::getApplication();
	 parent::display();
	}
	
	
}

