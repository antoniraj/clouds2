<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$cmdf= JRequest::getVar('cmdf');
	$fstid= JRequest::getVar('fstid');
	$eon= JRequest::getVar('eon');
	if(! isset($eon)) $eon="0";
	
	setlocale(LC_MONETARY,"en_IN");
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');

	$feecategories = $model->getFeeCategoriesByStructure($fstid);
	foreach($feecategories as $ff) $fff[]=$ff->id;
	$ffff=implode('-',$fff);

	$fsts = $model->getFeeStructures();


   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Fees');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);

//Add Fee Category
        $addlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&layout=addeditfeecategory&Itemid='.$Itemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Fee Structures');
?>


<table border="0" width="100%"><tr>
<td width="80%" style="text-align:left;">
<b style="font: bold 15px Georgia, serif;">FEE STRUCTURES</b>
</td>
<td style="text-align:right;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
		<button class="btn btn-small btn-warning" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> New Fee Structure</button>
		<input type="hidden" name="view" value="fees" />
		<input type="hidden" name="layout" value="feecategory" />
		<input type="hidden" name="controller" value="fees" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="cmdf" value="<?php echo '1'; ?>" />
		<input type="hidden" name="fstid" value="<?php echo $fstid; ?>" />
		<input type="hidden" name="task" value="savenewfeestructure"/>
	</form>
</td>
<td style="text-align:right;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=deletefeestructure&fstid='.$fstid.'&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
		<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
		<input type="hidden" name="view" value="fees" />
		<input type="hidden" name="controller" value="fees" />
		<input type="hidden" name="layout" value="feecategory" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="fstid" value="<?php echo $fstid; ?>" />
		<input type="hidden" name="cmdf" value="<?php echo '2'; ?>" />
		<input type="hidden" name="task" value="deletefeestructure"/>
	</form>
</td>
<td style="text-align:right;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<?php
if($eon=="1") $s="Turn Editing Off";
else $s="Turn Editing On"; ?>
		<button class="btn btn-small btn-info" value="enable" name="Enable"> <i class="icon-edit icon-white"></i> <?php echo $s; ?></button>
		<input type="hidden" name="view" value="fees" />
		<input type="hidden" name="controller" value="fees" />
		<input type="hidden" name="layout" value="feecategory" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="fstid" value="<?php echo $fstid; ?>" />
		<input type="hidden" name="eon" value="<?php echo $eon; ?>" />
		<input type="hidden" name="cmdf" value="<?php echo '3'; ?>" />
		<input type="hidden" name="task" value="enableediting"/>
	</form>
</td></tr></table>				

<table border="0" width="100%"><tr><td style="text-align:left;">
<?php
if($cmdf!='1'){ 
?>
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<select id="selectError" data-rel="chosen" onchange="submit();" style="width:300px;" name="fstid">
		<option value="">Select a Fee Structure</option>
		<?php
		foreach($fsts as $fst) :
			echo "<option value=\"".$fst->id."\" ".($fst->id == $fstid ? "selected=\"yes\"" : "").">".$fst->title."</option>";
		endforeach;
		?>
	</select>
<!--	<button class="btn btn-small btn-warning" value="go" name="Go"> <i class="icon-edit icon-white"></i>Go</button> -->
	<input type="hidden" name="view" value="fees" />
	<input type="hidden" name="controller" value="fees" />
	<input type="hidden" name="layout" value="feecategory" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="cmdf" value="<?php echo '4'; ?>" />
	<input type="hidden" name="task" value="showfeestructure"/>
	</form>
<?php } ?>
</td>
<td width="50%" style="text-align:right;">
<?php
if($cmdf!='0'){ 
$s=$model->getFeeStructure($fstid,$fstrec);
?>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	Fee Structure title&nbsp;&nbsp;<input type="text" name="fsttitle" value="<?php echo $fstrec->title; ?>" />
	<button class="btn btn-small btn-primary" value="Save" name="Save"> <i class="icon-edit icon-white"></i> Save</button>
	<input type="hidden" name="view" value="fees" />
	<input type="hidden" name="controller" value="fees" />
	<input type="hidden" name="layout" value="feecategory" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="fstid" value="<?php echo $fstid; ?>" />
	<input type="hidden" name="cmdf" value="<?php echo '5'; ?>" />
	<input type="hidden" name="eon" value="<?php echo $eon; ?>" />
	<input type="hidden" name="task" value="savefeestructure"/>
</form>
<?php } ?>

</td>

</tr></table>


