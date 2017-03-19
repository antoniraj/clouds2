<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 */
 
class CceViewAssignMembers extends JView
{
    function display($groupid,$tpl = null)
    {
	$Itemid = JRequest::getVar('Itemid');
	$model = &$this->getModel();
     $courses = $model->getCurrentCourses();
    foreach($courses as $value)
	{
		$cid[]=$value->id;
	}
	
	$students1 = $model->getStudents($cid[0]);	
	 $this->assignRef( 'courseid', $cid[0]);
     
	$cs = $model->getCurrentCourses();
        $this->assignRef( 'courses', $cs );
        $this->assignRef( 'groupid', $groupid );
        $this->assignRef( 'model', $model );
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        //$pathway->addItem('Manage', 'index.php?option=com_cce&view=cce');
        $pathway->addItem('Groups','index.php?option=com_cce&controller=groupmembers&view=groupmembers&Itemid='.$Itemid);
       	$pathway->addItem('Members');
 
        parent::display($tpl);
    }
    
	

}

