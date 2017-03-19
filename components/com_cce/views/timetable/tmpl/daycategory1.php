

<?php
        defined('_JEXEC') or die('Denied..');
	$app = JFactory::getApplication();
	$iconsdir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
        $app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
        $pathway->addItem('Academic Year');
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

   	$ayItemid = $model->getMenuItemid('master','Academic Years');
   	if($ayItemid) ;
   	else{
        	$ayItemid = $model->getMenuItemid('manageschool','Home');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$aylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=academicyears&view=academicyears&task=display&Itemid='.$ayItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsdir.'/academicyears.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Academic Years </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1master.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
			</div>
                </td>
        </tr>
</table>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Academic Years</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
								  <th>Academic Year</th>
								  <th>Start Date</th>
								  <th>End Date</th>
								  <th>Current</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
					foreach($this->years as $rec) {
                        $link2 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=academicyears&controller=academicyears&task=setcurrent&Itemid='.$Itemid.'&cid[]='.$rec->id);
						?>
							  
							<tr>
								<td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
								<td><?php echo $rec->academicyear; ?></td>
								<td class="center"><?php echo JArrayHelper::indianDate($rec->startdate); ?></td>
								<td class="center"><?php echo JArrayHelper::indianDate($rec->stopdate); ?></td>
								<td class="center">
									<a class="btn btn-success" href="<?php echo $link2; ?>">
										<i class="icon-zoom-in icon-white"></i>  
										<?php echo $rec->status; ?>                                           
									</a>
						
								</td>
							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>  

					  				<div class="form-actions">
						<div class="pull-right">
						<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Add</button>        
						<button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit icon-white"></i> Edit</button>
						<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
				
						</div>
						</div>          
			</div>
              
				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="view" value="academicyears" />
<input type="hidden" name="controller" value="academicyears" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>

