<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewStudentCategories extends JView
{
    function display($tpl = null)
    {
	$model = &$this->getModel();
	$cats= $model->getStudentCategories();
        $this->assignRef( 'cats', $cats);
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
    //    $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
//	$pathway->addItem('Departments'); 
 
        parent::display($tpl);
    }
}

