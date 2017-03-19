<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewCoSReports extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
        $this->assignRef( 'model', $model);
	$Itemid=JRequest::getVar('Itemid');
	$courseid=JRequest::getVar('courseid');

        $app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
//	$pathway->addItem('Classes', 'index.php?option=com_cce&controller=classreports&task=display&view=coursereports&Itemid='.$Itemid);
        $pathway->addItem('Profile', 'index.php?option=com_cce&controller=classreports&view=rshowcourseprofile&task=showcourseprofile&courseid='.$courseid.'&Itemid='.$Itemid);
        $pathway->addItem('Term Report');

        parent::display($tpl);
    }
}

