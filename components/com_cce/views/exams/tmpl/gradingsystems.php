<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$cmdf= JRequest::getVar('cmdf');
	$gsid= JRequest::getVar('gsid');
	$eon= JRequest::getVar('eon');
	if(! isset($eon)) $eon="0";
	
	setlocale(LC_MONETARY,"en_IN");
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('exams');
	$gss = $model->getGradingSystems();
	if(!isset($gsid)) $gsid=$gss[0]->id;

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
<b style="font: bold 15px Georgia, serif;">GRADING SYSTEM</b>
</td>
<td style="text-align:right;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=savenewgradingsystem&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
		<button class="btn btn-small btn-warning" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> New GradingSystem</button>
		<input type="hidden" name="view" value="exams" />
		<input type="hidden" name="layout" value="gradingsystems" />
		<input type="hidden" name="controller" value="exams" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="gsid" value="<?php echo $gsid; ?>" />
		<input type="hidden" name="cmdf" value="<?php echo '1'; ?>" />
		<input type="hidden" name="task" value="savenewgradingsystem"/>
	</form>
</td>
<td style="text-align:right;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=deletegradingsystem&gsid='.$gsid.'&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
		<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
		<input type="hidden" name="view" value="exams" />
		<input type="hidden" name="controller" value="exams" />
		<input type="hidden" name="layout" value="gradingsystems" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="gsid" value="<?php echo $gsid; ?>" />
		<input type="hidden" name="cmdf" value="<?php echo '2'; ?>" />
		<input type="hidden" name="task" value="deletegradingsystem"/>
	</form>
</td>
</tr>
</table>				

<table border="0" width="100%"><tr><td style="text-align:left;">
<?php
if($cmdf!='1'){ 
?>
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=showgradingsystem&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<select id="selectError" data-rel="chosen" onchange="submit();" style="width:300px;" name="gsid">
		<option value="">Select a Grading System</option>
		<?php
		foreach($gss as $gs) :
			echo "<option value=\"".$gs->id."\" ".($gs->id == $gsid ? "selected=\"yes\"" : "").">".$gs->title."</option>";
		endforeach;
		?>
	</select>
<!--	<button class="btn btn-small btn-warning" value="go" name="Go"> <i class="icon-edit icon-white"></i>Go</button> -->
	<input type="hidden" name="view" value="exams" />
	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" name="layout" value="gradingsystems" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="cmdf" value="<?php echo '4'; ?>" />
	<input type="hidden" name="task" value="showgradingsystem"/>
	</form>
<?php } ?>
</td>
<td width="50%" style="text-align:right;">
<?php
if($cmdf!='0'){ 
$s=$model->getGradingSystem($gsid,$gsrec);
?>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=savegradingsystem&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	Grading System Title&nbsp;&nbsp;<input type="text" name="title" value="<?php echo htmlspecialchars($gsrec->title); ?>" />
	<button class="btn btn-small btn-primary" value="Save" name="Save"> <i class="icon-edit icon-white"></i> Save</button>
	<input type="hidden" name="view" value="exams" />
	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" name="layout" value="gradingsystems" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="gsid" value="<?php echo $gsid; ?>" />
	<input type="hidden" name="cmdf" value="<?php echo '5'; ?>" />
	<input type="hidden" name="eon" value="<?php echo $eon; ?>" />
	<input type="hidden" name="task" value="savegradingsystem"/>
</form>
<?php } ?>

</td>

</tr></table>


<?php
        if(strlen($gsid)>0){
		$recs = $model->getGradingSystemEntries($gsid);
        }else
              //  return;
?>



<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i> Grading System Entries</h2>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
            <th width="10%">From</th>
            <th width="10%">To</th>
            <th width="15%">Grade</th>
            <th width="15%">GradePoint</th>
            <th width="45%">Description</th>
          </tr>
        </thead>
        <tbody>
          <?php
		foreach($recs as $rec) {
          ?>
          <tr>
            <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td>
            <td><?php echo $rec->from; ?></td>
            <td><?php echo $rec->to; ?></td>
            <td><?php echo $rec->letter; ?></td>
            <td><?php echo $rec->points; ?></td>
            <td><?php echo $rec->description; ?></td>
          </tr>
          <?php
		}
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
<input type="hidden" name="task" value="gradingsystemactions"/>
<input type="hidden" name="gsid" value="<?php echo $gsid; ?>"/>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
</form>

