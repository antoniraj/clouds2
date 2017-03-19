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
		$routeimage= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=setroute&Itemid='.$atItemid);


  	$busroute= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=transportsettings&task=display&Itemid='.$atItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->

<table width="100%" cellpadding="10">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir.'/busroute.png'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left;">
        <div>&nbsp;</div>
        <h1 class="item-page-title">Transport Route Details</h1>
      </div>
      <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroute; ?>"><img src="<?php echo $iconsDir1.'/settings.png'; ?>" alt="settings" style="width: 32px; height: 32px;" /></a><br />
      </div></td>
  </tr>
</table>
<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
										
<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Vehicle Details</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
								
							  <tr>
								  <th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
								  <th><span class="icon icon-color icon-triangle-ns"></span>Destination</th>
								  <th><span class="icon icon-color icon-triangle-ns"></span>Vehicle Code</th>
								  <th><span class="icon icon-color icon-triangle-ns"></span>No of Stops</th>
                                  <th><span class="icon icon-color icon-triangle-ns"></span>Operation</th>
							  </tr>
						  </thead>   
						  <tbody>
                          <?php
							  
if($this->routes){
		   $sno=1;
                   foreach($this->routes as $rec) {
					 
        ?>
  <tr style="height:40px;">
    <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" />
      <?php
	   $vehicle = $model->getvehicle($rec->vid); 
	   $stops = $model->getStops($rec->id);
	    $countstops = $model->countStops($rec->id);
	    $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=transportroutes&controller=transportroutes&layout=viewstops&task=viewstop&cid='.$rec->id,false);
		  echo "</td>";
                  echo "<td>$rec->route</td>";
                  echo "<td>".$vehicle->vcode."</td>";
				  echo "<td>".$countstops->n_stops."</td>";
               
?>
<td>
<a class="btn btn-success" href="<?php echo $redirectTo; ?>">
<i class="icon-zoom-in icon-white"></i>
View
</a>
</td>
  </tr>
  <?php 
		  }
}
		  ?>
							 </tbody>
					  </table>  
                      <div class="row-fluid">
  <div class="span8">
    <button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
    <button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
  </div>
  <div class="span4" align="right">
    <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>
  </div>
</div>        
					</div>

				</div><!--/span-->
			</div><!--/row-->
  <input type="hidden" name="controller" value="transportroutes" />
  <input type="hidden" name="view" value="transportroutes" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
  <input type="hidden" name="task" value="actions"/>
  <input type="hidden" name="layout" value="default"/>

</form>
