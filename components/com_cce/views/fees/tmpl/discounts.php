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

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Discounts');

?>
<!--
TOP LINKS....DASHBOARD
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/fees.png'; ?>" alt="" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Fee Discounts Management</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir.'/fees.png'; ?>" alt="Fees" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>

-->

<b style="font: bold 15px Georgia, serif;">FEE DISCOUNTS FOR EACH CATEGORY OF STUDENTS</b>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						<tr>
						<th>SNO</th>
						<th>FEE CATEGORY</th>
						<th>DISCOUNTS</th>
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
			<b><?php 
				$fsrecs=$model->getFeeStructureByFeeCategory($rec->id);
				echo $rec->name.'['.$fsrecs[0]->title.']'; 
				
			?></b><br />
			<?php echo $rec->description; ?>
		</td><td>
			<table>
			<?php
                       		$adddiscountlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&layout=addeditdiscount&fcid='.$rec->id.'&Itemid='.$Itemid);
				$drecs=$model->getFeeCategoryDiscounts($rec->id);
				$j=1;
				foreach($drecs as $drec){
					$model->getCourse($drec->cid,$crec);
					$model->getStudentCategory($drec->scid,$srec);


					echo '<form action="index.php" method="post" name="adminform">';
					echo '<tr style="border:0px;" >';
					echo '<td width="10%" style="border:0px;">';
					echo '</td>';
					echo '<td width="10%" style="border:0px;">';
					echo $j++;
					echo '</td>';
					echo '<td width="20%" style="border:0px;">';
					echo $crec->code;
					echo '</td>';
					echo '<td width="20%" style="border:0px;">';
					echo $srec->categorycode;
					echo '</td>';
					echo '<td width="20%" align="right" style="border:0px;">';
					echo '<input style="width:50px;" type="text" id="discount" name="discount" value="'.$drec->discount.'">%';
					echo '</td>';
                       			$ddeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeediscount&layout=discounts&Itemid='.$Itemid.'&fdid='.$drec->id);
                       			$deditlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditdiscount&Itemid='.$Itemid.'&fdid='.$drec->id);
					echo '<td align="right" style="border:0px;">';
?>
        				<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
				        <input type="hidden" id="fdid" name="fdid" value="<?php echo $drec->id; ?>" />
				        <input type="hidden" id="view" name="view" value="fees" />
				        <input type="hidden" id="controller" name="controller" value="fees" />
				        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
				        <input type="hidden" name="task" id="task" value="updatediscount" />
				        <input type="hidden" name="layout" id="layout" value="discounts" />

					<button class="btn btn-small btn-info" value="Update" name="updatediscount"> <i class="icon-edit"></i> Update</button>
					
					<a href="<?php echo $ddeletelink; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="DeleteDiscount" style="width: 20px; height: 20px;" /></a>
					<?php
					
					echo '</td>';
					echo '</tr>';
					echo '</form>';
				}
			?>
			</table>
		<br />
		<div class="span4" align="left"> <a class="btn btn-mini btn-warning" href="<?php echo $adddiscountlink; ?>">
										<i class="icon-plus-sign icon-white"></i>  
										Add Discounts                                          
									</a></div>
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
                     

	                 </div>
				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="view" value="academicyears" />
<input type="hidden" name="controller" value="academicyears" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>


