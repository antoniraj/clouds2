<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$logoicon = JURI::base() . 'components/com_cce/images/logo';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('cce');
     	$stored = JRequest::getVar('storedid');
     		$month = JRequest::getVar('month');
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
		$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&layout=default&Itemid='.$masterItemid);
		$feecollection= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=feecollection&view=feecollection&layout=default&task=display&Itemid='.$atItemid);
	$driver= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&layout=default&task=display&Itemid='.$atItemid);


  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);
?>
<!--
TOP LINKS....DASHBOARD
-->
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1200,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=feecollection&controller=feecollection&layout=printview&task=print&storedid='.$this->rec->storedid.'&tmpl=component&print=1" '.$href;
        }
?>

<?php
			
				 $fee = $model->getfeestudents($this->rec->storedid);
				 $students=$model->fee_getstudent($fee->st_id); 
				 $vehicles = $model->fee_getvehicle($fee->vid);
				 $pay = $model->showtransmonths($this->rec->month);
				 $stops = $model->fee_getstops($fee->stopid);
				  $course=$model->getStudentClass($fee->st_id,$recs);
				  
?>
	<div style="float:right;margin-right:700px;"><a href=<?php echo $href; ?> ><img src="<?php echo $iconsDir.'/printer.png'; ?>" alt="" style="width: 16px; height: 16px;" /></a></div>

<div id="printheader">
		<div id="logo">
			<img src="<?php echo $logoicon.'/logo.png'; ?>" alt="School Logo" style="margin-top:0px;width: 200px; height: 72px;" />
		
	      
	      	<h4 style="float:right;margin-top:30px;"><span style="color:#000;">Month: </span><?php echo $pay->month; ?></h4>
		</div>
	  
</div>






<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
<div class="payfee">
	<div class="first">
<table>	
		<?php
				echo '<tr><td><pre>Name   :</td><td>'.$students->firstname.'</pre></td></tr>';
				echo '<tr><td><pre>Reg.No :</td><td>'.$students->registerno.'</pre></td></tr>';
				echo '<tr><td><pre>Gender :</td><td>'.$students->gender.'</pre></td></tr>';
				echo '<tr><td><pre>Mobile :</td><td>'.$students->mobile.'</pre></td></tr>';
				 
		?>
</table>

<div class="third">
     <table>
     		<th>Stop Name</th><th>Marning Arrival</th><th>Evening Arrival</th>
         <?php
				
				echo '<tr><td>'.$stops->stopname.'</td>';
				echo '<td>'.$stops->m_arrival.'</td>';
				echo '<td>'.$stops->e_arrival.'</td></tr>';
				 
		?>
		
		</table>
	<div syle="width:100%;">
   <div align="right" style="margin-top:10px;width:180px;float:left;" class="findtotal"><h3><span style="color:#000;">Amount = </span>  <?php  echo $this->rec->amount; ?></h3> </div>
    <div align="right" style="margin-top:10px;float:right;width:180px;" class="findtotal"><h3><span style="color:#000;">Fine =</span>  <?php echo $this->rec->fine; ?></h3></div>	
	   <div align="right" style="margin-top:20px;width:280px;float:right;" class="findtotal"><h3><span style="color:#000;">Total= </span><?php echo $this->rec->total; ?> </h3></div>	
				
		<div style="margin:76px 0px 0px 110px;float:right;"><h4><span style="color:#000;">Principal's Signature</span></h4> </td></tr></table></div>	
	  
   <div style="width:100%">
   <div style="margin-top:80px;float:left;"><h4><span style="color:#000;">Date: </span><?php echo $this->rec->dateofpay; ?></h4> </td></tr></table></div>	
	</div>	
	</div>	
	</div>
	
</div>
<div class="second">

<table>	
		<?php
				
				echo '<tr><td><pre>Joined Date :</td><td>'.$fee->date.'</pre></td></tr>';
				echo '<tr><td><pre>Class       :</td><td>'.$recs->code.'</pre></td></tr>';
				echo '<tr><td><pre>Address     :</td><td>'.$students->addressline2.'</pre></td></tr>';
				echo '<tr><td><pre>City        :</td><td>'.$students->city.'</pre></td></tr>';
		 
		?>
</table>

</div>
</div>
