<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewManageSubjects extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$subjects = $model->getMSubjects();
        $this->assignRef( 'subjects', $subjects);

//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
    //    $pathway->addItem('Manage Subjects'); 

        parent::display($tpl);
    }

    function addSubject($tpl = null)
    {
	$Itemid = JRequest::getVar('Itemid');
        $model = &$this->getModel();
//        $app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway();
//        $pathway->addItem('CCE', 'index.php?option=com_cce&controller=cce&&view=cce');
    //    $pathway->addItem('Subjects', 'index.php?option=com_cce&controller=managesubjects&view=managesubjects&Itemid='.$Itemid);
      //  $pathway->addItem('Add Subject');
        parent::display($tpl);
    }

    function editSubject($cid,$tpl = null)
    {
        $model = &$this->getModel();
	$status = $model->getMSubject($cid,$rec);
	
	$Itemid = JRequest::getVar('Itemid');	
        $this->assignRef( 'rec', $rec);

    //    $app =& JFactory::getApplication();
      //  $pathway =& $app->getPathway();
        //$pathway->addItem('Subjects', 'index.php?option=com_cce&controller=managesubjects&view=managesubjects&Itemid='.$Itemid);
       // $pathway->addItem('Edit Subject');

        parent::display($tpl);
    }


}

