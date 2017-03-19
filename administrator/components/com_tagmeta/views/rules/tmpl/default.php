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
$document->addStyleDeclaration( '.jrules td {padding: 0 10px 2px 0 !important; border: none !important;}' );
$document->addStyleDeclaration( 'span.hasTip {float: right !important;}' );
	
$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$canOrder = $user->authorise('core.edit.state');
$saveOrder = $listOrder=='a.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_tagmeta&view=rules'); ?>" method="post" name="adminForm" id="adminForm">
  <fieldset id="filter-bar">
    <div class="filter-search fltlft">
      <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
      <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_TAGMETA_FILTER'); ?>" />
      <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
      <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
    </div>
    <div class="filter-select fltrt">
      <select name="filter_state" class="inputbox" onchange="this.form.submit()">
        <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED'); ?></option>
        <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true); ?>
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
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_ID', 'a.id', $listDirn, $listOrder); ?>
      </th>
      <th width="10%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_URL', 'a.url', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_CASE_SENSITIVE', 'a.case_sensitive', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_REQUEST_ONLY', 'a.request_only', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_DECODE_URL', 'a.decode_url', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_LAST_RULE', 'a.last_rule', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_PRESERVE_TITLE', 'a.preserve_title', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_SYNONYMS', 'a.synonyms', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_COMMENT', 'a.comment', $listDirn, $listOrder); ?>
      </th>
      <th width="48%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_TITLE', 'a.title', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_DESCRIPTION', 'a.description', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_AUTHOR', 'a.author', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_KEYWORDS', 'a.keywords', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_RIGHTS', 'a.rights', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_XREFERENCE', 'a.xreference', $listDirn, $listOrder); ?>
        &nbsp;/&nbsp;
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_CANONICAL', 'a.canonical', $listDirn, $listOrder); ?>
      </th>
      <th width="6%"><?php echo JText::_('COM_TAGMETA_HEADING_RULES_ROBOTS'); ?></th>
      <th width="4%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_HITS', 'a.hits', $listDirn, $listOrder); ?>
      </th>
      <th width="5%">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_LAST_VISIT', 'a.last_visit', $listDirn, $listOrder); ?>
      </th>
      <th width="10%" nowrap="nowrap">
        <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
        <?php if ($canOrder && $saveOrder): ?>
          <?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'rules.saveorder'); ?>
        <?php endif; ?>
      </th>
      <th width="5%" nowrap="nowrap">
        <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_PUBLISHED', 'a.published', $listDirn, $listOrder); ?>
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
      $ordering	= ($listOrder == 'a.ordering');
      $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out==$userId || $item->checked_out==0;
      $canChange = $canOrder && $canCheckin;
      $item_link = JRoute::_('index.php?option=com_tagmeta&task=rule.edit&id='.(int) $item->id);
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
          <span style="display:block; width:200px; word-wrap:break-word;">
          <?php
            $max_chars = 100;
            $item_url = TagMetaHelper::trimText($item->url, $max_chars);
            if (  JTable::isCheckedOut($userId, $item->checked_out) ) {
              echo $item_url;
            } else {
          ?>
              <a href="<?php echo $item_link; ?>" title="<?php echo JText::_('COM_TAGMETA_EDIT_ITEM'); ?>"><?php echo $item_url; ?></a>
          <?php
            }
          ?>
          </span>
          <br />
          <table class="jrules">
          <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_CASE_SENSITIVE_LABEL').'</td>';
          if ($item->case_sensitive) {
            $jtask = 'rules.case_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
          } else {
            $jtask = 'rules.case_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
          } ?>
          <td><a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>">
          <span class="state <?php echo $jstate; ?>"><span class="text"><?php echo $jtext; ?></span></span></a>
          </td></tr>
          <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_REQUEST_ONLY_LABEL').'</td>';
          if ($item->request_only) {
            $jtask = 'rules.request_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
          } else {
            $jtask = 'rules.request_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
          } ?>
          <td><a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>">
          <span class="state <?php echo $jstate; ?>"><span class="text"><?php echo $jtext; ?></span></span></a>
          </td></tr>
          <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_DECODE_URL_LABEL').'</td>';
          if ($item->decode_url) {
            $jtask = 'rules.decode_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
          } else {
            $jtask = 'rules.decode_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
          } ?>
          <td><a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>">
          <span class="state <?php echo $jstate; ?>"><span class="text"><?php echo $jtext; ?></span></span></a>
          </td></tr>
          <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_LAST_RULE_LABEL').'</td>';
          if ($item->last_rule) {
            $jtask = 'rules.last_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
          } else {
            $jtask = 'rules.last_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
          } ?>
          <td><a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>">
          <span class="state <?php echo $jstate; ?>"><span class="text"><?php echo $jtext; ?></span></span></a>
          </td></tr>
          <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_PRESERVE_TITLE_LABEL').'</td>';
          if ($item->preserve_title) {
            $jtask = 'rules.preserve_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
          } else {
            $jtask = 'rules.preserve_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
          } ?>
          <td><a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>">
          <span class="state <?php echo $jstate; ?>"><span class="text"><?php echo $jtext; ?></span></span></a>
          </td></tr>
          <tr><td><?php echo JText::_('COM_TAGMETA_FIELD_RULES_PLACEHOLDERS_LABEL') . '&nbsp;' . JHTML::tooltip(nl2br($item->placeholders), JText::_('COM_TAGMETA_FIELD_RULES_PLACEHOLDERS_LABEL'), 'tooltip.png', '', ''); ?></td><td><?php echo count(array_filter(explode("\n", trim($item->placeholders)))); ?></td></tr>
          <?php $synonyms_settings = JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_MAX_LABEL') . ' ' . $item->synonmax . ' / ' . (($item->synonweight) ? JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_WEIGHT_LABEL') : JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_ORDERING_LABEL'));
          echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_LABEL').'&nbsp;'.JHTML::tooltip($synonyms_settings, JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_SETTINGS_LABEL'), 'tooltip.png', '', '').'</td>';
          switch ($item->synonyms) {
            case 0:
              $jtask = 'rules.synonyms_on';
              $jtext = JText::_( 'JNO' );
              $jtext2 = '';
              $jstate = 'unpublish';
              break;
            case 1:
              $jtask = 'rules.synonyms_on_cs';
              $jtext = JText::_( 'JYES' );
              $jtext2 = '';
              $jstate = 'publish';
              break;
            case 2:
            default:
              $jtask = 'rules.synonyms_off';
              $jtext = JText::_('JYES' ) . ' (' . JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_CASE_SENSITIVE_LABEL') . ')';
              $jtext2 = '&nbsp;(' . JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_CASE_SENSITIVE_LABEL') . ')';
              $jstate = 'publish';
          } ?>
          <td><a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>">
          <span class="state <?php echo $jstate; ?>"><span class="text"><?php echo $jtext; ?></span></span></a><?php echo $jtext2; ?>
          </td></tr>
          </table>
          <br />
          <div style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px; height: 45px; width: 225px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo JText::_('COM_TAGMETA_FIELD_RULES_COMMENT_LABEL')."::".htmlspecialchars($item->comment, ENT_QUOTES); ?>">
            <?php
              $max_chars = 100;
              echo TagMetaHelper::trimText(htmlspecialchars($item->comment, ENT_QUOTES), $max_chars);
            ?>
          </div>
        </td>
        <td>
          <div style="float: left; border: 1px dashed silver; padding: 5px; margin-bottom: 10px; height: 45px; width: 225px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo JText::_('COM_TAGMETA_FIELD_RULES_TITLE_LABEL')."::".htmlspecialchars($item->title, ENT_QUOTES); ?>">
            <?php
              $max_chars = 100;
              echo TagMetaHelper::trimText(htmlspecialchars($item->title, ENT_QUOTES), $max_chars);
            ?>
          </div>
          <div style="float: right; border: 1px dashed silver; padding: 5px; margin-bottom: 10px; height: 45px; width: 225px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo JText::_('COM_TAGMETA_FIELD_RULES_DESCRIPTION_LABEL')."::".htmlspecialchars($item->description, ENT_QUOTES); ?>">
            <?php
              $max_chars = 100;
              echo TagMetaHelper::trimText(htmlspecialchars($item->description, ENT_QUOTES), $max_chars);
            ?>
          </div>
          <div style="float: left; border: 1px dashed silver; padding: 5px; margin-bottom: 10px; height: 45px; width: 225px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo JText::_('COM_TAGMETA_FIELD_RULES_AUTHOR_LABEL')."::".htmlspecialchars($item->author, ENT_QUOTES); ?>">
            <?php
              $max_chars = 100;
              echo TagMetaHelper::trimText(htmlspecialchars($item->author, ENT_QUOTES), $max_chars);
            ?>
          </div>
          <div style="float: right; border: 1px dashed silver; padding: 5px; margin-bottom: 10px; height: 45px; width: 225px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo JText::_('COM_TAGMETA_FIELD_RULES_KEYWORDS_LABEL')."::".htmlspecialchars($item->keywords, ENT_QUOTES); ?>">
            <?php
              $max_chars = 100;
              echo TagMetaHelper::trimText(htmlspecialchars($item->keywords, ENT_QUOTES), $max_chars);
            ?>
          </div>
          <div style="float: left; border: 1px dashed silver; padding: 5px; margin-bottom: 10px; height: 45px; width: 225px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo JText::_('COM_TAGMETA_FIELD_RULES_RIGHTS_LABEL')."::".htmlspecialchars($item->rights, ENT_QUOTES); ?>">
            <?php
              $max_chars = 100;
              echo TagMetaHelper::trimText(htmlspecialchars($item->rights, ENT_QUOTES), $max_chars);
            ?>
          </div>
          <div style="float: right; border: 1px dashed silver; padding: 5px; margin-bottom: 10px; height: 45px; width: 225px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo JText::_('COM_TAGMETA_FIELD_RULES_XREFERENCE_LABEL')."::".htmlspecialchars($item->xreference, ENT_QUOTES); ?>">
            <?php
              $max_chars = 100;
              echo TagMetaHelper::trimText(htmlspecialchars($item->xreference, ENT_QUOTES), $max_chars);
            ?>
          </div>
          <div style="float: left; border: 1px dashed silver; padding: 5px; margin-bottom: 10px; height: 45px; width: 225px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo JText::_('COM_TAGMETA_FIELD_RULES_CANONICAL_LABEL')."::".htmlspecialchars($item->canonical, ENT_QUOTES); ?>">
            <?php
              $max_chars = 100;
              echo TagMetaHelper::trimText(htmlspecialchars($item->canonical, ENT_QUOTES), $max_chars);
            ?>
          </div>
        </td>
        <td class="center">
          <?php
            $robots = '';
            if ($item->rindex != 2) { $robots .= ($item->rindex) ? 'index,' : 'noindex,'; }
            if ($item->rfollow != 2) { $robots .= ($item->rfollow) ? 'follow,' : 'nofollow,'; }
            if ($item->rsnippet != 2) { $robots .= ($item->rsnippet) ? 'snippet,' : 'nosnippet,'; }
            if ($item->rarchive != 2) { $robots .= ($item->rarchive) ? 'archive,' : 'noarchive,'; }
            if ($item->rodp != 2) { $robots .= ($item->rodp) ? 'odp' : 'noodp'; }
            if ($item->rimageindex != 2) { $robots .= ($item->rimageindex) ? 'imageindex,' : 'noimageindex,'; }
            $robots = rtrim($robots, ','); // Drop last char if is a comma
            echo $robots;
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
                <span><?php echo $this->pagination->orderUpIcon($i, true, 'rules.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'rules.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
              <?php elseif ($listDirn == 'desc') : ?>
                <span><?php echo $this->pagination->orderUpIcon($i, true, 'rules.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'rules.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
              <?php endif; ?>
            <?php endif; ?>
            <?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
            <input type="text" name="order[]" size="5" value="<?php echo $item->ordering; ?>" <?php echo $disabled; ?> class="text-area-order" />
          <?php else : ?>
            <?php echo $item->ordering; ?>
          <?php endif; ?>
        </td>
        <td class="center">
          <?php echo JHtml::_('jgrid.published', $item->published, $i, 'rules.', $canChange); ?>
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