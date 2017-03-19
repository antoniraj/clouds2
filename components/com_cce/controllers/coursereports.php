<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
 */
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
{ 
    function display()
    {
	echo "test";
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model= & $this->getModel('marks');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($layoutName);
        $view->display();
    }


    function back()
    {
	$referer = JRequest::getString('referer', JURI::base(), 'post');
	$referer = base64_decode($referer);
	$this->setRedirect($referer); 
    }
}


