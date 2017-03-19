

<?php
        defined('_JEXEC') or die('Denied..');
	$app = JFactory::getApplication();
	$iconsdir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$day  = JRequest::getVar('day');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
   	$model = & $this->getModel('news');
   	$model->editthoughts($day,$rec);
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=news&Itemid='.$masterItemid);

  	$thoughts= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=news&view=thoughtsfortheday&task=display&Itemid='.$ayItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/t_thoughts.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Edit Thoughts </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1news.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $thoughts; ?>"><img src="<?php echo $iconsDir1.'/t_thoughts.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
			</div>
                </td>
        </tr>
</table>

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Edit Thoughts</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
										 
							<div class="control-group">
							  <label class="control-label" for="date01">Day<span class="mandatory">*</span></label>
							  <div class="controls">
								<input type="text" class="disabled" disabled="" id="date01" value="<?php echo $rec->day; ?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Thought<span class="mandatory">*</span></label>
							  <div class="controls">
							  
							  <textarea name="message"placeholder="Fill with a quote..." maxlength="340" rows="12" onkeyup="counter(this);"><?php echo $rec->message; ?></textarea>
								<div id="counter_div">0/340</div>
								  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Reference<span class="mandatory">*</span></label>
							  <div class="controls">
								<input type="text" class="focusinput"  required="required" id="date01" name="reference" value="<?php echo $rec->reference; ?>">
							  </div>
							</div>
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
							</div>
						  </fieldset>
						  
						  
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
	<input type="hidden" id="id" name="t_days" value="<?php echo $rec->day; ?>" />
	<input type="hidden" id="view" name="view" value="thoughtsfortheday" />
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" id="controller" name="controller" value="news" />
	<input type="hidden" name="task" id="task" value="updatethoughtsfortheday" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

</form>
<script>
    function counter(msg){
        document.getElementById('counter_div').innerHTML = msg.value.length+'/340';
    }
</script>