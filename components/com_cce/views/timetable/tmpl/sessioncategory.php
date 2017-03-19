<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('timetable');

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Time Table');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);

//Add Session Category
        $addlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&layout=addeditsession&Itemid='.$Itemid);
 
?>

<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header well" data-original-title>
                    <h2><i class="icon-edit"></i>Session Timings</h2>
				<div class="pull-right">
		    <a class="btn btn-small btn-primary" href="<?php echo $addlink; ?>"><i class="icon-plus-sign icon-white"></i>Add Session</a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
			<thead>
				<tr>
					<th class="list-title" width="15%">SESSION TITLE</th>
					<th class="list-title" width="5%">CODE</th>
					<th class="list-title" width="15%">START</th>
					<th class="list-title" width="15%">STOP</th>
					<th class="list-title" width="10%">BREAK?</th>
					<th class="list-title" width="20%">OPTIONS</th>
				</tr>
			</thead>   
			<tbody>
			<?php
			$sessions = $model->getSessions();
                	if($sessions){
		   		$i=1;
                   		foreach($sessions as $serec) {
                       			$deletetiming = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=deletesession&layout=sessiontimings&scid='.$scid.'&Itemid='.$Itemid.'&stid='.$serec->id);
                       			$edittiming = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=addeditsession&scid='.$scid.'&Itemid='.$Itemid.'&stid='.$serec->id);
        		?>
			<tr>
                 		<td>
					<?php echo $serec->title; ?>
				</td>
                 		<td> <?php echo $serec->code; ?> </td>
                 		<td> <?php echo $serec->start; ?> </td>
                 		<td> <?php echo $serec->stop; ?> </td>
                 <td> <?php 
			if($serec->break==1)
				echo 'Yes';
			else
				echo 'No'; 
	      ?> </td>
                 		<td align="center">
					<a href="<?php echo $edittiming; ?>"><img src="<?php echo $iconsDir.'/edit.png'; ?>" alt="EditTiming" style="width: 20px; height: 20px;" /></a>
					<a href="<?php echo $deletetiming; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="DeleteTiming" style="width: 20px; height: 20px;" /></a>
				</td>
        		</tr>
        		<?php
				$i++;
                  		}
                	}
			?>
			 </tbody>
		</table>  
		</div>
	</div><!--/ session span end-->
</div><!--/row-->

