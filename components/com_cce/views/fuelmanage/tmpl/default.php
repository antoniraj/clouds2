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
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/fuel.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">  Fuel Maintanance</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
  

                </td>
        </tr>
</table>


<br />
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=transport&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">

<table width="100%" border="1" cellspacing="0" cellpadding="0">
<tr>
        <th class="list-title" style="height:20px;" width=""><input type="checkbox" onchange="checkAll()" name="chk[]" /></th>
        <th class="list-title" style="height:20px;" width="">Vehicle Code</th>
        <th class="list-title" width="">Fuel Consumed</th>
        <th class="list-title" width="">Amount</th>
        <th class="list-title" width="">Date</th>

       
</tr>
        <?php
		if($this->list){
		   $sno=1;
                   foreach($this->list as $rec) {
					 $vehicle = $model->getvehicle($rec->vcode);  
                       // $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&task=edit&cid[]='.$rec->id);
        ?>
        <tr style="height:25px;">
                 <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" />
<?php
		  echo $sno++ ."</td>";
		          echo "<td>$vehicle->vcode</td>";
                  echo "<td>$rec->litre</td>";
				 echo "<td>$rec->amount</td>";
                 echo "<td>$rec->date</td>";
				
               
?>
        </tr>
        <?php 
		  }
		}else{?>
		<tr> <td colspan="13" align="center">... No details .... </td></tr>
		<?php }
	 ?>
</table>
<br />
<table  style="border:none;" width="100%">
<tr  style="border:none;"> <td   style="border:none;" width="50%"><input type="submit" class="button_delete"  value="Delete" name="Delete">
<input type="submit" class="button_edit" name="Edit" value="Edit"></td>
<td  style="border:none;" width="50%" align="right"><input type="submit" class="button_add" name="Add" value="Add"> </td> </tr>
<input type="hidden" name="controller" value="fuelmanage" />
<input type="hidden" name="view" value="fuelmanage" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
<input type="hidden" name="layout" value="default"/>
</table>

