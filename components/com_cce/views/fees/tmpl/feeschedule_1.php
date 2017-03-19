<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');

	$feecategories = $model->getFeeCategories();


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
        $pathway->addItem('Fee Schedule');

?>

<b style="font: bold 15px Georgia, serif;">FEE COLLECTION SCHEDULE</b>
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-content">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
							<th>SNO</th>
							<th width="40%">FEE CATEGORY</th>
							<th>FEE SCHEDULE</th>
							  </tr>
						  </thead>   
						  <tbody>
  <?php
                if($feecategories){
		   $i=1;
                   foreach($feecategories as $rec) {
        ?>
        <tr>
                 <td><?php echo $i; ?></td>
                 <td>
			<b><?php echo $rec->name; ?></b>
			<br />[<?php echo $rec->description; ?>]<br />
			<table>
			<?php
				$precs=$model->getFeeParticulars($rec->id);
				$j=1;
				foreach($precs as $prec){
					echo '<tr style="border:0px;" >';
					echo '<td width="5%" style="border:0px;">';
					echo '</td>';
					echo '<td width="5%" style="border:0px;">';
					echo $j++;
					echo '</td>';
					echo '<td width="60%" style="border:0px;">';
					echo $prec->name.'('.$prec->description.')';
					echo '</td>';
					echo '<td width="30%" align="right" style="border:0px;">';
					echo $prec->amount;
					echo '</td>';
					echo '<td style="border:0px;">';
					?>
					<?php
					
					echo '</td>';
					echo '</tr>';
				}
			?>
			</table>
		<br />
		</td>
                 <td>
		<?php
			if($rec->groupbased=="1")
				$crecs = $model->getFeeCategoryGroups($rec->id); 
			else
				$crecs = $model->getFeeCategoryCourses($rec->id); 
		?>
			<table>
			<tr style="border:0px;"><td style="border:0px;">Class</td><td style="border:0px;">Date</td><td style="border:0px;">Late Fee</td><td style="border:0px;">Operation</td></tr>
			<?php
			foreach($crecs as $crec){  
				if($rec->groupbased=="1")
					$r = $model->getGroupFeeSchedule($crec->id,$rec->id,$frec);
				else
					$r = $model->getFeeSchedule($crec->id,$rec->id,$frec);
				if($r){
					$fsid=$frec->id;
					$fdate=$frec->fdate;
					$fine = $frec->fine;	
				}else{
					$fsid='';
					$fdate='---';
					$fine = '0';	
				}
				?>
				<form class="form-horizontal" action="<?php echo JRoute::_('index.php'); ?>" method="POST" name="adminForm">
				<?php
                       		$coursedeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeecourse&layout=feecategory&Itemid='.$Itemid.'&cid='.$crec->id.'&fcid='.$rec->id);
				?>
				<tr style="border:0px;">
					<td style="border:0px;">
				<?php	
					if($rec->groupbased=="1")
						echo $crec->groupcode;
					else
						echo $crec->code; 	
				?>
					</td>
					<td style="border:0px;">
					<input type="text" name="fdate" class="datepicker" id="<?php echo $crec->id.$rec->id; ?>" value="<?php echo JArrayHelper::indianDate($fdate); ?>">
					</td>
					<td style="border:0px;">
						<input type="text" name="fine" size="7" value="<?php echo $fine; ?>" size="5" />
					</td>
					<td style="border:0px;">
						<button class="btn btn-small btn-success" name="save" value="Save"><i class="icon-plus-sign icon-white"></i> Save</button>
					</td>
				</tr>
	<?php 
		if($rec->groupbased=="1") {
			$courseid='-';   
			$gid=$crec->id;
		}else{
			$courseid=$crec->id;
			$gid='-';
		}
		
	echo '<input type="hidden" name="courseid" value="'.$courseid.'" />';
	?>
	<input type="hidden" name="fcid" value="<?php echo $rec->id; ?>" />
	<input type="hidden" name="gid" value="<?php echo $gid; ?>" />
	<input type="hidden" name="fsid" value="<?php echo $fsid; ?>" />
        <input type="hidden" id="view" name="view" value="fees" />
        <input type="hidden" id="controller" name="controller" value="fees" />
        <input type="hidden" name="task" id="task" value="savefeeschedule" />
        <input type="hidden" name="layout" id="layout" value="feeschedule" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
				</form>
				<?php
			}
		?>
			</table>
		 </td>
        </tr>
        <?php
		$i++;
                  }
                }else{?>
                <tr> <td colspan="4" align="center">...Nil.... </td></tr>
                <?php }
         ?>
							 </tbody>
					  </table>            
					</div>
                     
				</div><!--/span-->
			
			</div><!--/row-->
						


