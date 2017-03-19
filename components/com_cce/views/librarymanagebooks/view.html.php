<?php
 
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewLibrarymanagebooks extends JView
{
  
    function display()
    {

       $model1 = & $this->getModel('cce');
	 $st = $model1->getcat($cat);
        $this->assignRef( 'category', $cat );
	 $status = $model1->getbookdetails($books);
        $this->assignRef( 'books', $books );
         parent::display($tpl);
    }
     function editbookview($id)
    {

	    $model = $this->getModel();
		 $status = $model->getcat($cat1);
        $this->assignRef( 'category', $cat1);
		$status = $model->getbookbyid($id,$recs);
		$this->assignRef(rec,$recs);
         parent::display($tpl);
    }
       function copybookview($id)
    {

	    $model = $this->getModel();
		 $status = $model->getcat($cat1);
        $this->assignRef( 'category', $cat1);
		$status = $model->getbookbyid($id,$recs);
		$this->assignRef(rec,$recs);
         parent::display($tpl);
    }

    
  
    
}

