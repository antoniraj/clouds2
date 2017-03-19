<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.noframes');
$logo = "components/com_cce/";
$schoolconfig=JArrayHelper::getSchoolInfo();
			$app = JFactory::getApplication();
			$user =& JFactory::getUser();
			$groups = $user->get('groups');
			foreach($groups as $group) {
			if($group==9)
				{
			  $app->redirect(JRoute::_('index.php?option=com_cce&view=principal&controller=principal&layout=default', false));
			    }
			else if($group==10){
		    	$app->redirect(JRoute::_('index.php?option=com_cce&controller=teacherlogin&view=teacherlogin&task=display&layout=default', false));
				}
			else if($group==11){
				$app->redirect(JRoute::_('index.php?option=com_cce&controller=master&view=master&task=display&layout=dashboard', false));
			
				}
			else if($group==12){
				$app->redirect(JRoute::_('index.php?option=com_cce&controller=parentlogin&view=parentlogin&task=display&layout=dashboard', false));
			
				}
			else if($group==13){
				$app->redirect(JRoute::_('index.php?option=com_cce&controller=master&view=treasurer&task=display', false));
			
				}
			else {
				$data['remember'] = (int)$options['remember'];
				$app->setUserState('users.login.form.data', $data);
				$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
				}
			}
?>
<script>
$(function(){
    $("#name").focus();
});
</script>
<div id="login_page">
  <div class="login_header">
    <h2 align="center" style="color:#1960c9; font-size:32px; margin:0; padding:0;">ADDON</h2>
    <p>School Management Software</p>
  </div>
  <div class="usr-details">
    <h2><?php echo $schoolconfig->schoolname; ?></h2>
    <p><?php echo $schoolconfig->schooladdress; ?></p>
  </div>
  <div class="login-panel">
    <div class="login_inner">
      <div class="login_theme">
        <?php if($schoolconfig->logo){?>
        <img src="<?php echo $logo.'schoollogo/'.$schoolconfig->logo; ?>" class="profile-img" alt="<?php echo $schoolconfig->schoolname; ?>">
        <?php }else{ ?>
        <img src="<?php echo $logo.'no-image/school-logo.png'; ?>" class="profile-img" alt="<?php echo $schoolconfig->schoolname; ?>">
        <?php } ?>
        <form accept-charset="UTF-8" name="login" role="form" id="regitstraion_form"  action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
          <div class="login_form">
            <input name="username" value="" id="name" type="text" tabindex="1" placeholder="Username"  id="user-name">
            <input name="password" value="" id="password" type="password"  placeholder="Password" id="user-pw">
            <input class="login_btn blue_lgel" name="submit" value="Login" type="submit">
            <ul class="login_opt_link">
              <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
              <li><?php echo JHtml::_('form.token'); ?> <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"> <?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a></li>
              <li class="remember_me right">
                <input class="rem_me" <?php if (!JPluginHelper::isEnabled('system', 'remember')): ?> disabled="disabled" <?php endif; ?> id="modlgn_remember" type="checkbox" name="remember" class="inputbox" value="yes" title="<?php echo JText::_('MOD_CDLOGIN_REMEMBER_ME') ?>" alt="<?php echo JText::_('MOD_CDLOGIN_REMEMBER_ME') ?>" checked="checked" />
                Remember Me</li>
            </ul>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php /*?><div id="login_page">
  <div class="login_container">
    <div class="login_header">
      <h2 align="center" style="color:#1960c9; font-size:40px; margin:0; padding:0;">ADDON</h2>
      <p>School Management Software</p>
    </div>
    <div class="login_inner">
      <div class="login_theme">
        <div class="grid_container">
          <div class="grid_3"> dffds </div>
          <div class="grid_9">
            <h3><?php echo $schoolconfig->schoolname; ?></h3>
          </div>
        </div>
        <form accept-charset="UTF-8" role="form" id="regitstraion_form"  action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
          <div class="login_form"> 
            <!--<h3 class="blue_d">Admin Login</h3>-->
            <ul>
              <li class="login_user">
                <input name="username" value="" id="name" type="text" tabindex="1" placeholder="Username" lass="required">
              </li>
              <li class="login_pass">
                <input name="password" value="" id="password" type="password" lass="required" placeholder="Password">
              </li>
            </ul>
          </div>
          <input class="login_btn blue_lgel" name="submit" value="Login" type="submit">
          <ul class="login_opt_link">
            <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
            <li><?php echo JHtml::_('form.token'); ?> <a class="small" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"> <?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a></li>
            <li class="remember_me right">
              <input class="rem_me" <?php if (!JPluginHelper::isEnabled('system', 'remember')): ?> disabled="disabled" <?php endif; ?> id="modlgn_remember" type="checkbox" name="remember" class="inputbox" value="yes" title="<?php echo JText::_('MOD_CDLOGIN_REMEMBER_ME') ?>" alt="<?php echo JText::_('MOD_CDLOGIN_REMEMBER_ME') ?>" checked="checked" />
              Remember Me</li>
          </ul>
        </form>
      </div>
    </div>
  </div>
</div><?php */?>
<!--<div class="login-footer-bar">
  <div class="footer">
    <ul class="list-inline">
      <li><a target="_blank" href="#">About ADDON</a></li>
      <li><a target="_blank" href="#">Privacy</a></li>
      <li><a target="_blank" href="#">Help </a> </li>
    </ul>
  </div>
</div>-->
