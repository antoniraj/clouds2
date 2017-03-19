<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class CceViewNews extends JView
{
    function display($tpl = null)
    {
	//$app =& JFactory::getApplication();
        //$pathway =& $app->getPathway();
        //$pathway->addItem('Manage School - Home', 'index.php?option=com_cce&view=cce');
        //$pathway->addItem('News');

        parent::display($tpl);
    }
}

