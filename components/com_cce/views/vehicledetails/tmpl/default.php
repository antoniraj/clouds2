
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
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/vehicledetails.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Vehicle Details</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
             <div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $vehicledetails; ?>"><img src="<?php echo $iconsDir1.'/settings.png'; ?>" alt="settings" style="width: 32px; height: 32px;" /></a><br />
			</div>

                </td>
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
								  <th  class="sorting_disabled"><input type="checkbox" onchange="checkAll()" name="chk[]" /></th>
								  <th>Vehicle No</th>
								  <th>Vehicle Code</th>
								  <th>No of Seats</th>
								  <th>Max.Allowed</th>
								   <th>Color</th>
								   <th>Status</th>
							  </tr>
						  </thead>   
						  <tbody>
							  
							<?php
							if($this->list){
							   $sno=1;
									   foreach($this->list as $rec) {
										 
										   // $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&task=edit&cid[]='.$rec->id);
							?>
							<tr style="height:25px;">
									 <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" />
					<?php
							  echo "</td>";
                               
                                 
								echo '<td>'.$rec->vno.'</td>';
								echo '<td class="center">'.$rec->vcode.'</td>';
								echo '<td class="center">'.$rec->noofseats.'</td>';
								echo '<td class="center">'.$rec->max_seats.'</td>';
								echo '<td class="center">'.$rec->color.'</td>';
								echo '<td class="center">';
								if($rec->status=='Active')
								{
									echo '<span class="label label-success">Active</span>';
								
								}
								else{
									echo '<span class="label">Inactive</span>';
								}
								echo '</td>';
								
							
								                                            
						
							
							
							
								echo '</tr>';
									
								}
							}
							else{
								echo '<tr> <td colspan="13" align="center">... No details .... </td></tr>';
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
				</div><!--/span-->
			</div><!--/row-->


<input type="hidden" name="controller" value="vehicledetails" />
<input type="hidden" name="view" value="vehicledetails" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
<input type="hidden" name="layout" value="default"/>

</form>
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
