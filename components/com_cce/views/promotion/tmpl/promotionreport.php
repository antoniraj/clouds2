<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('promotion');
	$model->getSchoolInfo($school);

	$courses = $model->getCurrentCourses();
	$r = $model->getThisAcademicYear($cay);
	$r = $model->getNextAcademicYear($nay);


   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','promotion');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
   	$plink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=promotion&view=promotion&layout=printpromotionreport&Itemid='.$masterItemid.'&format=pdf&tmpl=component');

?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/promotion.png'; ?>" alt="" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Promotion Report</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Grades" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>
<?php
	echo '<center><h1>'.$school->schoolname.'</h1></center><br>';
	echo '<center><h3>'.$school->schooladdress.'</h3></center><br>';
	echo '<center><h2>Promotion Report</h2></center>';
?>
<div align="right">
<a href=<?php echo $plink; ?> ><span title="Print" class="icon32 icon-red icon-pdf"></span></a>
</div>
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span7">
  <h2><i class="icon-edit"></i>
<?php
echo $cay->academicyear.' TO '.$nay->academicyear;
?>
</h2>
</div>
</div>
</div>

<div class="box-content">
  <table class="table table-striped table-bordered width="100%"">
    <thead>
      <tr>
        <th>Class</th>
        <th>Status</th>
        <th>Promoted</th>
        <th>Not Promoted</th>
      </tr>
    </thead>
    <tbody>
<?php
	if($courses){
		foreach($courses as $rec) {
			$r=$model->getPromotionStatus($rec->id,$pst);
			$r = $model->getPromotedCount($rec->id,$pcount);
			$r = $model->getNotPromotedCount($rec->id,$npcount);
			echo '<tr>';
				echo "<td>$rec->code</td>";
				echo '<td>';
				if($pst)
					echo 'Done';
				else
					echo 'No';
				echo '</td>';
				echo '<td>'.$pcount.'</td>';
				echo '<td>'.$npcount.'</td>';
			echo '</tr>';
		}
	}
?>
    </tbody>
    </table>
</div>
</div>
</div>
