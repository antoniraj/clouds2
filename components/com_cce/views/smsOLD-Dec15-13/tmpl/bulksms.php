<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
        $model = & $this->getModel();
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Master');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);
?>

<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/bulksms.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title">Students Bulk SMS</h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1sms.png'; ?>" alt="Bulk SMS" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>
<br />
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table>
		<tr>
			<td>SMS Message</td>
			<td>
			<?php
                                $editor =& JFactory::getEditor();
                                $params = array( 'smilies'=> '0' ,
                                 'style'  => '1' ,
                                 'layer'  => '0' ,
                                 'table'  => '0' ,
                                 'clear_entities'=>'0'
                                 );
                                echo $editor->display( 'smstext', $this->rec->smstext, '200', '200', '20', '20', false, null, null, null, $params );
                        ?>

			</td>
		</tr>
		<tr><td><input type="submit" class="button_send" value="Send" id="submit" name="submit" /></td></tr>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="view" name="view" value="sms" />
	<input type="hidden" id="layout" name="layout" value="smsqueue" />
	<input type="hidden" id="controller" name="controller" value="sms" />
	<input type="hidden" name="task" id="task" value="logbulksms" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
</form>
