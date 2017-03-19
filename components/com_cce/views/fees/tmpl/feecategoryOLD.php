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
        $pathway->addItem('Fee Categories');
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
			<h1 class="item-page-title" align="left">Fees Management</h1>
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

<b style="font: bold 15px Georgia, serif;">FEE CATEGORIES AND PARTICULARS</b>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>SNO</th>
								  <th>FEE CATEGORY</th>
								  <th>COURSES</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
                if($feecategories){
		   $i=1;
                   foreach($feecategories as $rec) {
                       $assignlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=assigncourses&fcid='.$rec->id.'&Itemid='.$Itemid);
                       $deletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeecategory&layout=feecategory&Itemid='.$Itemid.'&fcid='.$rec->id);
                       $editlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditfeecategory&Itemid='.$Itemid.'&fcid='.$rec->id);
                       $addparticularlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditparticular&Itemid='.$Itemid.'&fcid='.$rec->id);
        ?>
        <tr>
                 <td><?php echo $i; ?></td>
                 <td>
			<b><?php echo $rec->name; ?></b>
			<a href="<?php echo $editlink; ?>"><img src="<?php echo $iconsDir.'/edit.png'; ?>" alt="EditCategory" style="width: 20px; height: 20px;" /></a>
			<a href="<?php echo $deletelink; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="DeleteCategory" style="width: 20px; height: 20px;" /></a>
			<br />[<?php echo $rec->description; ?>]<br />
			<table>
			<?php
				$precs=$model->getFeeParticulars($rec->id);
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
                       			$pdeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeeparticular&layout=feecategory&Itemid='.$Itemid.'&fpid='.$prec->id);
                       			$peditlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditparticular&Itemid='.$Itemid.'&fpid='.$prec->id);
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
		<a style="align:right;" href="<?php echo $addparticularlink; ?>"><img src="<?php echo $iconsDir.'/assign.png'; ?>" alt="Particulars" style="width: 20px; height: 20px;" />Add Particular</a>
		</td>
                 <td>
		<?php
			$crecs = $model->getFeeCategoryCourses($rec->id);			
			$count=1;
			foreach($crecs as $crec){
                       		$coursedeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeecourse&layout=feecategory&Itemid='.$Itemid.'&cid='.$crec->id.'&fcid='.$rec->id);
				?>(<a href="<?php echo $coursedeletelink; ?>">X</a>) <?php echo $crec->code.'&nbsp;&nbsp;&nbsp;&nbsp;'; 	
				if($count==2){
					echo '<br />';
					$count=0;
				}
				$count++;
			}
		?>
                 <br />
		<br />
		<a class="btn btn-mini btn-success" href="<?php echo $assignlink; ?>">
		<i class="icon-plus-sign icon-white"></i>  
		Assign Courses                                          
		</a>
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
					  <div style="width:100%;">
						 <div style="float:left;"></div>
							<div style="float:right;">
							
							  <a class="btn btn-info" href="<?php echo $addlink; ?>"><i class="icon-plus-sign icon-white"></i>Add Category</a>
	                         </div> 
					         <br>
					         <br>
	                 </div>
				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="view" value="academicyears" />
<input type="hidden" name="controller" value="academicyears" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>



