<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
		JHTML::script('validate.js', 'components/com_cce/js/');
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$model = & $this->getModel('managesubjects');
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
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=courses&Itemid='.$masterItemid);
   	$mlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=subjects&view=subjects&task=display&layout=courses&Itemid='.$masterItemid);
?>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> List of Subjects</h2>
						<div class="box-icon">
						<button class="btn btn-small btn-success" name="Assign" value="Assign"><i class="icon-plus-sign"></i> Assign</button>        
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
									<th width="45%">Subject Title</th>
									<th width="20%">Subject Code</th>
									<th width="20%">Acronym</th>
									<th width="10%">Credits</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php

                foreach($this->subjects as $rec) {
        ?>
        <tr>
                <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
                <td><?php echo $rec->subjecttitle; ?></td>
                <td><?php echo $rec->subjectcode; ?></td>
                <td><?php echo $rec->acronym; ?></td>
                <td><?php echo $rec->credits; ?></td>
        </tr>
        <?php } ?>
							 </tbody>
					  </table>  
					  				<div class="form-actions">
						<div class="pull-right">
						<button class="btn btn-small btn-success" name="Assign" value="Assign"><i class="icon-plus-sign"></i> Assign</button>        
					
						</div>
						</div>          
			</div>
              
				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="controller" value="subjects" />
<input type="hidden" name="view" value="addsubject" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="task" value="assignsubjects"/>
</form>

