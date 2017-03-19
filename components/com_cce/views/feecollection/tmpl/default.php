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
   	$date = JRequest::getVar('date');
	echo $date;
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
     
  	$vehicledetails= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=transportsettings&task=display&Itemid='.$atItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->

<table width="100%" cellpadding="10" style="border:none;">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir1.'/feecollection.png'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left;">
        <div>&nbsp;</div>
        <h1 class="item-page-title">Fee Collection</h1>
      </div>
      <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
      </div></td>
  </tr>
</table>
<div class="row-fluid">
<div class="span3">
</div>
<div class="span4">
<form class="form-horizontal pull-right" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <fieldset>
							<div class="control-group">
							  <label class="control-label">Date :</label>
							  <div class="controls">
								<input type="text" class="datepicker" name="date" onchange="submit();" id="date08" value="<?php echo JArrayHelper::indianDate($date); ?>">
							  </div>
							</div>
  </fieldset>
  <input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
  <input type="hidden" id="controller" name="controller" value="feecollection" />
  <input type="hidden" id="view" name="view" value="feecollection" />
  <input type="hidden" name="task" id="task" value="display" />
  <input type="hidden" name="layout" id="layout" value="default" />
</form>
</div>
<div class="span4">
</div>
</div>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span8">
  <h2><i class="icon-edit"></i> Pay Fee</h2>
</div>

</div>
<div class="box-content">
  <table class="table table-striped table-bordered bootstrap-datatable datatable stu-admission">
    <thead>
      <tr>
        <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
     <th>Reg.No</th>
    <th>Name</th>
     <th>Class</th>
    <th>Stop Name</th>
    <th class="hidden-phone">Vehicle Code</th>
    <th class="hidden-phone">Fare</th>
    <th class="hidden-phone">Action</th>
      </tr>
    </thead>
    <tbody>
    
    <?php
    if($this->list){
		   $sno=1;
                   foreach($this->list as $rec) {
					 
        ?>
  <tr style="height:35px;">
<?php
		  		 $students = $model->fee_getstudent($rec->st_id); 
				 $vehicles = $model->fee_getvehicle($rec->vid);
				 $pay = $model->getpayfee($rec->id,$date);
				 $course=$model->getStudentClass($rec->st_id,$recs);
				 $stops = $model->fee_getstops($rec->stopid);
				 $payfee = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=feecollection&controller=feecollection&task=enter&layout=enterfee&date='.$date.'&storedid='.$rec->id);
		?>
				  <td><input type="checkbox"  name="cid[]" value="<?php echo $rec->id; ?>" /></td>
		<?php
        	  	   echo "<td>$students->registerno</td>";
 		 	       echo "<td>$students->firstname $students->middlename</td>";
            	   echo "<td>$recs->code</td>";            
             	   echo "<td>$stops->stopname</td>";
				 	echo "<td>$vehicles->vcode</td>";
                 	echo "<td>$stops->fare</td>";
              if($pay->countpay)
              {
              	  $getid=$model->getprintviewid($rec->id,$date);
          
              	 $print = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=feecollection&controller=feecollection&task=print&layout=printview&insertedid='.$getid->id);
			
              		echo '<td><span style="color:red;">
					<a class="btn btn-success" href="'.$print.'">
<i class="icon-zoom-in icon-white"></i>
   Paid
</a></span> </td>';
              	}
              	else{
              		echo '<td>
					<a class="btn btn-info" href="'.$payfee.'">
<i class="icon-edit icon-white"></i>
Pay Fee
</a></td>';
              		}
		
		  }
		}?>
  </tr>
    

    </tbody>
  </table>
</div>
</div>
<!--/span-->
</div>
<!--/row-->

  <input type="hidden" name="controller" value="feecollection" />
  <input type="hidden" name="view" value="feecollection" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
    <input type="hidden" name="date" value="<?php echo $date; ?>" />
  <input type="hidden" name="task" value="showlimit"/>
  <input type="hidden" name="layout" value="default"/>
</form>


