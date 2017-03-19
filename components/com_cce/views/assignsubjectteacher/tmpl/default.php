<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$courseid = JRequest::getVar('courseid');
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

   	$stItemid = $model->getMenuItemid('master','Subject Teachers');
   	if($stItemid) ;
   	else{
        	$stItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=courses&Itemid='.$masterItemid);

  	$stlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=subjects&view=subjectteachers&task=display&courseid='.$courseid.'&Itemid='.$stItemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Courses',$modulelink);
        $pathway->addItem('Subject Teachers',$stlink);
        $pathway->addItem('Assign Teachers');


?>


<br />
<?php
  $l=JRoute::_('index.php?option=com_cce&controller=subjects&view=subjectteachers&task=save&courseid='.$this->courseid.'&subjectid='.$this->subjectid); 
?>
<?php 
$model1=$this->getModel('managesubjects');

 $model1->getMSubject($this->subjectid,$rec);
 echo "<h3 class=\"item-page-title\">Subject:&nbsp;[$rec->subjectcode]".$rec->subjecttitle."</h3>";
 
?>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">

	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> List of Staffs</h2>
						<div class="box-icon">
							<div class="pull-right">
							<button class="btn btn-small btn-success" name="Add" value="Assign"><i class="icon-plus-sign"></i> Assign</button>        
							</div>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
									  <th width="">StaffCode</th>
										<th width="">StaffName</th>
										<th width="">Department</th>
										<th width="">email</th>
							  </tr>
						  </thead>   
						  <tbody>
        <?php
		if($this->staffs){
                   foreach($this->staffs as $rec) {
                       // $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffs&controller=staffs&task=edit&cid[]='.$rec->id);
        ?>
        <tr>
                 <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
                 <td><?php echo $rec->staffcode; ?></td>
                 <td><?php echo "$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname"; ?></td>
                 <td><?php echo $rec->department; ?></td>
                 <td><?php echo $rec->email; ?></td>
        </tr>
        <?php 
		  }
		}
	 ?>
							 </tbody>
					  </table>  
					  				<div class="form-actions">
						<div class="pull-right">
						<button class="btn btn-small btn-success" name="Add" value="Assign"><i class="icon-plus-sign"></i> Assign</button>        
						</div>
						</div>          
			</div>
              
				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="controller" value="subjects" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="subjectid" value="<?php echo $this->subjectid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" id="view" name="view" value="subjectteachers" />
<input type="hidden" name="task" id="task" value="save" />
</form>


