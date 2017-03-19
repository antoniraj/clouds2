<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$subjectid= JRequest::getVar('subjectid');
	$termid= JRequest::getVar('termid');
	$cbid= JRequest::getVar('cbid');
	
	setlocale(LC_MONETARY,"en_IN");
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('exams');
	$gbs = $model->getTGradeBooks();

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Exams');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);



?>

<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> GRADE BOOKS </h2>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<th width="4%"><B>Sno</B></th>
					<th width="25%" ><B>Title</B></th>
					<th width="25%" ><B>Option</B></th>
				</thead>
				<tbody>
				<?php
					$i=1;
					foreach($gbs as $gbrec){
   						$subjectgradebooklink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=exams&view=exams&task=savesubjectgradebook&subjectid='.$subjectid.'&termid='.$termid.'&gbid='.$gbrec->id.'&cbid='.$cbid.'&Itemid='.$Itemid);
						echo '<tr>';
						echo '<td>'.$i++.'</td>';
						echo '<td>'.$gbrec->title.'</td>';
						echo '<td><a class="btn btn-small btn-info" style="width:50px;" href="'.$subjectgradebooklink.'"><i class="icon-plus-sign"></i>Select</a></td>';
						echo '</tr>';
					}
				?>
				</tbody>
			</table>
		</div>
  	</div>
</div>

