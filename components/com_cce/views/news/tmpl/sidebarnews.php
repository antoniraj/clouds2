<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';

   $model =   & $this->getModel();
   $model->getSideBarNews($rec);


?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/sidebarnews.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Sidebar News Items</h1>
        </div>
</div>
<hr /> <br />


<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
        <table>
                <tr>
                        <td>News Text 1:</td>
                        <td>
                                <input type="text" id="newstext1" name="newstext1" size="52" maxlength="255" value="<?php echo $rec->newstext; ?>" />
                        </td>
		</tr>
<tr><td><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
        </table>
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="controller" name="controller" value="news" />
        <input type="hidden" id="view" name="view" value="news" />
        <input type="hidden" name="task" id="task" value="updatetopnews" />
</form>


