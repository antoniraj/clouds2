<?php
        defined('_JEXEC') OR DIE('Access denied..');
	JHtml::_('behavior.tooltip');
	JHtml::_('behavior.formvalidation');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/managesubjects.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Add/Edit Subject Details</h1>
        </div>
</div>

<hr /> <br />
<form action="index.php" method="POST" name="addform" class="form-validate" id="addform" onSubmit="return stest()">
        <table>
                <tr>
                        <td>Subject Title<font color="red">*</font></td>
                        <td>
                                <input type="text" id="subjecttitle" name="subjecttitle" size="32" maxlength="50" value="<?php echo $this->rec->subjecttitle; ?>" />
                        </td>
                </tr>
                <tr>
                        <td>Subject Code<font color="red">*</font></td>
                        <td>
                        <input type="text" id="subjectcode"  name="subjectcode" size="32" maxlength="15" value="<?php echo $this->rec->subjectcode;  ?>" />
                        </td>
                </tr>
                <tr>
                        <td>Acronym<font color="red">*</font></td>
                        <td>
                        <input type="text" id="acronym" name="acronym" size="32" maxlength="10" value="<?php echo $this->rec->acronym;  ?>" />
                        </td>
                </tr>
                <tr>
                        <td>Credits OR Hours/Week<font color="red">*</font></td>
                        <td>
                        <input type="text" id="credits" name="credits" size="32" maxlength="10" class="required validate-numeric" value="<?php echo $this->rec->credits;  ?>" />
                        </td>
                </tr>
                <tr><td><input type="submit" class="button_save validate" value="Save" id="submit" name="submit" /></td></tr>
        </table>
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
        <input type="hidden" id="controller" name="controller" value="managesubjects" />
        <input type="hidden" id="view" name="view" value="managesubjects" />
        <input type="hidden" name="task" id="task" value="save" />
</form>

