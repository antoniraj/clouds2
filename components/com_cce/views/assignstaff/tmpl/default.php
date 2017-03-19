<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$model = & $this->getModel('cce');
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
   	$mlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classteachers&view=classteachers&task=display&Itemid='.$masterItemid);
?>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i>Select Class Teachers</h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
            <th>Staff Code</th>
            <th>Staff Name</th>
            <th>Department</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <?php
					foreach($this->staffs as $rec) {
                 		?>
          <tr>
            <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td>
                 <td><?php echo $rec->staffcode; ?></td>
                 <td><?php echo "$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname"; ?></td>
                 <td><?php echo $rec->department; ?></td>
                 <td><?php echo $rec->email; ?></td>
          </tr>
          <?php
								}
							?>
        </tbody>
      </table>
      <div class="row-fluid">
        <div class="span6">
         </div>
        <div class="span6" align="right">
          <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>
        </div>
      </div>
    </div>
    <!--/span--> 
    
  </div>
  <!--/row-->
<input type="hidden" name="controller" value="classteachers" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" id="view" name="view" value="assignstaff" />
<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" id="task" value="save" />
</form>

