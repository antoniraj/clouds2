<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
*/
 
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
 */
 
class CceViewAcademicYears extends JView
{
    function displayAcademicYears($tpl = null)
    {
	$model = &$this->getModel();
	$years = $model->getAcademicYears();

        $this->assignRef( 'years', $years );
 
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
        $pathway->addItem('Academic Years');

        parent::display($tpl);
    }
}

