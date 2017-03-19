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

jimport( 'joomla.application.component.view');

require_once JPATH_COMPONENT.'/helpers/tagmeta.php';

/**
 * HTML View class for the Tag Meta Rules component
 *
 * @package TagMeta
 *
 */
class TagMetaViewRules extends JView
{
  protected $enabled;
  protected $items;
  protected $pagination;
  protected $state;

  public function display($tpl = null)
  {
    // Initialise variables
    $this->enabled = TagMetaHelper::isEnabled();
    $this->items = $this->get('Items');
    $this->pagination = $this->get('Pagination');
    $this->state = $this->get('State');

    // Check for errors
    if (count($errors = $this->get('Errors'))) {
      JError::raiseError(500, implode("\n", $errors));
      return false;
    }

    $this->addToolbar();
    parent::display($tpl);
  }

  /**
   * Add the page title and toolbar
   *
   * @since  1.6
   */
  protected function addToolbar()
  {
    JToolBarHelper::title(JText::_('COM_TAGMETA_MANAGER'), 'tagmeta.png');

    $canDo = TagMetaHelper::getActions();

    if ($canDo->get('core.create')) {
      JToolBarHelper::customX('rules.copy', 'copy.png', 'copy_f2.png', JText::_('COM_TAGMETA_TOOLBAR_COPY'));
      JToolBarHelper::addNew('rule.add');
    }

    if ($canDo->get('core.edit')) {
      JToolBarHelper::editList('rule.edit');
    }

    JToolBarHelper::divider();

    if ($canDo->get('core.edit.state')) {
      if ($this->state->get('filter.state') != 2){
        JToolBarHelper::publish('rules.publish', 'JTOOLBAR_PUBLISH', true);
        JToolBarHelper::unpublish('rules.unpublish', 'JTOOLBAR_UNPUBLISH', true);
      }

      JToolBarHelper::divider();

      if ($this->state->get('filter.state') != -1 ) {
        if ($this->state->get('filter.state') != 2) {
          JToolBarHelper::archiveList('rules.archive');
        }
        else if ($this->state->get('filter.state') == 2) {
          JToolBarHelper::unarchiveList('rules.publish');
        }
      }

      //JToolBarHelper::checkin('rules.checkin');
      JToolBarHelper::custom('rules.checkin', 'checkin', '', 'JTOOLBAR_CHECKIN', true);
      JToolBarHelper::trash('rules.trash');

    }

    if ( $canDo->get('core.delete')) {
      JToolBarHelper::deleteList('', 'rules.delete', 'JTOOLBAR_EMPTY_TRASH');
    }

    JToolBarHelper::divider();

    if ($canDo->get('core.admin')) {
      JToolBarHelper::preferences('com_tagmeta');
    }

  }

}
?>
