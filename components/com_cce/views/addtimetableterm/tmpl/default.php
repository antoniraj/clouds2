<script type="text/javascript"language="javascript">
 
   function CompareDate() {
	  var startDate = new Date(document.getElementById("startdate").value);
    var endDate = new Date(document.getElementById("stopdate").value);

    if (startDate.getTime() > endDate.getTime())
    {
		 document.getElementById('startdate').value = "";
		  document.getElementById('stopdate').value = "";
        alert ("Start date cannot be greater than end date");
    }
    }
 
</script>

<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('timetable');

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

   	$atItemid = $model->getMenuItemid('master','Time Table Terms');
   	if($atItemid) ;
   	else{
        	$atItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);

  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetableterms&view=timetableterms&task=display&Itemid='.$atItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/timetableterms.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Add/Edit Time Table Term</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $atlink; ?>"><img src="<?php echo $iconsDir.'/timetableterms.png'; ?>" alt="Terms" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Time Table Term</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
		                    
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Term Code<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" id="focusedInput"  required="required" name="code" type="text" value="<?php echo $this->rec->code; ?>">
								</div>
							  </div>
							    <div class="control-group">
								<label class="control-label" for="focusedInput">Description<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" id="focusedInput"  required="required" name="term" type="text" value="<?php echo $this->rec->term; ?>">
								</div>
							  </div>
							<div class="control-group">
							  <label class="control-label" for="date01">Start Date<span class="mandatory">*</span></label>
							  <div class="controls">
								<input type="text" class="datepicker"  required="required" onChange="CompareDate();" id="startdate" name="startdate" value="<?php echo JArrayHelper::indianDate($this->rec->startdate); ?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">End Date<span class="mandatory">*</span></label>
							  <div class="controls">
								<input type="text" class="datepicker"  required="required" onChange="CompareDate();"  id="stopdate" name="stopdate" value="<?php echo JArrayHelper::indianDate($this->rec->stopdate); ?>">
							  </div>
							</div>
							
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
							</div>
						  </fieldset>
						  
						  
		<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
	<input type="hidden" id="view" name="view" value="addtimetableterm" />
	<input type="hidden" id="controller" name="controller" value="timetableterms" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="task" id="task" value="save" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

</form>




