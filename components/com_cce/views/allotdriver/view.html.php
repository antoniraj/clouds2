<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
jimport('joomla.html.pagination');
 
 
class CceViewAllotdriver extends JView
{
     function display($tpl = null)
    {
	
	$model = &$this->getModel();
	$routes = $model->getallot_vehicledetails($vehicles);
    $this->assignRef( 'vehicles', $vehicles);
	$model->getalloteddriver($driver);
    $this->assignRef( 'list', $driver);
	$routes = $model->getallot_driverdetails($rec);
        $this->assignRef( 'drivers', $rec);

        parent::display($tpl);
    }
	function displayEdit($id)
	{   
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->vehicleEdit($id,$recs);
		$this->assignRef(rec,$recs);
		$app =& JFactory::getApplication();
	 parent::display();
	}
	
	
}

