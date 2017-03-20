
<?php /**  * @copyright	Copyright (C) 2014 yahwehsolutions.com - All Rights Reserved. **/
defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'YOURBASEPATH', dirname(__FILE__) );

?>
<?php include (YOURBASEPATH.DS . "/modules/req_parameters.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<?php require(YOURBASEPATH . DS . "/modules/req_css.php"); ?>
<?php
$iconsDir = JURI::base() . 'components/com_cce/images/logo';
 JFactory::getDocument()->addStyleSheet(JURI::root().'templates/malita-fjt/css/styles.css');
 include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includecss.php');
?>
<?php if ($this->params->get( 'jscroll' )) : ?> <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/modules/jscroll.js"></script><?php endif; ?>
</head>
<?php
  	 	$dashboardlink= JRoute::_('index.php?option=com_cce&view=master&controller=master&layout=dashboard');
  	 	$principalportal= JRoute::_('index.php?option=com_cce&view=principal&controller=principal&layout=dashboard');
  	 	$classtimetable= JRoute::_('index.php?option=com_cce&view=timetable&controller=timetable&task=display&layout=classtimetable');
  	 	$stafftimetable= JRoute::_('index.php?option=com_cce&view=timetable&controller=timetable&task=display&layout=teachertimetable');
  	 	$institutetimetable= JRoute::_('index.php?option=com_cce&view=timetable&controller=timetable&task=display&layout=institutetimetable');
  	 	$studentsprofile= JRoute::_('index.php?option=com_cce&view=studentprofile&controller=studentprofile&layout=search&task=dispaly');
  	 	$grades= JRoute::_('index.php?option=com_cce&view=rshowcourseprofilenormal&controller=classreports&task=display');
			$user =& JFactory::getUser();
			$groups = $user->get('groups');
		?>
<!-- Attendence-->
<?php
		$abydate= JRoute::_('index.php?option=com_cce&view=attendancereports&controller=attendancereports&layout=absenteesbydate&task=display');
  	 	$todayab= JRoute::_('index.php?option=com_cce&view=attendancereports&controller=attendancereports&layout=todayabsentees&task=display');
		$regularwithp= JRoute::_('index.php?option=com_cce&view=attendancereports&controller=attendancereports&layout=regularabsenteeswithleave&task=display');
		$classattendance= JRoute::_('index.php?option=com_cce&view=attendancereports&controller=attendancereports&layout=classattendance&task=display');
  	 ?>

<body class="background <?php echo $maincol_sufix; ?>">
<div id="main">
  <div class="shadow">
    <div id="wrapper">
      <?php
				if($user->username)
				{
				?>
        <header id="main-header">
          <div class="container">
            <div class="row">
              <div class="span2" style="text-align:center;">
                <a href="<?php echo $dashboardlink; ?>" class="logo" style="background-image:url(<?php echo $iconsDir.'/isclogo.png'; ?>)"></a>
              </div>
              <div class="span8 h-group">
                <h1>MY SCHOOL NAME</h1>
                <address>Address 1, Street name, District name </address>
              </div>
              <div class="span2">
                <div class="credential-menu">
                  <span class="logo" style="background-image:url(<?php echo $iconsDir.'/isclogo.png'; ?>)"></span>
                </div>
              </div>
            </div>
          </div>
        </header>
      <!-- topbar starts -->
      <div class="navbar">
        <div class="navbar-inner">
        <!-- <div class="navbar-inner navbar-fixed-top"> -->
          <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> </a>
            <?php
               foreach($groups as $group) {
				if($group==9)
				{
                 ?>
            <!-- theme selector starts -->
            <div class="btn-group pull-right theme-container" > <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <i class="icon icon-color icon-user"></i><span class="hidden-phone"> Principal Menu</span> <span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li><a data-value="classic" href="<?php echo $classtimetable; ?>"><i class="icon icon-color icon-date"></i> Class Time Table </a></li>
                <li class="divider"></li>
                <li><a data-value="classic" href="<?php echo $stafftimetable; ?>"><i class="icon icon-color icon-calendar"></i> Staff Time Table </a></li>
                <li class="divider"></li>
                <li><a data-value="classic" href="<?php echo $institutetimetable; ?>"><i class="icon icon-color icon-calendar"></i> Institute Time Table </a></li>
                <li class="divider"></li>
                <li><a data-value="cerulean" href="<?php echo $studentsprofile; ?>"><i class="icon icon-color icon-users"></i> Student's Profile </a></li>
                <li class="divider"></li>
                <li><a data-value="redy" href="<?php echo $grades; ?>"><i class="icon icon-color icon-clipboard"></i> Grades</a></li>
              </ul>
            </div>
            <!-- theme selector ends -->
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
            <div class="btn-group pull-right theme-container" > <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <i class="icon icon-color icon-copy"></i><span class="hidden-phone"> Attendance</span> <span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li><a data-value="classic" href="<?php echo $abydate; ?>"><i class="icon icon-color icon-date"></i> Absentees By Date </a></li>
                <li class="divider"></li>
                <li><a data-value="classic" href="<?php echo $todayab; ?>"><i class="icon icon-color icon-comment-text"></i> Today Absentees </a></li>
                <li class="divider"></li>
                <li><a data-value="classic" href="<?php echo $regularwithp; ?>"><i class="icon icon-color icon-comment"></i> Regular Absentees with Permission </a></li>
                <li class="divider"></li>
                <li><a data-value="cerulean" href="<?php echo $classattendance; ?>"><i class="icon icon-color icon-clock"></i> Class Attendance Report </a></li>
              </ul>
            </div>
            <!-- attendance selector ends -->
            <?php
			 }
		 }
                 ?>
            <?php 
				$token = JUtility::getToken();
			//	$linkout = JRoute::_('index.php?option=com_users&task=user.logout');
				$linkout = JRoute::_("index.php?option=com_users&task=user.logout&".$token."=1");
				$profile = JRoute::_('index.php?option=com_users&view=profile&layout=edit&task=request');
				?>
            
            <!-- user dropdown starts -->
            
            <style>
            .login-greeting{
			float:left;
			margin-top:5px;
			}
			.logout-button{
			float:left;
			padding-left:10px;
			}
            </style>
            <div class="btn-group logout-page pull-right" >
              <jdoc:include type="modules" name="logout"  style="none" />
            </div>
            <!-- user dropdown ends -->
            
            <div class="top-nav nav-collapse">
              <ul class="nav">
              <!-- <li> <a href="<?php echo $dashboardlink; ?>">DashBoard</a></li> -->
                <?php
                 foreach($groups as $group) {
				if($group==9)
				{
                 ?>
                <li> <a href="<?php echo $principalportal; ?>">Principal Portal</a> </li>
                <?php
			 }
		 }
                 ?>
              </ul>

              <div id="nav">
		<jdoc:include type="modules" name="menu"  style="none" />
		 </div>
            </div>
            <!--/.nav-collapse --> 
          </div>
        </div>
      </div>
      <!-- topbar ends -->

      <?php }?>
      <?php include "html/com_content/archive/component.php"; ?>
  <?php
    if($user->username){
    ?>
  <?php if ($this->countModules('breadcrumb')) : ?>
    <ul class="breadcrumb">
      <jdoc:include type="modules" name="breadcrumb"  style="none" />
    </ul>
  
  <?php endif; }?>
  <!-- center content-->
  <div id="content">
	  <noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
  <div id="centercontent<?php echo $maincol_sufix; ?>">
  <div id="message">
    <jdoc:include type="message" />
  </div>
    <div class="clearpad">
      <jdoc:include type="component" />
    </div>
  </div>
  </div>
  <!--- To Top -->
  <div style="display:none;" class="nav_up" id="nav_up"></div>
  <!-- End --> 
<?php
				if($user->username)
				{
				?>
<div id="bottom">
  <div class="tg">
    <jdoc:include type="modules" name="copyright" />
    <!--	<a href="http://www.affiliatemarketingprofit.com" title="affiliate marketing" target="_blank">Affiliate Marketing</a>. 
			<?php if ($this->params->get( 'footerdisable' )) : ?><?php echo ($footertext); ?><?php endif; ?>
			<?php if ($this->params->get( 'jcopyright' )) : ?><div class="panel">Copyright 2012</div><p class="flip">&copy;</p><?php endif; ?>--> 
  </div>
</div>
<?php
  }
?>
<div class="back-bottom"><!--shadow top--> </div>
<?php
 include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includejs.php');
?>
</body>
</html>