<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-content">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=savefeeparticulars&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>SNO</th>
<th>FEE HEADS</th>
<th>COURSES</th>
</tr>
</thead>   
<tbody>
<?php
if($feecategories){
	$i=1;
        foreach($feecategories as $rec) {
		//First find whether any student has paid the fee already then disable edit option
		$r = $model->getFeeCategoryPaidCount($rec->id,$cfcrec);
		if($cfcrec->tot>0) $eon_ok="0";
		else $eon_ok="1";
		
        	$deletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeecategory&layout=feecategory&eon='.$eon.'&fstid='.$fstid.'&Itemid='.$Itemid.'&fcid='.$rec->id);
                $editlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditfeecategory&eon='.$eon.'&fstid='.$fstid.'&Itemid='.$Itemid.'&fcid='.$rec->id);
                $addparticularlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditparticular&eon='.$eon.'&fstid='.$fstid.'&Itemid='.$Itemid.'&fcid='.$rec->id);
?>
        	<tr>
                 	<td><?php echo $i; ?></td>
                 	<td>
				<b><?php echo $rec->name; ?></b>
			<?php
				if($eon=="1" && $eon_ok=="1"){ ?>
					<a href="<?php echo $editlink; ?>"><img src="<?php echo $iconsDir.'/edit.png'; ?>" alt="EditCategory" style="width: 20px; height: 20px;" /></a>
					<a href="<?php echo $deletelink; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="DeleteCategory" style="width: 20px; height: 20px;" /></a>
			<?php	}
			?>
			<?php if($eon=="1" && $eon_ok=="1"){  ?>
					<a style="align:right;" href="<?php echo $addparticularlink; ?>"><img src="<?php echo $iconsDir.'/assign.png'; ?>" alt="Particulars" style="width: 20px; height: 20px;" /></a>
					<button class="btn btn-small btn-warning" value="Save" name="Save"> <i class="icon-edit icon-white"></i> Save</button>
			<?php } ?>
			<br />[<?php echo $rec->description; ?>]<br />
			<table width="100%" border="0">
			<?php
				$precs=$model->getFeeParticulars($rec->id);
				$j=1;
				$psum=0;
				foreach($precs as $prec){
					echo '<tr style="border:0px;" >';
					echo '<td width="5%" style="border:0px;">';
					echo '</td>';
					echo '<td width="8%" style="border:0px;">';
					if($eon=='1' && $eon_ok=="1"){
                       			$pdeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeeparticular&layout=feecategory&eon='.$eon.'&fstid='.$fstid.'&Itemid='.$Itemid.'&fpid='.$prec->id);
                       			$peditlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditparticular&accountid='.$prec->accountid.'&eon='.$eon.'&fstid='.$fstid.'&Itemid='.$Itemid.'&fpid='.$prec->id);
					?>
					<a href="<?php echo $peditlink; ?>"><img src="<?php echo $iconsDir.'/edit.png'; ?>" alt="EditParticular" style="width: 20px; height: 20px;" /></a>
					<a href="<?php echo $pdeletelink; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="DeleteParticular" style="width: 20px; height: 20px;" /></a>
					<?php
					}
					echo $j++;
					echo '</td>';
					echo '<td width="25%" style="border:0px;">';
					echo $prec->name.'('.$prec->description.')';
					echo '</td>';
					echo '<td width="15%"  style="text-align:right;font: 13px verdana, serif;" >';
					if($eon=="1" && $eon_ok=="1")
						echo '<input type="text" maxlength="7" style="text-align:right;width:100px;" value="'.$prec->amount.'" width="100px" name="test['.$prec->id.']" />';
					else echo  money_format("%i", $prec->amount);
					$psum=$psum+$prec->amount;
					echo '</td>';
					echo '<td width="30%" style="border:0px;">';
				if($prec->groupbased==1){  
					$grecs = $model->getFeeParticularGroups($prec->id);			
					//$grecs = $model->getFeeCategoryGroups($rec->id);			
					foreach($grecs as $grec){
		                     		$groupdeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&fcid='.$rec->id.'&eon='.$eon.'&controller=fees&task=deletefeeparticulargroup&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid.'&gid='.$grec->id.'&fpid='.$prec->id);
						if($eon=="1" && $eon_ok=="1") { ?> 
							(<a href="<?php echo $groupdeletelink; ?>">X</a>) 
					<?php 	}  
						echo $grec->groupcode.'&nbsp;&nbsp;&nbsp;&nbsp;'; 	
					}
					if($eon=="1" && $eon_ok=="1")  { 
						$assigngrouplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&eon='.$eon.'&layout=assignparticulargroups&fstid='.$fstid.'&fpid='.$prec->id.'&Itemid='.$Itemid);
					?>	<a class="btn btn-mini btn-success" href="<?php echo $assigngrouplink; ?>"><i class="icon-plus-sign icon-white"></i></a> 
				<?php 
					}
				}
				else if($prec->groupbased==0){  
					$crecs = $model->getFeeCategoryParticularCourses($prec->id);
					//$crecs = $model->getFeeCategoryCourses($rec->id);
	                                $count=1;
        	                        foreach($crecs as $crec){
                	                        $pcoursedeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&fcids='.$ffff.'&eon='.$eon.'&controller=fees&task=deletefeecourseparticular&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid.'&cid='.$crec->id.'&fpid='.$prec->id);
                        	                if($eon=="1" && $eon_ok=="1") {
                                        		 echo ' (<a href="'. $pcoursedeletelink.'">X</a>)';
 	                                       }
        	                                echo $crec->code.'&nbsp;&nbsp;&nbsp;';
                	                        if($count==5){
                        	                        echo '<br />';
                                	                $count=0;
                                        	}
                                        	$count++;
                                	}
                ?>
<?php
                                if($eon=="1" && $eon_ok=="1"){
                                        $assignlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&eon='.$eon.'&flag=particular&layout=assigncourses&fstid='.$fstid.'&fpid='.$prec->id.'&Itemid='.$Itemid);
?>
                                                <a class="btn btn-mini btn-success" href="<?php echo $assignlink; ?>"><i class="icon-plus-sign icon-white"></i></a>
<?php                                   
                                }

				}
					echo '</td>';
					echo '</tr>';
				}
				echo '<tr style="border:0px;" >';
				echo '<td></td><td></td><td >Total Amount</td><td style="text-align:right;font: bold 13px verdana, serif;">'.money_format("%i",$psum).'</td><td></td>';
				echo '</tr>';
				
			?>
			</table>
		</td>
                 <td>
		<?php
			//To add specific groups
			if($rec->groupbased=="1"){
				$grecs = $model->getFeeCategoryGroups($rec->id);			
				foreach($grecs as $grec){
	                       		$groupdeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&fcid='.$rec->id.'&eon='.$eon.'&controller=fees&task=deletefeegroup&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid.'&gid='.$grec->id.'&fcid='.$rec->id);
					if($eon=="1" && $eon_ok=="1") { ?> 
						(<a href="<?php echo $groupdeletelink; ?>">X</a>) 
				<?php 	}  
					echo $grec->groupcode.'&nbsp;&nbsp;&nbsp;&nbsp;'; 	
				}
				echo '<br />';
				if($eon=="1" && $eon_ok=="1"){  
					$assigngrouplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&eon='.$eon.'&layout=assigngroups&fstid='.$fstid.'&fcid='.$rec->id.'&Itemid='.$Itemid);
					?><a class="btn btn-mini btn-success" href="<?php echo $assigngrouplink; ?>"><i class="icon-plus-sign icon-white"></i>Assign Group</a> <?php
				}
			}else{
				$crecs = $model->getFeeCategoryCourses($rec->id);			
				$count=1;
				foreach($crecs as $crec){
                	       		$coursedeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&fcids='.$ffff.'&eon='.$eon.'&controller=fees&type=1&task=deletefeecourse&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid.'&cid='.$crec->id.'&fcid='.$rec->id);
                	       		$coursedeletelink1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&fcids='.$rec->id.'&eon='.$eon.'&controller=fees&type=2&task=deletefeecourse&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid.'&cid='.$crec->id.'&fcid='.$rec->id);
                	       		//$coursedeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&fcids='.$ffff.'&eon='.$eon.'&controller=fees&task=deletefeecourse&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid.'&cid='.$crec->id.'&fcid='.$rec->id);
					if($eon=="1" && $eon_ok=="1") {	
						if($i==1) { 
							echo '(<a href="'.$coursedeletelink.'">X</a>) ';
					 	}else{
							echo '(<a href="'.$coursedeletelink1.'">X</a>) ';
						}
					}  
					echo $crec->code.'&nbsp;&nbsp;&nbsp;&nbsp;'; 	
					if($count==2){
						echo '<br />';
						$count=0;
					}
					$count++;
				}
		?>
                		 <br />
				<br />
