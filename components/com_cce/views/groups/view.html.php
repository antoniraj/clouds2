<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewGroups extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$groups = $model->getGroups();
        $this->assignRef( 'groups', $groups);
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
    //    $pathway->addItem('Management', 'index.php?option=com_cce&view=cce');
      //  $pathway->addItem('Student Groups');
 
        parent::display($tpl);
    }
}

