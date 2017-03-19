<script type="text/javascript">
function check()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
 }
</script>
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('cce');
    	$namekey = JRequest::getVar('namekey');
	$students =$model->feeStudents($namekey);
   	
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

   	$atItemid = $model->getMenuItemid('master','Academic Terms');
   	if($atItemid) ;
   	else{
        	$atItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$busroutelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$masterItemid);

  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);
     
  	$allotment= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentprofile&view=studentprofile&layout=transportdetails&task=display&Itemid='.$atItemid);


?>


<table width="100%" cellpadding="10">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir1.'/transportmanage.png'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left;">
        <div>&nbsp;</div>
        <h1 class="item-page-title">Manage Student/Staff details</h1>
      </div>
      <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $allotment; ?>"><img src="<?php echo $iconsDir1.'/allotment.png'; ?>" alt="settings" style="width: 32px; height: 32px;" /></a><br />
      </div></td>
  </tr>
</table>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span8">
  <h2><i class="icon-edit"></i> Allot Student</h2>
</div>
</div>
<div class="box-content">
  <table class="table table-striped table-bordered bootstrap-datatable datatable stu-admission">
    <thead>
      <tr>
        <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
          <th><span class="icon icon-color icon-triangle-ns"></span>Reg.No</th>
    <th><span class="icon icon-color icon-triangle-ns"></span>Name</th>
    <th><span class="icon icon-color icon-triangle-ns"></span>Stop Name</th>
    <th><span class="icon icon-color icon-triangle-ns"></span>Vehicle Code</th>
    <th><span class="icon icon-color icon-triangle-ns"></span>Fare</th>
    <th><span class="icon icon-color icon-triangle-ns"></span>Morning arrival</th>
    <th><span class="icon icon-color icon-triangle-ns"></span>Evening arrival</th>
      </tr>
    </thead>
    <tbody>
    <?php
		if($this->list){
                   foreach($this->list as $rec) {
		    ?>
  <tr style="height:35px;">
    <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td>
      <?php
		  		 $students = $model->fee_getstudent($rec->st_id); 
				 $vehicles = $model->fee_getvehicle($rec->vid);
				 $stops = $model->fee_getstops($rec->stopid);
				 echo "<td>$students->registerno</td>";
		          echo "<td>$students->firstname $students->middlename</td>";
                  echo "<td>$stops->stopname</td>";
				 echo "<td>$vehicles->vcode</td>";
                 echo "<td>$stops->fare</td>";
				 echo "<td>$stops->m_arrival</td>";
				 echo "<td>$stops->e_arrival</td></tr>";
		  }
		}
		?>
    </tbody>
  </table>
</div>
<div class="row-fluid form-actions">
  <div class="span6">
    <button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
    <button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
  </div>
  <div class="span4" align="right">
    <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>
  </div>
</div>
</div>
<!--/span-->

</div>
<!--/row-->
  <input type="hidden" name="controller" value="allotstudent" />
  <input type="hidden" name="view" value="allotstudent" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
  <input type="hidden" name="task" value="actions"/>
  <input type="hidden" name="layout" value="default"/>
</form>



