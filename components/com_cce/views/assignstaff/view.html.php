<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewAssignStaff extends JView
{
    function display($courseid,$tpl = null)
    {
	$Itemid = JRequest::getVar('Itemid');
	$model = &$this->getModel();
	$staffs = $model->getStaffs();
        $this->assignRef( 'staffs', $staffs );
        $this->assignRef( 'courseid', $courseid );
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        //$pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        $pathway->addItem('Class Teachers','index.php?option=com_cce&controller=classteachers&view=classteachers&Itemid='.$Itemid);
       	$pathway->addItem('Assign');
 
        parent::display($tpl);
    }
	

}

