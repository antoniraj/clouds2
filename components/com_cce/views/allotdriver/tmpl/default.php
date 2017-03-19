<script type="text/javascript">
function checkAll()
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
     
  	$vehicledetails= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=transportsettings&task=display&Itemid='.$atItemid);


?>

<table width="100%" cellpadding="10">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir.'/vehicledetails.png'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left;">
        <div>&nbsp;</div>
        <h1 class="item-page-title">Vehicle Details</h1>
      </div>
      <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $vehicledetails; ?>"><img src="<?php echo $iconsDir1.'/settings.png'; ?>" alt="settings" style="width: 32px; height: 32px;" /></a><br />
      </div></td>
  </tr>
</table>
<div class="row-fluid adjustalert alert alert-success">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
  <div class="span4" align="left">
    <div class="control-group">
      <label class="control-label" for="focusedInput">Driver Name</label>
      <div class="controls">
        <select name="did" id="selectError4" data-rel="chosen">
          <option value="" selected="selected">...Select Name...</option>
          <?php
             foreach($this->drivers as $driver) {
				 	 
					echo '<option value='.$driver->id.'>'.$driver->Fname.' '.$driver->Lname.'</option>';
			 }
				?>
        </select>
      </div>
    </div>
    </div>
  <div class="span3">
    <div class="control-group" >
      <label class="control-label" for="selectError">Vehicle Code</label>
      <div class="controls">
        <select name="vid" id="selectError8" data-rel="chosen">
          <option value="" selected="selected">...Select Vehicle...</option>
          <?php
             foreach($this->vehicles as $vehicle) {
				 	 
					echo '<option value='.$vehicle->id.'>'.$vehicle->vcode.'</option>';
			 }
				?>
        </select>
      </div>
    </div>
  </div>
  <div class="span4">
    <div class="control-group">
      <label class="control-label" for="date01">Date</label>
      <div class="controls">
        <input type="text" class="datepicker" id="date05" name="date" value="<?php echo $this->rec->date; ?>">
      </div>
    </div>
  </div>
  <div class="span1">
      <button class="btn btn-small btn-success" name="Add"  value="Add"><i class="icon-plus-sign"></i>ADD</button> 
  </div>
</div>
  <div class="row-fluid sortable">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-user"></i> Allot Driver</h2>
        <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>  </div>
      </div>
      <div class="box-content">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
              <th><span class="icon icon-color icon-triangle-ns"></span>Driver Name</th>
              <th><span class="icon icon-color icon-triangle-ns"></span>Vehicle Code</th>
              <th width="25%"><span class="icon icon-color icon-triangle-ns"></span>Date</th>
            </tr>
          </thead>
       <tbody>
       <?php
	   	if($this->list){
		   $sno=1;
                   foreach($this->list as $rec) {
			  $vehicle = $model->getvehicle($rec->vid); 
			   $driver = $model->get_driver($rec->did);
		 
                       // $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&task=edit&cid[]='.$rec->id);
        ?>
  <tr style="height:25px;">
    <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" />
      <?php
		  echo $sno++ ."</td>";
		          echo "<td>$driver->Fname $driver->Lname</td>";
                  echo "<td>$vehicle->vcode</td>";
				 echo "<td>".JArrayHelper::indianDate($rec->date)."</td>";
               
?>
  </tr>
  <?php 
		  }
		}
       ?>
       </tbody>
       </table>
      </div>
      <div class="row-fluid form-actions">
        <div class="span6">
        </div>
        <div class="span4" align="right">
              <button class="btn btn-small btn-danger" name="Delete"  value="Delete"><i class="icon-trash icon-white"></i>  Delete</button>
     <input type="hidden" name="controller" value="allotdriver" />
  <input type="hidden" name="view" value="allotdriver" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
  <input type="hidden" name="task" value="actions"/>
  <input type="hidden" name="layout" value="default"/>
</form>

        </div>
      </div>
    </div>
    <!--/span--> 
  </div>
  <!--/row-->
