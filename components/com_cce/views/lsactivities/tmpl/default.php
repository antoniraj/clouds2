<?php
        defined('_JEXEC') or die('Denied..');
	$app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir1 = JURI::base() . 'components/com_cce/images/';
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
        $masterItemid = $model->getMenuItemid('master','Grades');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);


?>
<div class="row-fluid">
<div class="span6"> 
   <div class="row-fluid">
   <div class="span1">
     <img src="<?php echo $iconsDir1.'/lifeskills.png'; ?>" alt="Template" style="width: 48px; height: 48px;" />

   </div>
   <div class="span6">
    <h1> Life Skills Activities</h1>
   </div>
   </div>
 </div>
<div class="span6" align="right">
   <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Grades" style="width: 38px; height: 38px;" /></a> 

     <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 38px; height: 38px;" /></a> 
   
</div>
</div>


<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i> Life Skills Activities </h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
            <th>Life Skill</th>
            <th>Code</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <?php
					foreach($this->activities as $rec) {
                 		?>
          <tr>
            <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td>
                  <td><?php echo $rec->activityname; ?></td>
                <td><?php echo $rec->activitycode; ?></td>
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
  
  <input type="hidden" name="view" value="lsactivities" />
<input type="hidden" name="controller" value="lsactivities" />
<input type="hidden" name="task" value="actions"/>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
</form>

