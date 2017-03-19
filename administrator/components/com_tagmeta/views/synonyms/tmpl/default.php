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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

// Add tooltip style
$document = JFactory::getDocument();
$document->addStyleDeclaration( '.tip-text {word-wrap: break-word !important;}' );

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$canOrder = $user->authorise('core.edit.state');
$saveOrder = $listOrder=='s.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_tagmeta&view=synonyms'); ?>" method="post" name="adminForm" id="adminForm">
  <fieldset id="filter-bar">
    <div class="filter-search fltlft">
      <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
      <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_TAGMETA_FILTER'); ?>" />
      <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
      <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
    </div>
    <div class="filter-select fltrt">
      <select name="filter_state" class="inputbox" onchange="this.form.submit()">
        <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
        <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true);?>
      </select>
    </div>
  </fieldset>
  <div class="clr"> </div>

<div id="editcell" style="overflow-x:scroll">
  <table class="adminlist">
  <thead>
    <tr>
      <th width="4%">
        <?php echo JText::_('COM_TAGMETA_NUM'); ?>
      </th>
      <th width="4%">
        <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
      </th>
      <th width="4%" nowrap="nowrap">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_SYNONYMS_ID', 's.id', $listDirn, $listOrder); ?>
      </th>
      <th width="20%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_SYNONYMS_KEYWORDS', 's.keywords', $listDirn, $listOrder); ?>
      </th>
      <th width="20%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_SYNONYMS_SYNONYMS', 's.synonyms', $listDirn, $listOrder); ?>
      </th>
      <th width="5%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_SYNONYMS_WEIGHT', 's.weight', $listDirn, $listOrder); ?>
      </th>
      <th width="18%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_SYNONYMS_COMMENT', 's.comment', $listDirn, $listOrder); ?>
      </th>
      <th width="5%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_SYNONYMS_HITS', 's.hits', $listDirn, $listOrder); ?>
      </th>
      <th width="5%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_SYNONYMS_LAST_VISIT', 's.last_visit', $listDirn, $listOrder); ?>
      </th>
      <th width="10%" nowrap="nowrap">
        <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 's.ordering', $listDirn, $listOrder); ?>
        <?php if ($canOrder && $saveOrder): ?>
          <?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'synonyms.saveorder'); ?>
        <?php endif;?>
      </th>
      <th width="5%" nowrap="nowrap">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_SYNONYMS_PUBLISHED', 's.published', $listDirn, $listOrder); ?>
      </th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td colspan="11">
        <?php echo $this->pagination->getListFooter(); ?>
        <p class="footer-tip">
          <?php if ($this->enabled) : ?>
            <span class="enabled"><?php echo JText::sprintf('COM_TAGMETA_PLUGIN_ENABLED', JText::_('COM_TAGMETA_PLG_SYSTEM_TAGMETA')); ?></span>
          <?php else : ?>
            <span class="disabled"><?php echo JText::sprintf('COM_TAGMETA_PLUGIN_DISABLED', JText::_('COM_TAGMETA_PLG_SYSTEM_TAGMETA')); ?></span>
          <?php endif; ?>
        </p>
      </td>
    </tr>
  </tfoot>
  <tbody>
  <?php
    if( count( $this->items ) > 0 ) {
      foreach ($this->items as $i => $item) :
      $ordering	= ($listOrder == 's.ordering');
      $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out==$userId || $item->checked_out==0;
      $canChange	= $canOrder && $canCheckin;
      $item_link = JRoute::_('index.php?option=com_tagmeta&task=synonym.edit&id='.(int) $item->id);
  ?>
      <tr class="row<?php echo $i % 2; ?>">
        <td>
          <?php echo $this->pagination->getRowOffset( $i ); ?>
        </td>
        <td class="center">
          <?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
        <td class="center">
          <?php echo $item->id; ?>
        </td>
        <td>
          <?php
            $max_chars = 100;
            $item_keywords = TagMetaHelper::trimText($item->keywords, $max_chars);
          ?>
          <span class="editlinktip hasTip" style="display:block; width:320px; word-wrap:break-word;" title="<?php echo addslashes(htmlspecialchars(JText::_('COM_TAGMETA_HEADING_SYNONYMS_KEYWORDS') . '::' . $item->keywords) ); ?>">
          <?php
            if (  JTable::isCheckedOut($userId, $item->checked_out) ) {
              echo $item_keywords;
            } else {
          ?>
              <a href="<?php echo $item_link; ?>" title="<?php echo JText::_('COM_TAGMETA_EDIT_ITEM'); ?>"><?php echo $item_keywords; ?></a>
          <?php
            }
          ?>
          </span>
        </td>
        <td>
          <?php
            $max_chars = 100;
            $item_synonyms = TagMetaHelper::trimText($item->synonyms, $max_chars);
          ?>
          <span class="editlinktip hasTip" style="display:block; width:320px; word-wrap:break-word;" title="<?php echo addslashes(htmlspecialchars(JText::_('COM_TAGMETA_HEADING_SYNONYMS_SYNONYMS') . '::' . $item->synonyms) ); ?>">
          <?php
            if (  JTable::isCheckedOut($userId, $item->checked_out) ) {
              echo $item_synonyms;
            } else {
          ?>
              <a href="<?php echo $item_link; ?>" title="<?php echo JText::_('COM_TAGMETA_EDIT_ITEM'); ?>"><?php echo $item_synonyms; ?></a>
          <?php
            }
          ?>
          </span>
        </td>
        <td>
          <?php echo $item->weight; ?>
        </td>

        <td>
          <?php
            $max_chars = 60;
            echo "<span class=\"editlinktip hasTip\" title=\"" . addslashes(htmlspecialchars(JText::_('COM_TAGMETA_HEADING_SYNONYMS_COMMENT') . '::' . $item->comment) ) . "\">";
            echo TagMetaHelper::trimText($item->comment, $max_chars);
            echo "</span>";
          ?>
        </td>
        <td class="center">
          <?php echo $item->hits; ?>
        </td>
        <td>
          <?php echo $item->last_visit; ?>
        </td>
        <td class="order">
          <?php if ($canChange) : ?>
            <?php if ($saveOrder) : ?>
              <?php if ($listDirn == 'asc') : ?>
                <span><?php echo $this->pagination->orderUpIcon($i, true, 'synonyms.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'synonyms.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
              <?php elseif ($listDirn == 'desc') : ?>
                <span><?php echo $this->pagination->orderUpIcon($i, true, 'synonyms.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'synonyms.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
              <?php endif; ?>
            <?php endif; ?>
            <?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
            <input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled; ?> class="text-area-order" />
          <?php else : ?>
            <?php echo $item->ordering; ?>
          <?php endif; ?>
        </td>
        <td class="center">
          <?php echo JHtml::_('jgrid.published', $item->published, $i, 'synonyms.', $canChange); ?>
        </td>
      </tr>
  <?php
      endforeach;
    } else {
  ?>
      <tr>
        <td colspan="11">
          <?php echo JText::_('COM_TAGMETA_LIST_NO_ITEMS'); ?>
        </td>
      </tr>
  <?php
    }
  ?>
    </tbody>
  </table>
</div>

  <div>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo JHtml::_('form.token'); ?>
  </div>
</form>