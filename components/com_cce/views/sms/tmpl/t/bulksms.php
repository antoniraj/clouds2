<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/bulksms.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Send Bulk SMS</h1>
        </div>
</div>
<hr /> <br />
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
		<tr><td><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="view" name="view" value="sms" />
	<input type="hidden" id="layout" name="layout" value="smsqueue" />
	<input type="hidden" id="controller" name="controller" value="sms" />
	<input type="hidden" name="task" id="task" value="logbulksms" />
</form>
