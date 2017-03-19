<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        $iconsDir1 = JURI::base() . 'components/com_cce/images';
?>
  <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/smsqueue.png'; ?>" alt="" style="width: 44px; height: 44px;" />
        </div>
        <div style="float:left;">
                <h1 class="item-page-title" style="font-size:15px; color:#991122;"><b>SMS Approval Queue</b></h1>
        </div>
<?php  echo $asmslist; ?>