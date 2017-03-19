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
?>

<script type="text/javascript">
  Joomla.submitbutton = function(task)
  {
    if (task == 'synonym.cancel' || document.formvalidator.isValid(document.id('synonym-form'))) {
      Joomla.submitform(task, document.getElementById('synonym-form'));
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_tagmeta&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="synonym-form" class="form-validate">
  <div class="width-60 fltlft">
    <fieldset class="adminform">
      <legend><?php echo empty($this->item->id) ? JText::_('COM_TAGMETA_SYNONYM_NEW_SYNONYM') : JText::_('COM_TAGMETA_SYNONYM_EDIT_SYNONYM'); ?></legend>
      <ul class="adminformlist">
      <li><?php echo $this->form->getLabel('keywords'); ?>
      <?php echo $this->form->getInput('keywords'); ?></li>

      <li><?php echo $this->form->getLabel('synonyms'); ?>
      <?php echo $this->form->getInput('synonyms'); ?></li>

      <li><?php echo $this->form->getLabel('weight'); ?>
      <?php echo $this->form->getInput('weight'); ?></li>

      <li><?php echo $this->form->getLabel('comment'); ?>
      <?php echo $this->form->getInput('comment'); ?></li>

      <li><?php echo $this->form->getLabel('id'); ?>
      <?php echo $this->form->getInput('id'); ?></li>
      </ul>
    </fieldset>
  </div>

  <div class="width-40 fltrt">
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_TAGMETA_SYNONYM_OPTIONS'); ?></legend>
      <ul class="adminformlist">
        <li><?php echo $this->form->getLabel('published'); ?>
        <?php echo $this->form->getInput('published'); ?></li>
      </ul>
    </fieldset>
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_TAGMETA_SYNONYM_STATS'); ?></legend>
      <ul class="adminformlist">
        <li><?php echo $this->form->getLabel('hits'); ?>
        <?php echo $this->form->getInput('hits'); ?></li>

        <li><?php echo $this->form->getLabel('last_visit'); ?>
        <?php echo $this->form->getInput('last_visit'); ?></li>
        </ul>
    </fieldset>
  </div>

  <div class="clr"></div>

  <div class="width-100 fltlft">
    <?php echo JHtml::_('sliders.start','tagmeta-synonym-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
    <?php echo JHtml::_('sliders.panel',JText::_('COM_TAGMETA_SYNONYM_QUICK_HELP_LABEL'), 'quick-help'); ?>
    <fieldset class="panelform">
      <p><?php echo JText::_('COM_TAGMETA_SYNONYM_QUICK_HELP_DESC'); ?></p> 
    </fieldset>
    <?php echo JHtml::_('sliders.end'); ?>
  </div>

  <div class="clr"></div>

  <input type="hidden" name="task" value="" />
  <?php echo JHtml::_('form.token'); ?>
</form>
