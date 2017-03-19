<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewMaster extends JView
{
    function display($tpl = null)
    {
	//$app =& JFactory::getApplication();
        //$pathway =& $app->getPathway();
        //$pathway->addItem('Manage School - Home', 'index.php?option=com_cce&view=cce');
        //$pathway->addItem('News');
        $model = $this->getModel();
		$sinfo = $model->getSchoolInfo($rec);
		$this->assignRef('rec',$sinfo);
		   $this->assignRef( 'model', $model);
		$Itemid=JRequest::getVar('Itemid');
        $app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
        $pathway->addItem('Dashboard','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard');
        parent::display($tpl);
    }
}

