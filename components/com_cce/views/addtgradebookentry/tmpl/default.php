<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
    $iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$Itemid = JRequest::getVar('Itemid');
	 	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
	$viewmodule= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=tgradebook&view=tgradebook&task=display&Itemid='.$masterItemid);

?>

<div class="row-fluid">
<div class="span6"> 
   <div class="row-fluid">
   <div class="span1">
     <img src="<?php echo $iconsDir.'/gradebooktemplate.png'; ?>" alt="Dash Board" style="width: 38px; height: 38px;" />

   </div>
   <div class="span6">
    <h1>Add Grade-Book Entry</h1>
   </div>
   </div>
 </div>
<div class="span6" align="right">
    <a href="<?php echo $viewmodule; ?>"><img src="<?php echo $iconsDir.'/gradebooktemplate.png'; ?>" alt="Grades" style="width: 38px; height: 38px;" /></a> 

   <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir.'/1results.png'; ?>" alt="Grades" style="width: 38px; height: 38px;" /></a> 

     <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 38px; height: 38px;" /></a> 
   
</div>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i>Add Grade-Book Entry</h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="focusedInput">Title</label>
            <div class="controls">
              <input class="input-xlarge focused" id="focusedInput" name="title" type="text" value="<?php echo $this->rec->title; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="focusedInput">Short Code</label>
            <div class="controls">
              <input class="input-xlarge focused" id="focusedInput" name="code" type="text" value="<?php echo $this->rec->code; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="focusedInput">Weightage</label>
            <div class="controls">
              <input class="input-xlarge focused" id="focusedInput" name="weightage" type="text" value="<?php echo $this->rec->weightage; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="date01">Number of Best sub-categories for the Weightage</label>
            <div class="controls">
          <select id="bestof" name="bestof">
          <?php
						if($this->rec->bestof==0) $this->rec->bestof='All';
					?>
          <option value="<?php echo $this->rec->bestof;  ?>"><?php echo $this->rec->bestof; ?></option>
          <option value="0">All</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
        </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="focusedInput">Description</label>
            <div class="controls">
              <input class="input-xlarge focused" id="focusedInput" name="description" type="text" value="<?php echo $this->rec->description; ?>">
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="focusedInput">Group Tag for Grading</label>
            <div class="controls">
              <input class="input-xlarge focused" id="focusedInput" name="grouptag" type="text" value="<?php echo $this->rec->grouptag; ?>">
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="focusedInput">Group SNO</label>
            <div class="controls">
         
		<select id="gsno" name="gsno">
          <option value="<?php echo $this->rec->gsno;  ?>"><?php echo $this->rec->gsno; ?></option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
        </select>             </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
            <button type="reset" class="btn">Cancel</button>
          </div>
        </fieldset>
     <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
  <input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
  <input type="hidden" id="controller" name="controller" value="tgradebook" />
  <input type="hidden" id="view" name="view" value="addtgradebookentry" />
  <input type="hidden" name="task" id="task" value="save" />
  <input type="hidden" name="subjectid" id="subjectid" value="<?php echo $this->subjectid; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
      </form>
    </div>
  </div>
  <!--/span--> 
  
</div>
<!--/row-->


