<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
jimport('joomla.html.pagination');
 
 
class CceViewFeecollection extends JView
{
     function display($tpl = null)
    {
	$model = &$this->getModel();
	$noofmembers = $model->feecollection($rec);
   $mon = $model->gettransmonths($months);
        $this->assignRef( 'months', $months);
		$app    = JFactory::getApplication();
  $page = new JPagination($total, $limitstart, $limit);
		 $this->assignRef( 'pagination', $page);
		 $this->assignRef( 'list', $rec);

        parent::display($tpl);
    }

	function displayPrint($id)
	{   

		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getpaidfee($id,$recs);
		$this->assignRef(rec,$recs);
		$app =& JFactory::getApplication();
	 parent::display();
	}
	
	
}

