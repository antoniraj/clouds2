<?php // no direct access 
/**
 * @package                Template for joomla
 * @copyright        Copyright (C) 2012 a4joomla.com
 * @license                GNU General Public License version 2 or later
 */
defined( '_JEXEC' ) or die( 'Restricted access' ); 
$showLeftColumn = (bool) $this->countModules('position-7');
$showRightColumn = (bool) $this->countModules('position-6');
$showRightColumn &= JRequest::getCmd('layout') != 'edit';

$headerType = $this->params->get("headerType","1");
$myimage = $this->params->get("myimage","darksunset1.jpg");
$myfolder = $this->params->get("myfolder","sampledata");
$duration = $this->params->get("duration","800");
$delay = $this->params->get("delay","4000");
$imageWidth = $this->params->get("imageWidth","940");
$imageHeight = $this->params->get("imageHeight","380");
$forceresize = $this->params->get("forceresize","0");
$showControl = $this->params->get("showControl", "true");
$display = $this->params->get("display","sequence");
$arrowColor = $this->params->get("arrowColor","white");

$frontpagediv="0";
if ($headerType == "0" || $headerType == "1") {
	$lang =& JFactory::getLanguage();
	$locale = $lang->getTag();
	$menu = JSite::getMenu();
	if ($menu->getActive() == $menu->getDefault($locale)) {
		$frontpagediv="1";
	} 
} elseif ($headerType == "2" || $headerType == "3") {
	$frontpagediv="1";
}

$imgrootdir = "templates/".$this->template."/images/";
$margin = 40;
$outermargin = 0;
$logoText	= $this->params->get("logoText","DARKSUNSET");
$slogan	= $this->params->get("slogan","Joomla template from a4joomla.com");
$mytwitter = $this->params->get("myTwitter", "Yes");
$twitterurl = $this->params->get("twitterUrl");
$myfacebook = $this->params->get("myFacebook", "Yes");
$facebookurl = $this->params->get("facebookUrl");
$myfeed = $this->params->get("myFeed", "Yes");
$feedurl = $this->params->get("feedUrl");
$mygoogle = $this->params->get("myGoogle", "Yes");
$googleurl = $this->params->get("googleUrl");
$myyoutube = $this->params->get("myYoutube", "Yes");
$youtubeurl = $this->params->get("youtubeUrl");
$pageWidth	= $this->params->get("pageWidth", "980");
$pageWidth	= $pageWidth - $outermargin;
$rightColumnWidth	= $this->params->get("rightColumnWidth", "190");
$leftColumnWidth	= $this->params->get("leftColumnWidth", "190");
$logoWidth	= $this->params->get("logoWidth", "260");

$widthdiff = 40;
if ($forceresize == "1") {
	$imageHeight = round($imageHeight * ($pageWidth + $outermargin - $widthdiff) / $imageWidth);
	$imageWidth = $pageWidth + $outermargin - $widthdiff;
}
$controlPosition = 50 - 2500/$imageHeight;

$headerrightWidth = $pageWidth + $outermargin - $logoWidth - 60;

if ($showLeftColumn && $showRightColumn) {
   $contentWidth = $pageWidth - $leftColumnWidth - $rightColumnWidth - 3*$margin;
} elseif (!$showLeftColumn && $showRightColumn) {
   $contentWidth = $pageWidth - $rightColumnWidth - 2*$margin ;
} elseif ($showLeftColumn && !$showRightColumn) {
   $contentWidth = $pageWidth - $leftColumnWidth - 2*$margin ;
} else {
   $contentWidth = $pageWidth - $margin ;
}
JHTML::_('behavior.framework', true);  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >

<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/color1.css" type="text/css" />
<!--[if IE 6]>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie6.css" type="text/css" />
<style type="text/css">
img, div, a, input { behavior: url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/iepngfix.htc) }
#search input.inputbox { behavior:none;}
</style>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/iepngfix_tilebg.js" type="text/javascript"></script>
<![endif]-->
<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie67.css" type="text/css" />
<![endif]-->
<!--[if lte IE 8]>
<style type="text/css">
#search input.inputbox { behavior: url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/PIE.php) }
</style>
<![endif]-->
<style type="text/css">
 #logo {
    width:<?php echo $logoWidth; ?>px;
 }
 #headerright {
    width:<?php echo $headerrightWidth; ?>px;
 } 
 #slideshow-container {
	width:<?php echo $pageWidth + $outermargin - $widthdiff; ?>px;
	height:<?php echo $imageHeight; ?>px;
 }
 #slideshow-container img { 
	width:<?php echo $imageWidth; ?>px; 
	height:<?php echo $imageHeight; ?>px;
 }
 #slcontrol {
	width:<?php echo $imageWidth; ?>px; 
	top:<?php echo $controlPosition; ?>%;
 }
 a#slprev {
    background: url("<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/previous-<?php echo $arrowColor; ?>.png") no-repeat scroll left center transparent;
 }
 a#slnext {
    background: url("<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/next-<?php echo $arrowColor; ?>.png") no-repeat scroll right center transparent;
 }
