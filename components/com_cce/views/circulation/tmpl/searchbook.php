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
    $library1 = JURI::base() . 'components/com_cce/images/library/';
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
   	$library= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=library&Itemid='.$masterItemid);
	$managebooks= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&task=display&layout=managebooks&Itemid='.$masterItemid);

  	$aylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=academicyears&view=academicyears&task=display&Itemid='.$ayItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $library1.'/listbook.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> List Book details </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 28px; height: 28px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $library; ?>"><img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="Master" style="width: 30px; height: 30px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $managebooks; ?>"><img src="<?php echo $library1.'/listbook.png'; ?>" alt="Master" style="width: 28px; height: 28px;" /></a><br />
			</div>
			
                </td>
        </tr>
</table>

<form class="form-horizontal" action="index.php" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Book Details</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
							<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								   <th>Book No</th>
								  <th>ISBN</th>
								  <th>Book Name</th>
								  <th>Author</th>
								  <th>Edition</th>
								  <th>Publisher</th>
								   <th>Total Copies</th>
								  <th>Available</th> 
								   <th>Status</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
					foreach($this->books as $rec) {
							$st = $model->getbookstatusbykey($rec->bookno,$status);
							$totalbook = $model->counttotalbooks($rec->isbn,$tbooks);
                 		?>
							  
							<tr>
								<td><?php echo $rec->bookno; ?></td>
								<td><?php echo $rec->isbn; ?></td>
								<td><?php echo $rec->title; ?></td>
								<td><?php echo $rec->author; ?></td>
								<td><?php echo $rec->edition; ?></td>
								<td><?php echo $rec->publisher; ?></td>
								<td><?php echo $tbooks->total; ?></td>
								<td><?php echo $tbooks->total; ?></td>
								<td><?php 
								if($status->status==1)
								{
									echo '<span class="label label-important">Issued</span>'; 
								
								}
								else if($status->status==2){
									echo '<span class="label label-warning">Renewed</span>';
								}
								else{
									echo '<span class="label label-success">Available</span>';
								}
									?></td>
								
							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>      
					</div>
                     

				</div><!--/span-->
			
			</div><!--/row-->
						

</form>



