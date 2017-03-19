<?php
/**
 * Tag Meta Community component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package TagMeta
 * @copyright Copyright 2009 - 2013
 * @license GNU Public License
 * @link http://www.selfget.com
 * @version 1.7.2
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of Tag Meta component
 */
class TagMetaController extends JController
{
  /**
   * @var    string  The default view.
   * @since  1.6
   */
  protected $default_view = 'rules';

  /**
   * Display view
   *
   * @return void
   */
  public function display($cachable = false, $urlparams = false)
  {
    $view = JRequest::getCmd('view', 'rules');
    $layout = JRequest::getCmd('layout', 'default');
    $id = JRequest::getInt('id');

    // Set the submenu
    require_once JPATH_COMPONENT.'/helpers/tagmeta.php';
    TagMetaHelper::addSubmenu($view);

    // Check for edit form
    if ($view == 'rule' && $layout == 'edit' && !$this->checkEditId('com_tagmeta.edit.rule', $id)) {
      // Somehow the person just went to the form - we don't allow that
      $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
      $this->setMessage($this->getError(), 'error');
      $this->setRedirect(JRoute::_('index.php?option=com_tagmeta&view=rule', false));

      return false;
    }
    else if ($view == 'synonym' && $layout == 'edit' && !$this->checkEditId('com_tagmeta.edit.synonym', $id)) {
      // Somehow the person just went to the form - we don't allow that
      $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
      $this->setMessage($this->getError(), 'error');
      $this->setRedirect(JRoute::_('index.php?option=com_tagmeta&view=synonyms', false));

      return false;
    }

    // Call parent behavior
    parent::display();

    return $this;
  }

}
