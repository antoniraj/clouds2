<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$Itemid = JRequest::getVar('Itemid');
	$subjectid= JRequest::getVar('subjectid');
	$partid= JRequest::getVar('partid');
	$cbid= JRequest::getVar('cbid');
	
   	$model = & $this->getModel('exams');

	if(isset($subjectid)) {
		$htitle="Edit Subject";
		$task = "updatesubject";
		$model->getTSubject($subjectid,$rec);
	}else{
		$htitle ="Add Subject";
		$task = "savesubject";
		$rec->subjecttitle='';
		$rec->subjectcode='';
		$rec->acronym='';
		$rec->credits='5';
		$rec->passmark='35';
		$rec->marks='100';
		$rec->grouptag='A';
		$rec->category='1';
		$rec->subjecttype='Theory';
		$rec->sessionduration='1';
	}

	$precs = $model->getParentTSubjects($partid);
	
	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);

?>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task='.$task.'&id='.$rec->id.'&cbid='.$cbid.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i><?php echo $htitle; ?></h2>
			<div class="box-icon">
				<button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
			</div>
		</div>
		<div class="box-content">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Subject Title</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" required name="subjecttitle" type="text" value="<?php echo $rec->subjecttitle; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Subject Code</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" name="subjectcode" required type="text" value="<?php echo $rec->subjectcode; ?>">
					</div>
				</div>
                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Acronym</label>
                                        <div class="controls">
                                                <input class="input-xlarge focused" id="focusedInput" name="acronym" required type="text" value="<?php echo $rec->acronym; ?>">
                                        </div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Credits/Hrs</label>
                                        <div class="controls">
                                                <input class="input-xlarge focused" id="focusedInput" name="credits" required type="text" value="<?php echo $rec->credits; ?>">
                                        </div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Max. Marks</label>
                                        <div class="controls">
                                                <input class="input-xlarge focused" id="focusedInput" name="marks" required type="text" value="<?php echo $rec->marks; ?>">
                                        </div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Pass Mark</label>
                                        <div class="controls">
                                                <input class="input-xlarge focused" id="focusedInput" name="passmark" required type="text" value="<?php echo $rec->passmark; ?>">
                                        </div>
                                </div>


				<div class="control-group">
					<label class="control-label" for="focusedInput">Subject Type</label>
					<div class="controls">
						<select id="selectError6" data-rel="chosen" name="subjecttype">
							<option value="T" <?php if($rec->subjecttype=="T") echo 'selected="selected"'; ?>>Theory</option>
							<option value="P" <?php if($rec->subjecttype=="P") echo 'selected="selected"'; ?>>Practical</option>
						</select>
					</div>
				</div>
   				<div class="control-group">
                                        <label class="control-label" for="focusedInput">Group Tag</label>
                                        <div class="controls">
                                                <input class="input-xlarge focused" id="focusedInput" name="grouptag" required type="text" value="<?php echo $rec->grouptag; ?>">
                                        </div>
                                </div>


   				<div class="control-group">
                                        <label class="control-label" for="focusedInput">Session Duration</label>
                                        <div class="controls">
                                                <input class="input-xlarge focused" id="focusedInput" name="sessionduration" required type="text" value="<?php echo $rec->sessionduration; ?>">
                                        </div>
                                </div>
                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Parent Subject</label>
                                        <div class="controls">
                                                <select id="selectError8" data-rel="chosen" name="parentid">
                                                       	<option value="">No Parent</option>
						<?php
						foreach($precs as $prec){
							if($subjectid==$prec->id) continue; ?>
                                                        <option value="<?php echo $prec->id; ?>" <?php if($rec->parentid==$prec->id) echo 'selected="selected"'; ?>><?php echo $prec->subjecttitle; ?></option>
						<?php
						}
						?>
                                                </select>
                                        </div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Subject Category</label>
                                        <div class="controls">
                                                <select id="selectError9" data-rel="chosen" name="subjectcategory">
                                                        <option value="1" <?php if($rec->subjectcategory=="1") echo 'selected="selected"'; ?>>Core</option>
                                                        <option value="0" <?php if($rec->subjectcategory=="0") echo 'selected="selected"'; ?>>Additional</option>
                                                </select>
                                        </div>
                                </div>





				<div class="form-actions">
					<button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
				</div>
			</fieldset>

						  
			<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
			<input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
			<input type="hidden" id="controller" name="controller" value="exams" />
			<input type="hidden" id="view" name="view" value="exams" />
			<input type="hidden" name="task" id="task" value="<?php echo $task; ?>" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
			<input type="hidden" name="cbid" value="<?php echo $cbid; ?>"/>
			<input type="hidden" name="partid" value="<?php echo $partid; ?>"/>
			<input type="hidden" name="subjectid" value="<?php echo $subjectid; ?>"/>
	
		</div>
	</div><!--/span-->
</div><!--/row-->
</form>   

