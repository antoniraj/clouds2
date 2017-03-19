<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$termid = JRequest::getVar('termid');
	$courseid = JRequest::getVar('courseid');
	$activityid= JRequest::getVar('activityid');
	$arecs=$this->model->getAttitudesAndValues();
	$this->model->getAttitudeAndValue($activityid,$activity);
	$srecs=$this->model->getStudents($courseid);
	$r=$this->model->getTerm($termid,$trec);
	$r=$this->model->getCourse($courseid,$crec);

        $Itemid = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
        $model = & $this->getModel();

        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
        $gradeslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=coursereports&Itemid='.$masterItemid);
        $profilelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rshowcourseprofile&task=showcourseprofile&courseid='.$courseid.'&Itemid='.$masterItemid);

?>


<table width="100%" cellpadding="10">
        <tr style="border:none;"> <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/report3.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2> <h2></h2> 
                <h1 class="item-page-title"><?php echo $crec->code; ?></h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br /> </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $gradeslink; ?>"><img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="Enter Marks" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $profilelink; ?>"><img src="<?php echo $iconsDir.'/report3.png'; ?>" alt="Enter Marks" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>

<?php
	echo '<center><h1>'.$crec->code.' - Attitude And Values</h1><br><h3>['.$trec->term.']</h3></center>';
?>





<?php
	   foreach($arecs as $arec){
?>		

<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						
						<h2><i class="icon icon-color icon-page"></i> <?php echo $activity->activityname.'('.$activity->activitycode.')'; ?></h2>
						<div style="float:right;margin-top:-5px;">
						<form class="form-horizontal" action="index.php" method="POST" name="adminForm">
							<fieldset>
								<div class="control-group">
								<label class="control-label" for="selectError">Select Type</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" onchange="submit();" name="activityid">
									<option value="">Select</option> 
								   <?php
					
											  	 foreach($arecs as $arec) :
													echo "<option value=\"".$arec->id."\" ".($arec->id == $activityid ? "selected=\"yes\"" : "").">".$arec->activityname."</option>";
													endforeach;
										?>
								  </select>
							  <input type="hidden" name="controller" value="cosreports" />
  <input type="hidden" name="view" value="cosreports" />
  <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
   <input type="hidden" name="termid" value="<?php echo $termid; ?>" />
     <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
    <input type="hidden" name="layout" value="avreports" />
    </fieldset>

					</form>				
		</div>

						</div>
<div class="box-content">
		<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=cosmarks&task=savelsmarks'); ?>" method="POST" name="adminForm">

      <table class="table table-striped table-bordered ">
      			
        <thead>
<?php
			echo "<tr><th class=\"list-title\">#</th><th class=\"list-title\">RNo</th><th class=\"list-title\">Student Name</th><th class=\"list-title\">Marks/5</th><th class=\"list-title\">Descriptive Indicators</th></tr></thead>";
		$i=1;
if($activityid) {		
                foreach($srecs as $srec) {
?>
<tbody>
        	<tr>
                <td width="5%" style="vertical-align: top;"><?php echo $i++; ?></td>
                <td width="10%" style="vertical-align: top;"><?php echo $srec->registerno; ?></td>
                <td width="25%" align="left" style="vertical-align: top;"><?php echo $srec->firstname; ?></td>
<?php
		$r = $this->model->getAVCoSMarks($srec->id,$activityid,$courseid,$termid,$data);

?>			
      <td style="vertical-align: top;" width="5%"><?php echo $data[0]['marks']; ?></td>
		<th width="60%" align="left"><?php echo $data[0]['indicators']; ?></th>		</tr>
	
<?php
		}
}		
		?>
		</tbody>
</table>

</form>
<?php
	break;
	}
       
?>
</form>

					</div>
				</div><!--/span-->
				</div>
