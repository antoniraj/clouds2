
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
           <img src="<?php echo $library1.'/movementlog.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Movement Log </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 28px; height: 28px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $library; ?>"><img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="Master" style="width: 30px; height: 30px;" /></a><br />
			</div>

                </td>
        </tr>
</table>

<form class="form-horizontal" action="index.php" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Movement Log</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								   <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
								  <th>Book No</th>
								   <th>Roll No</th>
								  <th>Borrowed By</th>
								  <th>Status</th>
								  <th>Issue Date</th>
								  <th>Due Date</th>
							  </tr>
						  </thead>   
						  <tbody>
					<?php
					$st = $model->getbookstatus($status);
					foreach($status as $rec) {
						$st = $model->getStudentbyrollno($rec->regno,$student);
                 		?>
							  
							<tr>
								 <td><input type="checkbox"  name="cid[]" value="<?php echo $rec->id; ?>" /></td>
								<td><?php echo $rec->bookno; ?></td>
								<td><?php echo $rec->regno; ?></td>
								<td><?php echo $student->firstname.''.$student->middlename; ?></td>
								<td><?php 
								if($rec->status==1)
								{
									echo '<span class="label label-important">Issued</span>'; 
								
								}
								else{
									echo '<span class="label label-warning">Renewed</span>';
								}	
									?></td>
							    <?php 
								if($rec->status==1)
								{
									$sta = $model->getissueddate($rec->ref_id,$issue);
									echo '<td>'.JArrayHelper::indianDate($issue->issuedate).'</td>';
									echo '<td>'.JArrayHelper::indianDate($issue->duedate).'</td>';
								}
								else{
								  $sta = $model->getrenewaldetails($rec->ref_id,$renewed);
								  echo '<td>'.JArrayHelper::indianDate($renewed->renewaldate).'</td>';
									echo '<td>'.JArrayHelper::indianDate($renewed->duedate).'</td>';
								  
								}	
									?>

							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>            
					</div>
                     
				<div class="span4">
						<button type="submit" class="btn btn-small btn-danger" name="Delete" value="Delete">Delete</button>
						<Br>
						<br>
				</div>
				
				</div><!--/span-->
			
			</div><!--/row-->
		
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
							<input type="hidden" id="view" name="view" value="librarymanagebooks" />
							<input type="hidden" id="controller" name="controller" value="librarymanagebooks" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="deletemovement" />
							<input type="hidden" name="layout" id="layout" value="movementlog" />	
</form>

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

