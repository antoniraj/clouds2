<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewStudentProfile extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
        $this->assignRef( 'model', $model);
	$Itemid=JRequest::getVar('Itemid');
	$courseid=JRequest::getVar('courseid');
	$model->getCourse($courseid,$crec);
	$this->assignRef(crec,$crec);

        parent::display($tpl);
    }
}

