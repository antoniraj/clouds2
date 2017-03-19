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

// Include the HTML helpers
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

// Add tooltip style
$document = JFactory::getDocument();
$document->addStyleDeclaration( '.tip-text {word-wrap: break-word !important;}' );
$document->addStyleDeclaration( 'table.paramlist td.paramlist_key {width: 92px; text-align: left; height: 30px;}' );
$document->addStyleDeclaration( '.pane-sliders {margin: 18px 10px 0 !important;}' );
$document->addStyleDeclaration( 'fieldset.panelform thead {background-color: blue; font-weight: bold; color: white;}' );
$document->addStyleDeclaration( 'fieldset.panelform .macrogroup {background-color: yellow; font-weight: bold; color: black;}' );
?>

<script type="text/javascript">
  Joomla.submitbutton = function(task)
  {
    if (task == 'rule.cancel' || document.formvalidator.isValid(document.id('rule-form'))) {
      Joomla.submitform(task, document.getElementById('rule-form'));
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_tagmeta&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="rule-form" class="form-validate">
  <div class="width-50 fltlft">
    <fieldset class="adminform">
      <legend><?php echo empty($this->item->id) ? JText::_('COM_TAGMETA_RULE_NEW_RULE') : JText::_('COM_TAGMETA_RULE_EDIT_RULE'); ?></legend>
      <ul class="adminformlist">
      <li><?php echo $this->form->getLabel('url'); ?>
      <?php echo $this->form->getInput('url'); ?></li>

      <li><?php echo $this->form->getLabel('case_sensitive'); ?>
      <?php echo $this->form->getInput('case_sensitive'); ?></li>

      <li><?php echo $this->form->getLabel('request_only'); ?>
      <?php echo $this->form->getInput('request_only'); ?></li>

      <li><?php echo $this->form->getLabel('decode_url'); ?>
      <?php echo $this->form->getInput('decode_url'); ?></li>

      <li><?php echo $this->form->getLabel('last_rule'); ?>
      <?php echo $this->form->getInput('last_rule'); ?></li>

      <li><?php echo $this->form->getLabel('placeholders'); ?>
      <?php echo $this->form->getInput('placeholders'); ?></li>

      <li><?php echo $this->form->getLabel('comment'); ?>
      <?php echo $this->form->getInput('comment'); ?></li>

      <li><?php echo $this->form->getLabel('id'); ?>
      <?php echo $this->form->getInput('id'); ?></li>
      </ul>
    </fieldset>
  </div>

  <div class="width-50 fltrt">
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_TAGMETA_RULE_PUBLISHING_OPTIONS'); ?></legend>
      <ul class="adminformlist">
        <li><?php echo $this->form->getLabel('published'); ?>
        <?php echo $this->form->getInput('published'); ?></li>
      </ul>
    </fieldset>
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_TAGMETA_RULE_SYNONYMS_OPTIONS'); ?></legend>
      <ul class="adminformlist">
        <li><?php echo $this->form->getLabel('synonyms'); ?>
        <?php echo $this->form->getInput('synonyms'); ?></li>

        <li><?php echo $this->form->getLabel('synonmax'); ?>
        <?php echo $this->form->getInput('synonmax'); ?></li>

        <li><?php echo $this->form->getLabel('synonweight'); ?>
        <?php echo $this->form->getInput('synonweight'); ?></li>
      </ul>
    </fieldset>
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_TAGMETA_RULE_GLOBAL_OVERRIDES'); ?></legend>
      <ul class="adminformlist">
        <li><?php echo $this->form->getLabel('preserve_title'); ?>
        <?php echo $this->form->getInput('preserve_title'); ?></li>
    </fieldset>
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_TAGMETA_RULE_STATS'); ?></legend>
      <ul class="adminformlist">
        <li><?php echo $this->form->getLabel('hits'); ?>
        <?php echo $this->form->getInput('hits'); ?></li>

        <li><?php echo $this->form->getLabel('last_visit'); ?>
        <?php echo $this->form->getInput('last_visit'); ?></li>
        </ul>
    </fieldset>
  </div>

  <div class="clr"></div>

  <div class="width-50 fltlft">
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_TAGMETA_RULE_META_OPTIONS'); ?></legend>
      <ul class="adminformlist">
      <li><?php echo str_replace('jform_title', 'jform_metatitle', $this->form->getLabel('title')); /* Needs to change the auto id to avoid CSS settings for jform_title */ ?>
      <?php echo str_replace('jform_title', 'jform_metatitle', $this->form->getInput('title')); /* Needs to change the auto id to avoid CSS settings for jform_title */ ?></li>

      <li><?php echo $this->form->getLabel('description'); ?>
      <?php echo $this->form->getInput('description'); ?></li>

      <li><?php echo $this->form->getLabel('author'); ?>
      <?php echo $this->form->getInput('author'); ?></li>

      <li><?php echo $this->form->getLabel('keywords'); ?>
      <?php echo $this->form->getInput('keywords'); ?></li>

      <li><?php echo $this->form->getLabel('rights'); ?>
      <?php echo $this->form->getInput('rights'); ?></li>

      <li><?php echo $this->form->getLabel('xreference'); ?>
      <?php echo $this->form->getInput('xreference'); ?></li>

      <li><?php echo $this->form->getLabel('canonical'); ?>
      <?php echo $this->form->getInput('canonical'); ?></li>
      </ul>
    </fieldset>
  </div>

  <div class="width-50 fltrt">
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_TAGMETA_RULE_ROBOTS_OPTIONS'); ?></legend>
      <ul class="adminformlist">
        <li><?php echo $this->form->getLabel('rindex'); ?>
        <?php echo $this->form->getInput('rindex'); ?></li>

        <li><?php echo $this->form->getLabel('rfollow'); ?>
        <?php echo $this->form->getInput('rfollow'); ?></li>

        <li><?php echo $this->form->getLabel('rsnippet'); ?>
        <?php echo $this->form->getInput('rsnippet'); ?></li>

        <li><?php echo $this->form->getLabel('rarchive'); ?>
        <?php echo $this->form->getInput('rarchive'); ?></li>

        <li><?php echo $this->form->getLabel('rodp'); ?>
        <?php echo $this->form->getInput('rodp'); ?></li>

        <li><?php echo $this->form->getLabel('rimageindex'); ?>
        <?php echo $this->form->getInput('rimageindex'); ?></li>
      </ul>
    </fieldset>
  </div>

  <div class="clr"></div>

  <div class="width-100 fltrt">
    <?php echo JHtml::_('sliders.start','tagmeta-rule-sliders-'.$this->item->id, array('useCookie'=>1, 'allowAllClose'=>1, 'startOffset'=>-1)); ?>
    <?php echo JHtml::_('sliders.panel',JText::_('COM_TAGMETA_RULE_QUICK_HELP_LABEL'), 'quick-help'); ?>
    <fieldset class="panelform">
      <p><?php echo JText::_('COM_TAGMETA_RULE_QUICK_HELP_DESC'); ?></p>
    </fieldset>
    <?php echo JHtml::_('sliders.panel',JText::_('COM_TAGMETA_RULE_PLACEHOLDERS_LABEL'), 'placeholders'); ?>
    <fieldset class="panelform">
      <p><?php echo JText::_('COM_TAGMETA_RULE_PLACEHOLDERS_DESC'); ?></p>
    </fieldset>
    <?php echo JHtml::_('sliders.panel',JText::_('COM_TAGMETA_RULE_SUPPORTED_MACROS_LABEL'), 'supported-macros'); ?>
    <fieldset class="panelform">
      <p><?php echo JText::_('COM_TAGMETA_RULE_SUPPORTED_MACROS_DESC'); ?></p>
    </fieldset>
    <?php echo JHtml::_('sliders.end'); ?>
  </div>

  <div class="clr"></div>

  <input type="hidden" name="task" value="" />
  <?php echo JHtml::_('form.token'); ?>
</form>
