<?php
 
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewCirculation extends JView
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
     function searchbykey($key)
    {

	    $model = $this->getModel();
		$status = $model->getbookbykey($key,$recs);
		$this->assignRef(book,$recs);
         parent::display($tpl);
    }
     function searchstudentrno($rollno,$bookid)
    {
	    $model = $this->getModel();
		$status = $model->getbookbyid($bookid,$recs);
		$this->assignRef(book,$recs);
		$st = $model->getStudentbyrollno($rollno,$student);
		$this->assignRef(student,$student);
		$chold = $model->countbookshold($students->id,$count);
		$this->assignRef(bookshold,$count->bookshold);
         parent::display($tpl);
    }
      function searchbooktoreturn($key)
    {

	    $model = $this->getModel();
		$status = $model->getbookstatusbykey($key,$recs);
	    $model->getbookbykey($recs->bookno,$books);
		$this->assignRef(book,$books);
	    $st = $model->getStudentbyrollno($recs->regno,$students);
		$this->assignRef(student,$students);
		$this->assignRef(status,$recs->status);
			
		$chold = $model->countbookshold($students->id,$count);
		$this->assignRef(bookshold,$count->bookshold);
			
			if($recs->status==1)
			{
			$sta = $model->getissueddate($recs->ref_id,$issue);
			$this->assignRef(issue,$issue);
			
			$this->assignRef(borrowid,$issue->id);
			}
			else if($recs->status==2)
			{
				
				$sta = $model->getrenewaldetails($recs->ref_id,$renewed);
				$this->assignRef(renewed,$renewed);
				$this->assignRef(borrowid,$renewed->id);
				$is = $model->getissueddate($renewed->issuedid,$issue);
				$this->assignRef(issue,$issue);
			}
			else{
			}
         parent::display($tpl);
    }
  
    
}

