<?php
/**
 * 			plg System DatePicker
 * @version	 	1.1.0
 * @copyright		Copyright (C) 2007 - 2012 Yoshiki Kozaki All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 * @author		Yoshiki Kozaki
 * @link 			http://www.joomler.net/
 */
/**
 * @package		Joomla
 * @copyright		Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL
 */

/**
 * MooTools-DatePicker
 * @license MIT License
 * @link https://github.com/arian/mootools-datepicker
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemDatePicker extends JPlugin
{

	public function onAfterInitialise()
	{
		self::registerFunction();
	}

	public static function registerFunction()
	{
		JHtml::_('register', 'calendar', array('plgSystemDatePicker', 'calendar'));
	}

	public static function calendar($value, $name, $id, $format = '%Y-%m-%d', $attribs = null)
	{
		static $done = array(), $options = null;

		$params = self::getParams();

		$excludes = trim($params->get('excludes'));
		if (!empty($excludes))
		{
			$excludes = explode("\n", $excludes);
			$option   = JRequest::getCmd('option');
			foreach ($excludes as $exclude)
			{
				if ($option == strtolower($exclude))
				{
					return JHtml::calendar($value, $name, $id, $format, $attribs);
				}
			}
		}

		$readonly = isset($attribs['readonly']) && $attribs['readonly'] == 'readonly';
		$disabled = isset($attribs['disabled']) && $attribs['disabled'] == 'disabled';
		if (is_array($attribs))
		{
			$attribs = JArrayHelper::toString($attribs);
		}

		if (!$readonly && !$disabled)
		{
			self::calendarJs();

			// Only display the triggers once for each control.
			if (!in_array($id, $done))
			{
				if (is_null($options))
				{
					$options = array();
					$options[] = 'timePicker:true';
					$offsetx   = intval($params->get('offsetx', 5));
					$offsety   = intval($params->get('offsety', 0));
					$options[] = "positionOffset:{x:$offsetx, y:$offsety}";
//					$options[] = 'useFadeInOut:!Browser.ie';
					$options[] = "format:'$format'";

					switch ($params->get('theme', 'dashboard'))
					{
						case 'jqui':
							$options[] = "pickerClass:'datepicker_jqui'";
							break;
						case 'vista':
							$options[] = "pickerClass:'datepicker_vista'";
							break;
						case 'dashboard':
							$options[] = "pickerClass:'datepicker_dashboard'";
							break;
					}

					switch (intval($params->get('columns')))
					{
						case 2:
							$options[] = 'columns:2';
							break;
						case 3:
							$options[] = 'columns:3';
							break;
					}

					$options = implode(',', $options);
				}

				$js = "window.addEvent('domready', function() {
						new Picker.Date(
							document.id('$id'), { $options}
						);
					});"
				;
				JFactory::getDocument()->addScriptDeclaration(str_replace(array("\n", "\t", '  '), array('', '', ' '), trim($js)));
				$done[] = $id;
			}
			return '<input type="text" title="' . (0 !== (int) $value ? JHtml::_('date', $value) : '') . '" name="' . $name . '" id="' . $id
					. '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '" ' . $attribs . ' />';
		}
		else
		{
			return '<input type="text" title="' . (0 !== (int) $value ? JHtml::_('date', $value) : '')
					. '" value="' . (0 !== (int) $value ? JHtml::_('date', $value, JFactory::getDbo()->getDateFormat()) : '') . '" ' . $attribs
					. ' /><input type="hidden" name="' . $name . '" id="' . $id . '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '" />';
		}
	}

	protected static function calendarJs()
	{
		static $done = null;

		if (!is_null($done))
		{
			return;
		}

		$tag = JFactory::getLanguage()->getTag();

		$params = self::getParams();
		$theme  = $params->get('theme', 'dashboard');
		if (($theme != 'default' && $params->get('columns') > 1))
		{
			JHtml::_('stylesheet', 'media/datepicker/datepicker.css');
			$params->set('theme', 'default');
			$theme = 'default';
		}

		switch ($theme)
		{
			case 'jqui':
				JHtml::_('stylesheet', 'media/datepicker/datepicker_jqui/datepicker_jqui.css');
				break;
			case 'vista':
				JHtml::_('stylesheet', 'media/datepicker/datepicker_vista/datepicker_vista.css');
				break;
			case 'dashboard':
				JHtml::_('stylesheet', 'media/datepicker/datepicker_dashboard/datepicker_dashboard.css');
				break;
			case 'default':
				JHtml::_('stylesheet', 'media/datepicker/datepicker.css');
		}

		JHtml::_('script', 'media/datepicker/locales/Locale.' . $tag . '.DatePicker.js', true);
		JHtml::_('script', 'media/datepicker/Picker.js');
		JHtml::_('script', 'media/datepicker/Picker.Attach.js');
		JHtml::_('script', 'media/datepicker/Picker.Date.js');
		$js = "window.addEvent('domready', function(){Locale.use('$tag');});";
		JFactory::getDocument()->addScriptDeclaration($js);

		$done = true;
	}

	protected static function getParams()
	{
		static $params = null;

		if (!is_null($params))
		{
			return $params;
		}

		$plugin = JPluginHelper::getPlugin('system', 'datepicker');
		$params = new JRegistry($plugin->params);

		return $params;
	}

}