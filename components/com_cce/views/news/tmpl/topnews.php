<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';

   $model =   & $this->getModel();
   $model->getTopNews($rec);


?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/topnews.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Top News</h1>
        </div>
</div>
<hr /> <br />


<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
        <table>
                <tr>
                        <td>News Text:</td>
			 <td>
			<?php
                		$editor =& JFactory::getEditor();
				$params = array( 'smilies'=> '0' ,
	                	 'style'  => '1' ,
        		         'layer'  => '0' ,
        	        	 'table'  => '0' ,
		                 'clear_entities'=>'0'
        		         );
				echo $editor->display( 'newstext', $rec->newstext, '200', '200', '20', '20', false, null, null, null, $params );
                        ?>

                        </td>
                      </td>
		</tr>
<tr><td colspan="2" align="right"><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
        </table>
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="controller" name="controller" value="news" />
        <input type="hidden" id="view" name="view" value="news" />
        <input type="hidden" name="task" id="task" value="updatetopnews" />
</form>


