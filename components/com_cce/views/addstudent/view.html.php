<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewAddStudent extends JView
{

	function display()
	{
		$Itemid = JRequest::getVar('Itemid');
		$rec->registerno=JRequest::getVar('registerno');
		$rec->ano=JRequest::getVar('ano');
		$rec->adate=JRequest::getVar('adate');
		$rec->firstname=JRequest::getVar('firstname');
		$rec->middlename=JRequest::getVar('middlename');
		$rec->lastname=JRequest::getVar('lastname');
		$rec->dob=JRequest::getVar('dob');
		$rec->gender=JRequest::getVar('gender');
		$rec->bloodgroup=JRequest::getVar('bloodgroup');
		$rec->birthplace=JRequest::getVar('birthplace');
		$rec->mothertongue=JRequest::getVar('mothertongue');
		$rec->nationality=JRequest::getVar('nationality');
		$rec->caste=JRequest::getVar('caste');
		$rec->religion=JRequest::getVar('religion');
		$rec->addressline1=JRequest::getVar('addressline1');
		$rec->addressline2=JRequest::getVar('addressline2');
		$rec->city=JRequest::getVar('city');
		$rec->state=JRequest::getVar('state');
		$rec->country=JRequest::getVar('country');
		$rec->phone=JRequest::getVar('phone');
		$rec->mobile=JRequest::getVar('mobile');
		$rec->email=JRequest::getVar('email');
		$rec->categoryid=JRequest::getVar('categoryid');
		$rec->joinedclassid=JRequest::getVar('courseid');
		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$model = $this->getModel();
		$countries = $model->getCountries();
		$model->getCourse(JRequest::getVar('courseid'),$crec);
		$cats= $model->getStudentCategories();
		$rss= $model->getStudentCategory($rec->categoryid,$catrec);
		$this->assignRef(cats,$cats);
		$this->assignRef(crec,$crec);
		$this->assignRef(rec,$rec);
		$this->assignRef(catrec,$catrec);
		$this->assignRef(countries,$countries);
		$this->assignRef(model,$model);
		//$model->getStudentPhoto($rec->id,$rec->registerno);
		//$app =& JFactory::getApplication();
        	//$pathway =& $app->getPathway(); 
	//       $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	//$pathway->addItem('Students','index.php?option=com_cce&controller=students&view=students&Itemid='.$Itemid);
        	//$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		
		$Itemid = JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getStudent($id,$rec);
		$rec->cid=JRequest::getVar('courseid');
		$countries = $model->getCountries();
		$rss= $model->getStudentCategory($rec->categoryid,$catrec);
		$model->getCourse(JRequest::getVar('courseid'),$crec);
		$this->assignRef(rec,$rec);
		$this->assignRef(catrec,$catrec);
		$this->assignRef(countries,$countries);
		$countryname1 = $model->getCountryName($rec->nationality);
		$countryname2 = $model->getCountryName($rec->country);
		$cats= $model->getStudentCategories();
		$this->assignRef(cats,$cats);
		$this->assignRef(crec,$crec);
		$this->assignRef(countryname1,$countryname1);
		$this->assignRef(countryname2,$countryname2);
		//$app =& JFactory::getApplication();
        //	$pathway =& $app->getPathway(); 
	        //$pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        //	$pathway->addItem('Students','index.php?option=com_cce&controller=students&view=students&Itemid='.$Itemid);
        //	$pathway->addItem('Edit');
		parent::display();
	}
}
