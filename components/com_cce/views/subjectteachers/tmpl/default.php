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
	$masterItemid = $model->getMenuItemid('assignments','Subject Teachers');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=courses&Itemid='.$masterItemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Courses',$modulelink);
        $pathway->addItem('Subject Teachers');


?>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
     <div class="span7"> <h2><i class="icon-edit"></i>Subjects</h2></div>
     <div class="span3">
     <form class="form-horizontal pull-right" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
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
                            <input type="hidden" name="view" value="subjectteachers" />
                            <input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
                            <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
						  </form>
     </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Subject Name</th>
            <th>Subject Code</th>
            <th>credits</th>
            <th>Subject Teacher</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          <?php
					foreach($this->subjects as $rec) {
                 		?>
          <tr>
                 <td><?php echo $rec->subjecttitle; ?></td>
                 <td><?php echo $rec->subjectcode; ?></td>
                 <td><?php echo $rec->credits; ?></td>
                 
              <?php
			$rs = $this->model->getSubjectTeachers($this->courseid,$rec->id,$staffrecs);
			echo "<td>";
			foreach($staffrecs as $staff)
			{
				$dlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=subjects&view=subjectteachers&task=remove&courseid='.$this->courseid.'&subjectid='.$rec->id.'&Itemid='.$Itemid.'&staffid='.$staff->id);
				echo "<a class='label label-warning' href=\"$dlink\">X</a>  [$staff->staffcode]&nbsp;$staff->firstname<br />";
			}
			echo "</td>";
			echo "<td>";
			$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=subjects&view=subjectteachers&task=assignstaff&courseid='.$this->courseid.'&subjectid='.$rec->id.'&Itemid='.$Itemid);
			echo "<a class='btn btn-info' href=\"$link\">Assign</a>";	
			echo "</td>";
		 ?>
          </tr>
          <?php
								}
							?>
        </tbody>
      </table>

    </div>
    <!--/span--> 
    
  </div>
  <!--/row-->

</form>
</div>

