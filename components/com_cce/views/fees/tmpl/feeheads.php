<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');

	$feecategories = $model->getFeeCategories_tt();


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
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);
   	//$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);

//Add Fee Category
        $addlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&layout=addeditfeecategoryt&Itemid='.$Itemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        //$pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Settings',$modulelink);
        $pathway->addItem('Fee Heads');
?>

<b style="font: bold 15px Georgia, serif;">FEE HEADS AND PARTICULARS</b>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="pull-right">
	<a class="btn btn-info" href="<?php echo $addlink; ?>"> <i class="icon-plus-sign icon-white"></i>  Add Fee Head</a>
</div>
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>SNO</th>
								  <th>FEE HEADS WITH PARTICULARS</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
                if($feecategories){
		   $i=1;
                   foreach($feecategories as $rec) {
                       $deletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeecategory_t&layout=feeheads&Itemid='.$Itemid.'&fcid='.$rec->id);
                       $editlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditfeecategoryt&eon='.$eon.'&Itemid='.$Itemid.'&fcid='.$rec->id);
                       $addparticularlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditparticulart&Itemid='.$Itemid.'&fcid='.$rec->id);
        ?>
        <tr>
                 <td><?php echo $i; ?></td>
                 <td>
			<b><?php echo $rec->name; ?></b>
			<a href="<?php echo $editlink; ?>"><img src="<?php echo $iconsDir.'/edit.png'; ?>" alt="EditCategory" style="width: 20px; height: 20px;" /></a>
			<a href="<?php echo $deletelink; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="DeleteCategory" style="width: 20px; height: 20px;" /></a>
		<a style="align:right;" href="<?php echo $addparticularlink; ?>"><img src="<?php echo $iconsDir.'/assign.png'; ?>" alt="Particulars" style="width: 20px; height: 20px;" /></a>
			<br />[<?php echo $rec->description; ?>]<br />
			<table>
			<?php
				$precs=$model->getFeeParticulars_t($rec->id);
				$j=1;
				foreach($precs as $prec){
					echo '<tr style="border:0px;" >';
					echo '<td width="10%" style="border:0px;">';
					echo '</td>';
					echo '<td width="10%" style="border:0px;">';
					echo $j++;
					echo '</td>';
					echo '<td width="40%" style="border:0px;">';
					echo $prec->name.'('.$prec->description.')';
					echo '</td>';
					echo '<td width="20%" align="right" style="border:0px;">';
					echo $prec->amount;
					echo '</td>';
                       			$pdeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeeparticular_t&layout=feeheads&Itemid='.$Itemid.'&fpid='.$prec->id);
                       			$peditlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditparticulart&accountid='.$prec->accountid.'&Itemid='.$Itemid.'&fpid='.$prec->id);
					echo '<td style="border:0px;">';
					?>
					<a href="<?php echo $peditlink; ?>"><img src="<?php echo $iconsDir.'/edit.png'; ?>" alt="EditParticular" style="width: 20px; height: 20px;" /></a>
					<a href="<?php echo $pdeletelink; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="DeleteParticular" style="width: 20px; height: 20px;" /></a>
					<?php
					
					echo '</td>';
					echo '</tr>';
				}
			?>
			</table>
		<br />
		</td>
        </tr>
        <?php
		$i++;
                  }
                }else{?>
                <tr> <td  align="center">...</td><td></td></tr>
                <?php }
         ?>
	
							 </tbody>
					  </table>            
					</div>
                     
					  <div style="width:100%;">
						 <div style="float:left;"></div>
							<div style="float:right;">
							
							  <a class="btn btn-info" href="<?php echo $addlink; ?>"> <i class="icon-plus-sign icon-white"></i>  Add Fee Head</a>
	                         </div> 
					         <br>
					         <br>
	                 </div>
				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>



