<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

?>


			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i><?php echo JText::_('COM_USERS_PROFILE_CORE_LEGEND'); ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>

						</div>
					</div>
					<div class="box-content">

					<table  class="table table-striped table-bordered bootstrap-datatable datatable stu-admission">
					 <tbody>
					<tr>
					<td><?php echo JText::_('COM_USERS_PROFILE_NAME_LABEL'); ?></td><td><?php echo $this->data->name; ?></td></tr>
					<tr><td>	<?php echo JText::_('COM_USERS_PROFILE_USERNAME_LABEL'); ?></td><td><?php echo htmlspecialchars($this->data->username); ?></td></tr>
					<tr><td>	<?php echo JText::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?></td><td><?php echo JHtml::_('date', $this->data->registerDate); ?></td></tr>
					<tr><td>	<?php echo JText::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?></td>
					<?php if ($this->data->lastvisitDate != '0000-00-00 00:00:00'){?>
					<td> 	<?php echo JHtml::_('date', $this->data->lastvisitDate); ?></td>
					<?php }
							else {?>
						<td><?php echo JHtml::_('date', $this->data->lastvisitDate); ?></td>
								<?php } ?>
					</tr>
					</tbody>
					</table>
				</div>
				</div><!--/span-->
			</div>

