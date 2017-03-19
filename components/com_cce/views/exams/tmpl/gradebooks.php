<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$cmdf= JRequest::getVar('cmdf');
	$gbid= JRequest::getVar('gbid');
	$eon= JRequest::getVar('eon');
	if(! isset($eon)) $eon="0";
	
	setlocale(LC_MONETARY,"en_IN");
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('exams');
	$gbs = $model->getTGradeBooks();
	if(!isset($gbid)) $gbid=$gbs[0]->id;

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


<table border="0" width="100%"><tr>
<td width="80%" style="text-align:left;">
<b style="font: bold 15px Georgia, serif;">GRADE BOOK </b>
</td>
<td style="text-align:right;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=savenewgradebook&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
		<button class="btn btn-small btn-warning" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> New Grade Book</button>
		<input type="hidden" name="view" value="exams" />
		<input type="hidden" name="layout" value="gradebook" />
		<input type="hidden" name="controller" value="exams" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="gbid" value="<?php echo $gbid; ?>" />
		<input type="hidden" name="cmdf" value="<?php echo '1'; ?>" />
		<input type="hidden" name="task" value="savenewgradebook"/>
	</form>
</td>
<td style="text-align:right;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deletegradebook&gbid='.$gbid.'&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
		<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
		<input type="hidden" name="view" value="exams" />
		<input type="hidden" name="controller" value="exams" />
		<input type="hidden" name="layout" value="gradebook" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="gbid" value="<?php echo $gbid; ?>" />
		<input type="hidden" name="cmdf" value="<?php echo '2'; ?>" />
		<input type="hidden" name="task" value="deletegradebook"/>
	</form>
</td>

</tr></table>				

<table border="0" width="100%"><tr><td style="text-align:left;">
<?php
if($cmdf!='1'){ 
?>
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=showgradebook&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<select id="selectError" data-rel="chosen" onchange="submit();" style="width:300px;" name="gbid">
		<option value="">Select a Grade Book</option>
		<?php
		foreach($gbs as $gb) :
			echo "<option value=\"".$gb->id."\" ".($gb->id == $gbid ? "selected=\"yes\"" : "").">".$gb->title."</option>";
		endforeach;
		?>
	</select>
<!--	<button class="btn btn-small btn-warning" value="go" name="Go"> <i class="icon-edit icon-white"></i>Go</button> -->
	<input type="hidden" name="view" value="exams" />
	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" name="layout" value="gradebook" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="cmdf" value="<?php echo '4'; ?>" />
	<input type="hidden" name="task" value="showgradebook"/>
	</form>
<?php } ?>
</td>
<td width="50%" style="text-align:right;">
<?php
if($cmdf!='0'){ 
$s=$model->getTGradeBook($gbid,$gbrec);
?>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=savegradebook&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	Grade Book Title&nbsp;&nbsp;<input type="text" name="title" value="<?php echo htmlspecialchars($gbrec->title); ?>" />
	<button class="btn btn-small btn-primary" value="Save" name="Save"> <i class="icon-edit icon-white"></i> Save</button>
	<input type="hidden" name="view" value="exams" />
	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" name="layout" value="gradebook" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="gbid" value="<?php echo $gbid; ?>" />
	<input type="hidden" name="cmdf" value="<?php echo '5'; ?>" />
	<input type="hidden" name="eon" value="<?php echo $eon; ?>" />
	<input type="hidden" name="task" value="savegradebook"/>
</form>
<?php } ?>

</td>
</tr></table>

<?php
	if(strlen($gbid)>0){
	}else 
		return;
?>

<?php
	function displayGradeBook($prec,$model,$psno,$csno,$l){
		echo '<tr >';
			echo '<td><input type="checkbox" name="cid[]" id="cid[]" value="'.$prec->id.'" /></td>';
			echo '<td>';
				if($csno==''){
					echo "$psno";
				}else{
				//              echo $psno.'.'.$csno;
				}
			echo '</td>';
			echo '<td align="left">';
				$sp='';
				//     for($i=0;$i<$l;$i++) $sp=$sp.'&nbsp;&nbsp;&nbsp;&nbsp;';
				for($i=0;$i<$l;$i++) $sp=$sp.'<td>&nbsp;</td>';
					echo '<table><tr>'.$sp.'<td width="100%">'.$prec->title.'</td></tr></table>';
			echo '</td>';
			echo '<td>'.$prec->code.'</td>';
			echo '<td>'.$prec->weightage.'</td>';
			echo '<td>'.JArrayHelper::indianDate($prec->duedate).'</td>';
			echo '<td>';
				if($prec->required=="1") echo "Yes"; else echo "No"; 
			echo '</td>';
			echo '<td>'.$prec->description.'</td>';
		echo '</tr>';

		$crecs = $model->getTGradeBookChildEntries($prec->id);
		if(count($crecs)==0){
			return;
		}
		$csno=1;
		$l++;
		foreach($crecs as $crec){
			displayGradeBook($crec,$model,$psno,$csno++,$l);
		}
	}
?>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> GRADE BOOK ENTRIES</h2>
			        <div class="pull-right">
				          <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>
				          <button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
				          <button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
			        </div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<th><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
					<th width="4%"><B>Sno</B></th>
					<th width="25%" ><B>Title</B></th>
					<th><B>Code</B></th>
					<th><B>Weightage</B></th>
					<th><B>Due Date</B></th>
					<th><B>Required</B></th>
					<th width="20%" ><B>Description</B></th>
				</thead>
				<tbody>
				<?php
					$precs=$model->getTGradeBookParentEntries($gbid);
					//$precs=$model->getgradebookentry($rec->id);
					$j=1;
					if($precs){
						foreach($precs as $prec){
							displayGradeBook($prec,$model,$j++,'',0);
						}
					}
					$i++;
				?>
				</tbody>
			</table>
			<div class="row-fluid">
			        <div class="span6">
				          <button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
				          <button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
			        </div>
			        <div class="span6" align="right">
				          <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>
			        </div>
		      </div>
		</div>
  	</div>
  	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" name="view" value="exams" />
  	<input type="hidden" name="gbid" value="<?php echo $gbid; ?>" />
  	<input type="hidden" name="task" value="gradebookactions" />
  	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
</form>
</div>