<?php
				if($eon=="1" && $eon_ok=="1"){  
                  			$assignlink1= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&eon='.$eon.'&layout=assigncourses&fstid='.$fstid.'&fcids='.$ffff.'&Itemid='.$Itemid);
                  			$assignlink2= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&eon='.$eon.'&layout=assigncourses&fstid='.$fstid.'&fcids='.$rec->id.'&Itemid='.$Itemid);
					if($i==1){
?>
						<a class="btn btn-mini btn-success" href="<?php echo $assignlink1; ?>"><i class="icon-plus-sign icon-white"></i>Assign Courses</a>
<?php 					}else{
?>
						<a class="btn btn-mini btn-success" href="<?php echo $assignlink2; ?>"><i class="icon-plus-sign icon-white"></i>Assign Courses</a>
<?php 					}
				}  
}?>
			</td>
       	 	</tr>
        <?php
		$i++;
	}
	}else{?>
               <tr> 
		<td align="center">-</td>
		<td>-</td>
		<td>-</td>
	      </tr>
<?php 
	}
?>
	</tbody>
       </table>            

	<input type="hidden" name="view" value="fees" />
	<input type="hidden" name="controller" value="fees" />
	<input type="hidden" name="layout" value="feecategory" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="fstid" value="<?php echo $fstid; ?>" />
	<input type="hidden" name="cmdf" value="<?php echo '5'; ?>" />
	<input type="hidden" name="eon" value="<?php echo $eon; ?>" />
	<input type="hidden" name="task" value="savefeeparticulars1" />
      </form>
     </div>
   </div><!--/row-->
</div><!--/row-->
						
