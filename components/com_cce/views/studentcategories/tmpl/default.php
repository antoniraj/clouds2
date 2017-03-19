<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
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

   	$scItemid = $model->getMenuItemid('master','Student Categories');
   	if($scItemid) ;
   	else{
        	$scItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$sclink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentcategories&view=studentcategories&task=display&Itemid='.$scItemid);
?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/studentcategories.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Student Categories</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1master.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>


<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Student Categoires</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Option</th>
								  <th>Student Category Name</th>
								  <th>Student Category Code</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
					foreach($this->cats as $rec) {
                     	?>
							  
							<tr>
								<td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
								<td><?php echo $rec->categoryname; ?></td>
								<td><?php echo $rec->categorycode; ?></td>
							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>  
					  	 <div class="form-actions">
						<div class="pull-right">
						<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>        
						<button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
						<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
				 		</div>
					</div>                
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
				<input type="hidden" name="controller" value="studentcategories" />
				<input type="hidden" name="view" value="studentcategories" />
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="actions"/>
	</form>		


