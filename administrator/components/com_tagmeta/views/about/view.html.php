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

/**
 * HTML View class for the Tag Meta About component
 *
 * @package TagMeta
 *
 */
class TagMetaViewAbout extends JView
{

  public function display($tpl = null)
  {
    $this->addToolbar();
    echo "<div style=\"float: left; margin-right: 20px;\"><img src=\"".JURI::root()."administrator/components/com_tagmeta/images/logo.png\" alt=\"Tag Meta\"/></div>";
    echo "<div style=\"float: none;\">".JText::_('COM_TAGMETA_COPYRIGHT')."</div>";
    echo "<div>".JText::_('COM_TAGMETA_ABOUT_DESC')."<br /><br /></div>";
    echo "<div>".JText::_('COM_TAGMETA_DONATE')."<br /><br /></div>";
    echo "<div>".JText::_('COM_TAGMETA_DONATE_PAYPAL')."</div>";
  }

  /**
   * Add the page title and toolbar
   *
   * @since  1.6
   */
  protected function addToolbar()
  {
    JToolBarHelper::title(JText::_('COM_TAGMETA_MANAGER'), 'tagmeta.png');

    require_once JPATH_COMPONENT.'/helpers/tagmeta.php';
    $canDo = TagMetaHelper::getActions();

    if ($canDo->get('core.admin')) {
      JToolBarHelper::preferences('com_tagmeta');
    }

  }

}
?>
