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
        defined('_JEXEC') or die('Denied..');
	$app = JFactory::getApplication();
	$iconsdir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
    $library = JURI::base() . 'components/com_cce/images/library/';
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

   	$model = & $this->getModel();

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
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&task=display&layout=settings&Itemid='.$masterItemid);

  	$aylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=academicyears&view=academicyears&task=display&Itemid='.$ayItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $library.'/bookcategory.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Add Book Category </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/libsettings.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
			</div>
                </td>
        </tr>
</table>
<form class="form-horizontal" action="index.php" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Book Category</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Category</th>
								  <th>Delete</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
		
					foreach($this->cat as $rec) {
                		?>
							  
							<tr>
								
								<td><?php echo $rec->categoryname; ?></td>
								<td class="center">
											<input type="hidden" name="cid" id="cid" value="<?php echo $rec->id; ?>" />
								
										<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
				
								</td>
							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>            
					</div>
                     
					  <div style="width:100%;">
						<div style="float:right;">
							
							<a href="#" class="btn btn-info btn-setting">Add Category</a>
	                    </div> 
					         <br>
					         <br>
	                 </div>
				</div><!--/span-->
			
			</div><!--/row-->
			<input type="hidden" name="id" value="<?php echo $rec->cat->id; ?>" />
			<input type="hidden" name="view" value="librarysettings" />
			<input type="hidden" name="controller" value="librarysettings" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
			<input type="hidden" name="task" value="delete"/>
			<input type="hidden" name="layout" value="bookcategory"/>
			</form>


<!-- Dialog -->
	<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Add Category</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php" method="POST" name="adminForm">
				<div class="control-group">
								<label class="control-label" for="focusedInput">Category Name</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="category" value="<?php echo $rec->category; ?>">
								</div>
						</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<button class="btn btn-primary"  value="Save" id="submit" name="submit">Save</button>
		    <input type="hidden" name="view" value="librarysettings" />
			<input type="hidden" name="controller" value="librarysettings" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
			<input type="hidden" name="task" value="save"/>
			<input type="hidden" name="layout" value="bookcategory"/>
			</form>
			</div>

		</div>

