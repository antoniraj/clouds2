<style>
h3.item-page-title {
padding: 26px 0 12px;
}
</style>
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
        $model = & $this->getModel();
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
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);


?>
<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/courses.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title">Grade Cards -  Reports</h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>

	<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> <strong>Current Courses(Classes)</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<body>
        <?php
		$rc=1;
                foreach($this->courses as $rec) {
			if($rc==1) echo "<tr>";	
			echo '<td align="center">'; 
			if($rec->assessmenttype=='CCE')
				$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rshowcourseprofile&task=showcourseprofile&courseid='.$rec->id.'&Itemid='.$Itemid);
			else
				$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rshowcourseprofilenormal&task=showcourseprofilenormal&courseid='.$rec->id.'&Itemid='.$Itemid);
			?>

           	<!--<img src="<?php echo $iconsDir1.'/'.$rec->filename; ?>" alt="" style="width: 64px; height: 64px;" /> -->
			<?php
			echo "<h3 class=\"item-page-title\"><a href=\"$link\"><span class='blue'>$rec->coursename-$rec->sectionname</span>"." <span class='green'>[".$rec->code."]"."</span></a></h3>";
			echo '</td>';
        		if($rc==2) echo '</tr>';
			if($rc==2) $rc=0;
			$rc++;
        	} 
	?>
	</tbody>
</table>
	
					</div>
				</div><!--/span-->
				</div>
					
