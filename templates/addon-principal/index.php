<?php /**  * @copyright	Copyright (C) 2012 ThemeGoat.com - All Rights Reserved. **/
defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'YOURBASEPATH', dirname(__FILE__) );
?>
<?php include (YOURBASEPATH.DS . "/modules/req_parameters.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<?php require(YOURBASEPATH . DS . "functions.php"); ?>
<?php require(YOURBASEPATH . DS . "/modules/req_css.php"); ?>
<?php
 include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includecss.php');
  include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'controller'.DS.'helper.php');
?>
  <?php
  	 	$dashboardlink= JRoute::_('index.php?option=com_cce&view=master&controller=master&layout=dashboard');
  	 	$principalportal= JRoute::_('index.php?option=com_cce&view=principal&controller=principal&layout=dashboard');
  	 	$timetable= JRoute::_('index.php?option=com_cce&view=timetable&controller=timetable&task=display&layout=teachertimetable');
  	 	$studentsprofile= JRoute::_('index.php?option=com_cce&view=principal&controller=principal&layout=dashboard');
  	 	$grades= JRoute::_('index.php?option=com_cce&view=principal&controller=principal&layout=dashboard');
			$user =& JFactory::getUser();
			$groups = $user->get('groups');
?>
<body class="background <?php echo $maincol_sufix; ?>">

<div id="main">
  <div class="shadow">
    <div id="wrapper">
      <?php
			
				if($user->username)
				{
				?>
      <!-- topbar starts -->

      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container-fluid"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="<?php echo $dashboardlink; ?>"> <img alt="" src="img/logo20.png" /> <span>Addon</span></a> 
            
            <!-- theme selector starts -->

            <!-- theme selector ends -->
            <?php 
				$token = JUtility::getToken();
				$linkout = JRoute::_("index.php?option=com_users&task=user.logout&".$token."=1");
				$profile = JRoute::_('index.php?option=com_users&view=reset&layout=default&task=request');
				?>
                 <?php
                 foreach($groups as $group) {
				if($group==9)
				{
                 ?>
               	<!-- principal menu selector starts -->
				<div class="btn-group pull-right theme-container" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon icon-color icon-user"></i><span class="hidden-phone"> Principal Menu</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" id="themes">
						<li><a data-value="classic" href="<?php echo $timetable; ?>"><i class="icon-blank"></i> Time Table</a></li>
						<li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Student's Profile</a></li>
						<li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Attendance Reports</a></li>
						<li><a data-value="redy" href="#"><i class="icon-blank"></i> Grades</a></li>
						<li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>
						<li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>
						<li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>
						<li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>
						<li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>
					</ul>
				</div>
				<!-- principal menu selector ends --> 
				                 <?php
			 }
		 }
                 ?>
                 
                      <?php
                 foreach($groups as $group) {
				if($group==9)
				{
                 ?>
               	<!-- attendance starts -->
				<div class="btn-group pull-right theme-container" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon icon-color icon-user"></i><span class="hidden-phone"> Principal Menu</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" id="themes">
						<li><a data-value="classic" href="<?php echo $timetable; ?>"><i class="icon-blank"></i> Time Table</a></li>
						<li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Student's Profile</a></li>
						<li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Attendance Reports</a></li>
						<li><a data-value="redy" href="#"><i class="icon-blank"></i> Grades</a></li>
						<li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>
						<li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>
						<li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>
						<li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>
						<li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>
					</ul>
				</div>
				<!-- attendance selector ends --> 
				                 <?php
			 }
		 }
                 ?>
                 
				
            <!-- user dropdown starts -->
            <div class="btn-group pull-right" > <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <i class="icon-user"></i><span class="hidden-phone"> <?php echo ' '.$user->username; ?></span> <span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $profile; ?>">Profile</a></li>
                <li class="divider"></li>
                <li><a href=”index.php?option=com_users&task=user.logout&<?php echo JUtility::getToken(); ?>=1″>Logout </a></li>
              </ul>
            </div>
            <!-- user dropdown ends -->
            
          
            <div class="top-nav nav-collapse">
              <ul class="nav">
                <li> <a href="<?php echo $dashboardlink; ?>">DashBoard</a></li>
                 <?php
                 foreach($groups as $group) {
				if($group==9)
				{
                 ?>
                 <li>
					<a href="<?php echo $principalportal; ?>">Principal Portal</a>
                 </li>
                 <?php
			 }
		 }
                 ?>
              </ul>
            </div>
            <!--/.nav-collapse --> 
            
          </div>
        </div>
      </div>
      <!-- topbar ends -->
      <?php
			}
				?>
      <?php include "html/com_content/archive/component.php"; ?>
  <?php
				$user =& JFactory::getUser();
				if($user->username)
				{
	?>
  <?php if ($this->countModules('breadcrumb')) : ?>
  <div>
    <ul class="breadcrumb" style="margin-top:50px;">
      <jdoc:include type="modules" name="breadcrumb"  style="none" />
    </ul>
  </div>
  <?php endif; 
        }?>
  <div id="message">
    <jdoc:include type="message" />
  </div>
  
  <!-- center content-->
  <div id="centercontent<?php echo $maincol_sufix; ?>">
    <div class="clearpad">
      <jdoc:include type="component" />
    </div>
  </div>
 
<!--- To Top -->
<div style="display:none;" class="nav_up" id="nav_up"></div>
<!-- End -->
</div>
<?php
				$user =& JFactory::getUser();
				if($user->username)
				{
				?>
<div id="bottom">
  <div class="tg">
    <jdoc:include type="modules" name="copyright"/>
    <!--	<a href="http://www.affiliatemarketingprofit.com" title="affiliate marketing" target="_blank">Affiliate Marketing</a>. 
			<?php if ($this->params->get( 'footerdisable' )) : ?><?php echo ($footertext); ?><?php endif; ?>
			<?php if ($this->params->get( 'jcopyright' )) : ?><div class="panel">Copyright 2012</div><p class="flip">&copy;</p><?php endif; ?>--> 
  </div>
</div>
<?php
				}
?>
</div>
<div class="back-bottom"><!--shadow top--> </div>
</div>
</div>
<?php
 include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includejs.php');
?>
</body>
</html>
