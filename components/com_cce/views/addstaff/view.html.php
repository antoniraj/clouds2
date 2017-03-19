<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewAddStaff extends JView
{

	function display()
	{
		$Itemid = JRequest::getVar('Itemid');
		$rec->hprefix =JRequest::getVar('hprefix');
		$rec->staffcode=JRequest::getVar('staffcode');
		$rec->firstname=JRequest::getVar('firstname');
		$rec->middlename=JRequest::getVar('middlename');
		$rec->lastname=JRequest::getVar('lastname');
		$rec->doj=JRequest::getVar('doj');
		$rec->department=JRequest::getVar('department');
		$model = $this->getModel();
		$departmentname= $model->getDepartmentName($rec->department);
		$rec->category=JRequest::getVar('category');
		$categoryname= $model->getCategoryName($rec->category);
		$rec->position=JRequest::getVar('position');
		$rec->grade=JRequest::getVar('grade');
		$rec->jobtitle=JRequest::getVar('jobtitle');
		$rec->qualification=JRequest::getVar('qualification');
		$rec->experienceinfo=JRequest::getVar('experienceinfo');
		$rec->totalexperience=JRequest::getVar('totalexperience');
		$rec->status=JRequest::getVar('status');

		$rec->qualification=JRequest::getVar('qualification');
		$rec->maritalstatus=JRequest::getVar('maritalstatus');
		$rec->dob=JRequest::getVar('dob');
		$rec->gender=JRequest::getVar('gender');
		$rec->bloodgroup=JRequest::getVar('bloodgroup');
		$rec->nationality=JRequest::getVar('nationality');
		$rec->fathername=JRequest::getVar('fathername');
		$rec->mothername=JRequest::getVar('mothername');

		$rec->addressline1=JRequest::getVar('addressline1');
		$rec->addressline2=JRequest::getVar('addressline2');
		$rec->city=JRequest::getVar('city');
		$rec->state=JRequest::getVar('state');
		$rec->country=JRequest::getVar('country');
		$rec->phone=JRequest::getVar('phone');
		$rec->mobile=JRequest::getVar('mobile');
		$rec->email=JRequest::getVar('email');


		$model = $this->getModel();
		$departments= $model->getDepartments();
		$categories= $model->getCategories();
		$positions= $model->getPositions();
		$grades= $model->getGrades();
		$countries = $model->getCountries();
		$this->assignRef(countries,$countries);
		$this->assignRef(rec,$rec);
		$this->assignRef(departments,$departments);
		$this->assignRef(categories,$categories);
		$this->assignRef(grades,$grades);
		$this->assignRef(departmentname,$departmentname);
		$this->assignRef(categoryname,$categoryname);
		$this->assignRef(positions,$positions);

		$document = &JFactory::getDocument();
		$document->addScript( 'media/system/js/sample.js' );
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	//        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Staff','index.php?option=com_cce&controller=staffs&view=staffs&Itemid='.$Itemid);
        	$pathway->addItem('Add');
		parent::display();
	}

	function displayEdit($id)
	{
		$Itemid = JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->getStaff($id,$rec);
		$countries = $model->getCountries();
		$countryname1 = $model->getCountryName($rec->nationality);
		$countryname2 = $model->getCountryName($rec->country);
		$departmentname= $model->getDepartmentName($rec->department);
		$categoryname= $model->getCategoryName($rec->category);
		$gradename= $model->getGradeName($rec->grade);
		$positionname= $model->getPositionName($rec->position);
		$departments= $model->getDepartments();
		$categories= $model->getCategories();
		$positions= $model->getPositions();
		$grades= $model->getGrades();
		$this->assignRef(rec,$rec);
		$this->assignRef(countries,$countries);
		$this->assignRef(countryname1,$countryname1);
		$this->assignRef(countryname2,$countryname2);
		$this->assignRef(departments,$departments);
		$this->assignRef(categories,$categories);
		$this->assignRef(grades,$grades);
		$this->assignRef(positions,$positions);
		$this->assignRef(departmentname,$departmentname);
		$this->assignRef(categoryname,$categoryname);
		$this->assignRef(positionname,$positionname);
		$this->assignRef(gradename,$gradename);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	        //$pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        	$pathway->addItem('Staff','index.php?option=com_cce&controller=staffs&view=staffs&Itemid='.$Itemid);
        	$pathway->addItem('Edit');
		parent::display();
	}
}
