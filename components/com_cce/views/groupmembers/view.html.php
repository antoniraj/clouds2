<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewGroupMembers extends JView
{
    function display($groupid = null)
    {
	$model = &$this->getModel();
	$groups = $model->getGroups();
	$rs = $model->getGroup($groupid,$rec);
	foreach($groups as $group) {
		$gid[]=$group->id;
	}

	
	if($groupid) {
		//$groupmembers = $model->getGroupMembersByClass($groupid,$classid);
		$groupmembers = $model->getGroupMembers($groupid);
	}
	$groupname=$rec->groupname;
        $this->assignRef( 'groups', $groups);
        $this->assignRef( 'groupmembers', $groupmembers);
        $this->assignRef( 'groupid', $groupid);
        $this->assignRef( 'groupname', $groupname);
        $this->assignRef( 'model', $model);
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
    //    $pathway->addItem('Master', 'index.php?option=com_cce&view=cce');
//	$pathway->addItem('Group Members'); 
        parent::display($tpl);
    }
}

