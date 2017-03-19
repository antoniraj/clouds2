<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$Itemid = JRequest::getVar('Itemid');
	$gbeid= JRequest::getVar('gbeid');
	$gbid= JRequest::getVar('gbid');
	
   	$model = & $this->getModel('exams');

	if(isset($gbeid)) {
		$htitle="Edit Grade Book Entry";
		$task = "updategradebookentry";
		$model->getTGradeBookEntry($gbeid,$rec);
	}else{
		$htitle ="Add Grade Book Entry";
		$task = "savegradebookentry";
		$rec->title='';
		$rec->code='';
		$rec->marks='';
	//	$rec->required='';
		$rec->description='';
		$rec->duedate=date('d-m-Y');
	}

	
	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
   	$close= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=exams&view=exams&task=display&layout=gradebooks&gbid='.$gbid.'&Itemid='.$Itemid);

?>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=savegradebookentry&id='.$rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i><?php echo $htitle; ?></h2>
			<div class="box-icon">
				<button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
				<a class="btn btn-small btn-warning" style="width:50px;" href="<?php echo $close; ?>"><i class="icon-minus-sign"></i>Cancel</a>
			</div>
		</div>
		<div class="box-content">
			<div style="float:left;">
			<fieldset>
                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">ID</label>
                                        <div class="controls">
						<?php echo $gbeid; ?>
                                        </div>
                                </div>

				<div class="control-group">
					<label class="control-label" for="focusedInput">Title</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" required name="title" type="text" value="<?php echo $rec->title; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Short Code</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" name="code" required type="text" value="<?php echo $rec->code; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Marks/Weightage</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" name="marks" required type="text" value="<?php echo $rec->weightage; ?>">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="date01">Due Date</label>
					<div class="controls">
						<input type="text" class="input-xlarge datepicker" id="date01" name="duedate" value="<?php echo JArrayHelper::indianDate($rec->duedate); ?>">
					</div>
				</div>
<!--
				<div class="control-group">
					<label class="control-label" for="focusedInput">Required Entry?</label>
					<div class="controls">
						<select id="selectError6" data-rel="chosen" name="required">
							<option value="1" <?php if($rec->required=="1") echo 'selected="selected"'; ?>>Yes</option>
							<option value="0" <?php if($rec->required=="0") echo 'selected="selected"'; ?>>No</option>
						</select>
					</div>
				</div>
-->
                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Group Serial Number</label>
                                        <div class="controls">
                                                <input class="input-xlarge focused" id="focusedInput" name="gsno" type="text" value="<?php echo $rec->gsno; ?>">
                                        </div>
                                </div>

				<div class="control-group">
					<label class="control-label" for="focusedInput">Parent Subject</label>
					<div class="controls">
						<select id="selectError5" data-rel="chosen" name="parentid">
							<option value="">No Parent</option>
						<?php
							$psubs = $model->getTGradeBookEntries($gbid);
							foreach($psubs as $psub){
								$sel='';
								if($rec->parentid==$psub->id) $sel='selected="selected"';
								echo '<option value="'.$psub->id.'" '.$sel.' ">'.$psub->title.'</option>';
							}
						?>
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="focusedInput">Description</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" name="description" type="text" value="<?php echo $rec->description; ?>">
					</div>
				</div>
			</div>
		<?php 
			if($rec->parentid < 1){ 
		?>
			<div style="float:left;">
				<div class="control-group">
					<label class="control-label" for="focusedInput">Sub Total Field ?</label>
					<div class="controls">
						<?php 	if($rec->subtotalfield=="1")
								echo '<input class="input-xlarge focused" id="focusedInput" name="subtotal" type="checkbox" checked value="1" />';
							else
								echo '<input class="input-xlarge focused" id="focusedInput" name="subtotal" type="checkbox" value="1" />';
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Select SubTotal Fields</label>
					<div class="controls">
					<br />
					<table border="1">
				
					<?php
							$sgbids = $model->getSubTotalEntries($gbeid);
							foreach($sgbids as $sbrec)
								$sb[]=$sbrec->sgbid;
                                                        $psubs = $model->getTGradeBookParentEntries($gbid);
                                                        foreach($psubs as $psub){
								if($psub->id==$gbeid || $psub->subtotalfield=="1") continue;
								$sel="";	
								if(in_array($psub->id,$sb) )
									$sel="Checked";
								echo "<tr>";
								echo '<td><input type="checkbox" name="gbeids[]" '.$sel.' value="'.$psub->id.'"/></td>';
								echo "<td>".$psub->code."</td>";
								echo "<td>".$psub->title."</td>";
								echo "<td>".$psub->weightage."</td>";
								echo "</tr>";
                                                        }

					?>	
					</table>
					</div>
				</div>
			</div>
		<?php
			}
		?>
			</fieldset>
			<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
			<input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
			<input type="hidden" id="controller" name="controller" value="exams" />
			<input type="hidden" id="view" name="view" value="exams" />
			<input type="hidden" name="task" id="task" value="<?php echo $task; ?>" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
			<input type="hidden" name="gbid" value="<?php echo $gbid; ?>"/>
			<input type="hidden" name="required" value="1"/>
	
		</div>
	</div><!--/span-->
</div><!--/row-->
</form>   

