<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewCoSMarks extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
        $this->assignRef( 'model', $model);
	$Itemid = JRequest::getVar('Itemid');
	$courseid= JRequest::getVar('courseid');
	$termid= JRequest::getVar('termid');

        $app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
	$pathway->addItem('Classes', 'index.php?option=com_cce&controller=classreports&task=display&view=coursereports&Itemid='.$Itemid);
        $pathway->addItem('Profile', 'index.php?option=com_cce&controller=courses&view=showcourseprofile&task=display&courseid='.$courseid.'&Itemid='.$Itemid);
        $pathway->addItem('Marks');

 
        parent::display($tpl);
    }
}

