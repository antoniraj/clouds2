<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 */
 
class CceViewAssignSubjectTeacher extends JView
{
    function display($courseid,$subjectid,$tpl = null)
    {
	$Itemid = JRequest::getVar('Itemid');
        $model = &$this->getModel();
        $staffs = $model->getStaffs();
        $this->assignRef( 'staffs', $staffs );
        $this->assignRef( 'courseid', $courseid );
        $this->assignRef( 'subjectid', $subjectid );
        $this->assignRef( 'model', $model );
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
	//$pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
    //   	$pathway->addItem('Subject Teachers','index.php?option=com_cce&controller=subjects&view=subjectteachers&Itemid='.$Itemid);
      // 	$pathway->addItem('Assign');

        parent::display($tpl);
    }

}

