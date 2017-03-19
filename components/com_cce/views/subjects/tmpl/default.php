<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$model = & $this->getModel('managesubjects');
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
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=courses&Itemid='.$masterItemid);
?>


<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=subjects&view=subjects&task=actions&courseid='.$this->courseid.'&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
     <div class="span7"> <h2><i class="icon-edit"></i>Subjects</h2></div>
     <div class="span3">
     <form class="form-horizontal pull-right" action="index.php" method="POST" name="adminForm">
							<fieldset>
								<div class="control-group">
								<label class="control-label" for="selectError">Select Class</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" onchange="submit();" name="courses">
                                  <option value="">Select</option>
									<?php
					
													foreach($this->courses as $course) :
													echo "<option value=\"".$course->id."\" ".($course->id == $this->courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
													endforeach;
										?>
								  </select>
								</div>
							  </div>
							</fieldset>
                            <input type="hidden" name="controller" value="subjects" />
                            <input type="hidden" name="view" value="subjects" />
                            <input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
                            <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                            <input type="hidden" name="task" value="actions"/>
						  </form>
     </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Acronym</th>
            <th>Hours</th>
          </tr>
        </thead>
        <tbody>
          <?php
					foreach($this->subjects as $rec) {
                 		?>
          <tr>
            <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td>
                 <td><?php echo $rec->subjectcode; ?></td>
                 <td><?php echo $rec->subjecttitle; ?></td>
                 <td><?php echo $rec->acronym; ?></td>
                 <td><?php echo $rec->credits; ?></td>
          </tr>
          <?php
								}
							?>
        </tbody>
      </table>
     		<div class="form-actions">
						<div class="pull-right">
						<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Allot</button>        
						<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
						</div>
					</div>          
    </div>
    <!--/span--> 
    
  </div>
  <!--/row-->
<input type="hidden" name="controller" value="subjects" />
<input type="hidden" name="view" value="subjects" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>



</div>
