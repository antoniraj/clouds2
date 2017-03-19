<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
		$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	$Itemid = JRequest::getVar('Itemid');
	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);

?>

<div class="row-fluid">
<div class="span6"> 
   <div class="row-fluid">
   <div class="span1">
     <img src="<?php echo $iconsDir.'/fagrades.png'; ?>" alt="Template" style="width: 68px; height: 48px;" />

   </div>
   <div class="span6">
    <h1>FA-Grades</h1>
   </div>
   </div>
 </div>
<div class="span6" align="right">
   <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir.'/1results.png'; ?>" alt="Grades" style="width: 48px; height: 48px;" /></a> 

     <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a> 
   
</div>

</div>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i> FA-Grades</h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
            <th width="10%">From</th>
            <th width="10%">To</th>
            <th width="15%">Grade</th>
            <th width="15%">GradePoint</th>
            <th width="45%">Description</th>
          </tr>
        </thead>
        <tbody>
          <?php
					foreach($this->fagrades as $rec) {
                 		?>
          <tr>
            <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td>
            <td><?php echo $rec->from; ?></td>
            <td><?php echo $rec->to; ?></td>
            <td><?php echo $rec->letter; ?></td>
            <td><?php echo $rec->points; ?></td>
            <td><?php echo $rec->description; ?></td>
          </tr>
          <?php
								}
							?>
        </tbody>
      </table>
      <div class="row-fluid">
        <div class="span6">
          <button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
          <button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
        </div>
        <div class="span6" align="right">
          <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>
        </div>
      </div>
    </div>
    <!--/span--> 
    
  </div>
  <!--/row-->
<input type="hidden" name="controller" value="fagrades" />
<input type="hidden" name="view" value="fagrades" />
<input type="hidden" name="task" value="actions"/>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
</form>

