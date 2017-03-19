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

jimport('joomla.installer.installer');

/**
 * Script file of Tag Meta component
 */
class com_TagMetaInstallerScript
{
  /**
   * method to install the component
   *
   * @return void
   */
  function install($parent)
  {
    // Install plugin
    $myparent = $parent->getParent();
    $plugin_path = $myparent->getPath('source').DS.'plugins'.DS.'system'.DS.'tagmeta';
    $installer = new JInstaller();
    if (!$installer->install($plugin_path)) {
      echo '<p>' . JText::sprintf('COM_TAGMETA_PLUGIN_INSTALLATION_FAILED', JText::_('plg_system_tagmeta')) . '</p>';
      JError::raiseWarning(1, 'TagMetaInstallerScript::install(): ' . JText::_('COM_TAGMETA_PLUGIN_INSTALLATION_FAILED_SHORT'));
    } else {
      echo '<p>' . JText::sprintf('COM_TAGMETA_PLUGIN_INSTALLATION_SUCCESS', JText::_('plg_system_tagmeta')) . '</p>';
    }

  }

  /**
   * method to update the component
   *
   * @return void
   */
  function update($parent)
  {
    // Install plugin
    $myparent = $parent->getParent();
    $plugin_path = $myparent->getPath('source').DS.'plugins'.DS.'system'.DS.'tagmeta';
    $installer = new JInstaller();
    if (!$installer->install($plugin_path)) {
      echo '<p>' . JText::sprintf('COM_TAGMETA_PLUGIN_INSTALLATION_FAILED', JText::_('plg_system_tagmeta')) . '</p>';
      JError::raiseWarning(1, 'TagMetaInstallerScript::install(): ' . JText::_('COM_TAGMETA_PLUGIN_INSTALLATION_FAILED_SHORT'));
    } else {
      echo '<p>' . JText::sprintf('COM_TAGMETA_PLUGIN_INSTALLATION_SUCCESS', JText::_('plg_system_tagmeta')) . '</p>';
    }

  }

  /**
   * method to uninstall the component
   *
   * @return void
   */
  function uninstall($parent)
  {
    $db =& JFactory::getDBO();
    $query = 'SELECT `extension_id`, `name` FROM #__extensions WHERE type = \'plugin\' AND element = \'tagmeta\' AND folder = \'system\'';
    $db->setQuery($query);
    $plugins = $db->loadObjectList();

    if (count($plugins)) {
      foreach ($plugins as $plugin) {
        $installer = new JInstaller();
        if (!$installer->uninstall('plugin', $plugin->extension_id, 0)) {
          echo '<p>' . JText::_('COM_TAGMETA_PLUGIN_UNINSTALLATION_FAILED') . '</p><br />';
          JError::raiseWarning(1, 'TagMetaInstallerScript::uninstall(): ' . JText::_('COM_TAGMETA_PLUGIN_UNINSTALLATION_FAILED_SHORT') . $plugin->name);
        } else {
          echo '<p>' . JText::_('COM_TAGMETA_PLUGIN_UNINSTALLATION_SUCCESS') . $plugin->name . '</p><br />';
        }
      }
    }

    echo '<p>' . JText::_('COM_TAGMETA_UNINSTALLATION_TEXT') . '</p>';

  }

}

?>
