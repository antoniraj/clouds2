<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewDepartments extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$departments = $model->getDepartments();
        $this->assignRef( 'departments', $departments );
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
    //    $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
//	$pathway->addItem('Departments'); 
 
        parent::display($tpl);
    }


	function departmentcourses($tbl=null){
		$model = &$this->getModel();
		$departments = $model->getDepartments();
        	$this->assignRef( 'departments', $departments );
        	parent::display($tpl);
	}
		
	function courselist(){
		$model = &$this->getModel();
        	parent::display($tpl);
	}
}

