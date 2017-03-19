<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$sdid= JRequest::getVar('sdid');
	$ddid= JRequest::getVar('ddid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('timetable');
	$rs = $model->getDay($ddid,$rec);
	if($rs==false) {
		$rec->id = -1;
		$rec->code='';
		$rec->title='';
		$rec->start='';
		$rec->stop='';
	}

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Time Table');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
	$ddItemid = $model->getMenuItemid('manageschool','Day Orders');
        if($ddItemid) ;
        else{
                $ddItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
   	$sdlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=daycategory&sdid='.$sdid.'&Itemid='.$Itemid);
   	$ddlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=days&sdid='.$sdid.'&Itemid='.$Itemid);



?>
<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/addday.png'; ?>" alt="" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Add/Edit Day (Day Order)</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $sdlink; ?>"><img src="<?php echo $iconsDir.'/weekdays.png'; ?>" alt="Category" style="width: 32px; height: 32px;" /></a><br />
			</div>

                </td>
        </tr>
</table>

<br />
<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Add/Edit Session</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Day Title<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" required="required" id="focusedInput" name="title" type="text" value="<?php echo $rec->title; ?>">
								</div>
							  </div>
							     <div class="control-group">
								<label class="control-label" for="focusedInput">Day Code<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" required="required" id="focusedInput" name="code" type="text" value="<?php echo $rec->code; ?>">
								</div>
							  </div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Active?</label>
							  <div class="controls">
								<input data-no-uniform="true" type="checkbox" class="iphone-toggle" name="active" <?php if($rec->active=="1") echo 'checked="checked"'; ?> value="1">
								</div>
							</div>

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Add" value="Save">Save</button>
							</div>
						  </fieldset>
						  
												  
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="view" name="view" value="timetable" />
        <input type="hidden" id="controller" name="controller" value="timetable" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="sdid" id="sdid" value="<?php echo $sdid; ?>" />
        <input type="hidden" name="ddid" id="ddid" value="<?php echo $ddid; ?>" />
        <input type="hidden" name="task" id="task" value="saveday" />
        <input type="hidden" name="layout" id="layout" value="days" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

</form>


