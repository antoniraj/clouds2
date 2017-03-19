<?php

        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$model = $this->model;
	$model1 = $this->model1;
	$courses=$model->getCurrentCourses();
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
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
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
 //       $pathway->addItem('SMS',$modulelink);
        $pathway->addItem('TEST PORTION');


?>


<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>
<?php
	$this->showlinks();
?>


<h1>Test Portion [ <?php echo date('d-m-Y'); ?> ]</h1>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=sms&view=sms&task=savetestportions&layout=testportions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
			<div class="box-icon">
				<div class="pull-right">
				<table border="0"><tr><td>
					<button class="btn btn-small btn-danger" value="Send" name="Send"> <i class="icon-edit icon-white"></i> Send SMS</button>
					</td><td>
					<button class="btn btn-small btn-success" name="Save" value="Save"><i class="icon-plus-sign icon-white"></i> Save</button>        </td></tr></table>
				</div>
			</div>
<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-content">
			<table class="table table-striped table-bordered ">
			<thead>
			<tr>
				<th width="10%">Class</th>
				<th width="5%">Sno</th>
				<th width="20%">Subject Title</th>
				<th width="65%">Test Portion </th>
			</tr>
			</thead>   
			<tbody>
<?php

	$rf=0; //To find empty list
	foreach ($courses as $course){
		$rs = $model1->getMSubjectsByCourse($course->id,$subjects);
?>
			<?php
			$i=1;
			$c=count($subjects);
			foreach($subjects as $srec) {
				$rs = $model->getTestPortion($course->id,$srec->id,$hrec);
				if($rs=="true") $ef=1;
				else $ef=0;
				$rf=1;
			?>
			<tr>
				<?php if($i=="1") { ?><td rowspan="<?php echo $c; ?>"><?php echo $course->code ; ?></td> <?php } ?>
				<td><?php echo $i++; ?></td>
				<td><?php echo $srec->subjecttitle; ?></td>
				<td><input type="text" maxlength="50" style="width:95%;" name="hw[<?php echo $course->id.'$$'.$srec->id.'$$'.$srec->acronym.'$$'.$ef; ?>]" value="<?php echo htmlspecialchars($hrec->testportion); ?>" /></td>
			</tr>
			<?php
			}
			
			?>
	<?php } 
		if($rf=="0"){
			echo '<tr><td colspan="4">No Subjects are defined...</td></tr>';
		}	
	
	?>
			</tbody>
			</table>  

			<input type="hidden" name="view" value="testportions" />
			<input type="hidden" name="controller" value="sms" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
			<input type="hidden" name="task" value="savetestportions"/>
		</div>
	</div><!--/span-->
</div><!--/row-->
<div class="pull-right">
<button class="btn btn-small btn-success" name="Save" value="Save"><i class="icon-plus-sign icon-white"></i> Save</button>        
</div>
</form>
<br />
<br />
<br />
