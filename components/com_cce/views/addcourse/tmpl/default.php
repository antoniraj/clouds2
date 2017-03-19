<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

   	$model = & $this->getModel('cce');

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$courseItemid = $model->getMenuItemid('master','Courses');
        if($courseItemid) ;
        else{
                $courseItemid = $model->getMenuItemid('topmenu','Manage School');
        }

   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$clink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=courses&task=display&Itemid='.$courseItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->

<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i> Add/Edit Courses</h2>
    </div>
    <div class="box-content">
      <form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">
        <fieldset>
         <div class="control-group">
            <label class="control-label" for="focusedInput">Course Name<span class="mandatory">*</span></label>
            <div class="controls">
              <input class="input-xlarge focused" id="focusedInput" required="required" name="coursename" type="text" value="<?php echo $this->rec->coursename; ?>">
            </div>
          </div>
         <div class="control-group">
            <label class="control-label" for="focusedInput">Course Code<span class="mandatory">*</span></label>
            <div class="controls">
              <input class="input-xlarge focused" id="focusedInput" required="required" name="code" type="text" value="<?php echo $this->rec->code; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="focusedInput">Section Name<span class="mandatory">*</span></label>
            <div class="controls">
              <input class="input-xlarge focused" id="focusedInput" required="required" name="sectionname" type="text" value="<?php echo $this->rec->sectionname; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="focusedInput">Assessment Type<span class="mandatory">*</span></label>
            <div class="controls">
            <select id="assessmenttype" name="assessmenttype">
                                <option value="">Select</option>
                                <option value="Normal" <?php if($this->rec->assessmenttype=="Normal") echo 'selected="selected"'; ?>>  Normal</option>
                                <option value="CCE" <?php if($this->rec->assessmenttype=="CCE") echo 'selected="selected"'; ?>>  CCE</option>
                           </select>
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="focusedInput">Course Number<span class="mandatory">*</span></label>
            <div class="controls">
              <input class="input-xlarge focused" id="focusedInput" required="required" name="courseno" type="text" maxlength="15" value="<?php echo $this->rec->courseno; ?>">
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
          </div>
        </fieldset>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
	<input type="hidden" id="controller" name="controller" value="courses" />
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" id="view" name="view" value="addcourse" />
	<input type="hidden" name="task" id="task" value="save" />
      </form>
    </div>
  </div>
  <!--/span--> 
  
</div>
<!--/row-->

