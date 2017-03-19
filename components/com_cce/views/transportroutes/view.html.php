<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
jimport('joomla.html.pagination');
 
 
class CceViewTransportroutes extends JView
{

	function display()
	{
		
		$model = $this->getModel();
		$status = $model->getRoutes($rec);
		$this->assignRef('routes',$rec);
	    $status = $model->getvehicledetails($recs);
		$this->assignRef('vehicles',$recs);
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
		parent::display();
	}

	function displayEdit($id)
	{   
		
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getvehicledetails($vehicle);
		$this->assignRef('vehicles',$vehicle);
		$status = $model->RouteEdit($id,$recs);
		$this->assignRef(rec,$recs);
		$app =& JFactory::getApplication();
		parent::display();
	}
}