</style>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/verysimpleslideshow.js" type="text/javascript"></script>
<?php if (($headerType == "1" || $headerType == "3") && $frontpagediv == "1") : ?>
<script type="text/javascript">
window.addEvent('domready',function() {
	var slideshow = new VerySimpleSlideshow({
		container: 'slideshow-container',
		elements: '#slideshow-container img',
		showControls: <?php echo $showControl; ?>,
		transDelay: <?php echo $delay; ?>,
		transDuration: <?php echo $duration; ?>
	});
	slideshow.start();  
});
</script>
<?php endif; ?>
</head>
<body>

<div id="headerwrap" class="gainlayout">
	<div id="header" class="gainlayout" style="width:<?php echo $pageWidth + $outermargin; ?>px;">   
      <div id="logo" class="gainlayout">
         	<h2><a href="<?php echo JURI::base(); ?>" title="<?php echo htmlspecialchars($logoText); ?>"><?php echo htmlspecialchars($logoText); ?></a></h2>
			<h3><?php echo htmlspecialchars($slogan); ?></h3> 
      </div>
	  <div id="headerright" class="gainlayout">
	    <div id="hsocial" class="gainlayout">
			<?php if($this->countModules('position-0')) : ?>
				<div id="search" class="gainlayout">
					<jdoc:include type="modules" name="position-0" style="xhtml" /> 
				<div class="clr"></div>  
				</div>
			<?php endif; ?>
			<div class="clr"></div>
		</div>	
        <div class="clr"></div>
      </div>
      <div class="clr"></div>
	</div>
</div>


<?php if ($frontpagediv == "1" && $headerType != "4") {?>
	<div id="slideshow-allwrap">
	  <div id="slideshow-container">
		<?php
		$imgrootdir = "templates/".$this->template."/images/";
		if ($headerType == "0" || $headerType == "2") {
			echo '<img src="'.$imgrootdir.$myimage.'" alt="" />';
		} elseif ($headerType == "1" || $headerType == "3") {
			$picDir= $imgrootdir.$myfolder;
			$picDir .="/";
			if (file_exists($picDir) && is_readable($picDir)) {
				$folder = opendir($picDir);
			} else {
				echo '<div class="message">Error! Please check the parameter settings and make sure you have entered a valid image folder path!</div>';
				return;
			}
			$allowed_types = array("jpg","JPG","jpeg","JPEG","gif","GIF","png","PNG","bmp","BMP");
			$index = array();
			while ($file = readdir ($folder)) {
				if(in_array(substr(strtolower($file), strrpos($file,".") + 1),$allowed_types)) {array_push($index,$file);}
			}
			closedir($folder);
			if($display == 'random') {shuffle($index);} else {sort($index);}

			foreach ($index as $file) {
				$finalpath = $picDir.$file;	
				// output
				echo '<img src="'.$finalpath.'" alt="'.$file.'" />';
			}
			if ($showControl) echo '<div id="slcontrol"> </div>';
		}
		?>
	  </div>
	</div>
<?php } ?> 

<div id="allwrap" class="gainlayout">

<div id="wrap" class="gainlayout" style="width:<?php echo $pageWidth + $outermargin; ?>px;">

  <?php if($this->countModules('position-2')) : ?>
	  <div id="pathway" class="gainlayout">
        <jdoc:include type="modules" name="position-2" />
      <div class="clr"></div>
	  </div>
  <?php endif; ?> 
  <div id="cbody" class="gainlayout">
  <?php if($showLeftColumn) : ?>
  <div id="sidebar" style="width:<?php echo $leftColumnWidth; ?>px;">     
      <jdoc:include type="modules" name="position-7" style="xhtml" />    
  </div>
  <?php endif; ?>
  <div id="content60" style="width:<?php echo $contentWidth; ?>px;">    
      <div id="content" class="gainlayout">
		<jdoc:include type="message" />
		<jdoc:include type="component" /> 
      </div> 
  </div>
  <?php if($showRightColumn) : ?>
  <div id="sidebar-2" style="width:<?php echo $rightColumnWidth; ?>px;">     
      <jdoc:include type="modules" name="position-6" style="xhtml" />     
  </div>
  <?php endif; ?>
  <div class="clr"></div>
  </div>
  
<!--end of wrap-->
</div>
    
<!--end of allwrap-->
</div>
<div id="footerwrap" class="gainlayout"> 
  <div id="footer" class="gainlayout" style="width:<?php echo $pageWidth + $outermargin; ?>px;">  
       <?php if($this->countModules('position-14')) : ?>	
         <jdoc:include type="modules" name="position-14" style="xhtml" />    
       <?php endif; ?>
  </div>
  <div id="a4j" style="width:<?php echo $pageWidth + $outermargin; ?>px;"><a href="http://a4joomla.com/"><?php echo JText::_('TPL_A4JOOMLA-DARKSUNSET-FREE_FOOTER_LINK_TEXT');?></a></div>  
</div>


</body>
</html>
