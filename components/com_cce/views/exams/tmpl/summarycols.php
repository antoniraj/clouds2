<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$id= JRequest::getVar('id');
	$cbid= JRequest::getVar('cbid');
	$subjectid= JRequest::getVar('subjectid');
	$subjecttitle= JRequest::getVar('subjecttitle');
	$terms= explode(",",JRequest::getVar('terms'));
	
   	$model = & $this->getModel('exams');
	if(isset($id)){
		$model->getSummaryEntry($id,$rec);	
	}

	$iconsDir1 = JURI::base() . 'components/com_cce/images';


   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Exams');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);
   	$close= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=exams&view=exams&layout=coursebooks&cbid='.$cbid.'&Itemid='.$Itemid);
   	$delete= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=exams&view=exams&layout=coursebooks&task=deletesummaryentry&id='.$id.'&cbid='.$cbid.'&Itemid='.$Itemid);


?>


<b style="font: bold 15px Georgia, serif;">SUMMARY FIELDS</b>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&cbid='.$cbid.'&task=savesummarycols&id='.$rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">
<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-edit"></i><?php echo $subjecttitle; ?></h2>
                        <div class="box-icon">
                                <button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
                                <a class="btn btn-small btn-warning" style="width:50px;" href="<?php echo $close; ?>"><i class="icon-minus-sign"></i>Cancel</a>
                                <a class="btn btn-small btn-danger" style="width:50px;" href="<?php echo $delete; ?>"><i class="icon-minus-sign"></i>Delete</a>
                        </div>
                </div>
                <div class="box-content">
                        <div style="float:left;">
                        <fieldset>
                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">ID</label>
                                        <div class="controls">
                                                <?php echo $id; ?>
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
                                        <label class="control-label" for="focusedInput">Type</label>
                                        <div class="controls">
                                                <select id="selectError5" data-rel="chosen" name="summarytype">
                                                <?php
                                                                if($rec->summarytype==2){ 
                                                                	echo '<option value="2" selected="selected">Average</option>';
                                                                	echo '<option value="1">Sum</option>';
								}else{
                                                                	echo '<option value="1">Sum</option>';
                                                                	echo '<option value="2">Average</option>';
								}
                                                ?>
                                                </select>
                                        </div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Grade Book Entries</label>
                                        <div class="controls">
                                        <?php
                                                        $sgbids = $model->getSummaryColEntries($id);
                                                        foreach($sgbids as $sbrec)
                                                                $sb[]=$sbrec->gbeid;

							foreach($terms as $termid){
        							$model->getSubjectTermGradeBookDetails($subjectid,$termid,$stgbrec); 
	                                                        $psubs = $model->getTGradeBookParentEntries($stgbrec->id);
								$model->getTTerm($termid,$trec);
								echo '<h2>'.$trec->term.'</h2>';
								echo '<table>';
        	                                                foreach($psubs as $psub){
					
                	                                                $sel="";
                        	                                        if(in_array($psub->id,$sb) )
                                	                                        $sel="Checked";
                                        	                        echo "<tr>";
                                                	                echo '<td><input type="checkbox" name="gbeids[]" '.$sel.' value="'.$termid.':'.$psub->id.'"/></td>';
                                                        	        echo "<td>".$psub->code."</td>";
                                                                	echo "<td>".$psub->title."</td>";
	                                                                echo "<td>".$psub->weightage."</td>";
        	                                                        echo "</tr>";
                	                                        }
								echo '</table>';
							}

                                        ?>
                                        </div>
                                </div>



				<input type="hidden" name="subjectid" value="<?php echo $subjectid; ?>" />
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="cbid" value="<?php echo $cbid; ?>" />

			</fieldset>
			</div>
		</div>
	</div>
</div>

</form>

