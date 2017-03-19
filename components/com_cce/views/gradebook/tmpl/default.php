<style>
table.subjects{
	border-collapse:collapse;
	background:#FFF;
}
table tr td{
	padding:7px;border:1px solid #919191;
	font-size:12px;
}
table tr td{
	padding:4px;
	border:1px solid #919191;
	font-weight:bold;
}
.exam{
	font-size:14px;
}
</style>


<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid=JRequest::getVar('Itemid');
	$profile=JRequest::getVar('profile');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
        $model = & $this->getModel();
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
        $entermarkslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourses&Itemid='.$masterItemid);
        $profilelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourseprofile&courseid='.$this->courseid.'&Itemid='.$masterItemid);

?>

<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;"> <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/'.$this->filename; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h1 class="item-page-title"><?php echo $this->coursename; ?></h1>
		<?php echo '<center><h1 class="item-page-title">['.$this->srec->subjectcode.']'.$this->srec->subjecttitle.'</h1><h3 class="item-page-title">['.$this->trec->term.']</h3></center>'; ?>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br /> </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $entermarkslink; ?>"><img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="Enter Marks" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $profilelink; ?>"><img src="<?php echo $iconsDir.'/report3.png'; ?>" alt="Profile" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>



<?php
?>
<hr /> <br />
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=gradebook&task=actionType'); ?>" method="POST" name="adminForm">
        <?php
                foreach($this->gradebook as $rec) {
        ?>
<table border="1" cellspacing="2" cellpadding="3" class="school" width="100%">
        <tr>
  		<?php
                        if($rec->bestof==0)
                                $bestof = 'All';
                        else
                                $bestof = $rec->bestof;
                ?>

                <th class="list-title" width="45%"><?php echo $rec->title."(".$rec->grouptag.")"; ?></th>
                <th class="list-title" width="5%"><?php echo $rec->code; ?></th>
                <th class="list-title" width="10%"><?php echo $rec->weightage; ?>%</th>
	</tr>
</table>
			<?php
			   	$details=$this->model->getGradeBookDetails($rec->id);
				echo '<table  class="table table-striped table-bordered">';
				echo '<thead><th>Title</th><th>Code</th><th>Marks</th><th>Due Date</th><th>Operation</th></thead>';
			    	foreach($details as $detail)
				{ 
					$duedate="$a[2]-$a[1]-$a[0]"; 
					$dlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=gradebook&termid='.$this->termid.'&subjectid='.$this->subjectid.'&courseid='.$this->courseid.'&task=removeentry&entryid='.$detail->id.'&Itemid='.$Itemid);
					$mlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebookmarks&view=marklist&termid='.$this->termid.'&courseid='.$this->courseid.'&subjectid='.$this->subjectid.'&gid='.$rec->id.'&max='.$detail->marks.'&task=entermarks&entryid='.$detail->id.'&Itemid='.$Itemid.'&profile='.$profile);
					$elink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=addgradebookdetailentry&termid='.$this->termid.'&courseid='.$this->courseid.'&subjectid='.$this->subjectid.'&task=editentry&entryid='.$detail->id.'&Itemid='.$Itemid);

					echo '<tbody><tr><td width="32%">'.$detail->title.'</td><td width="10%">'.$detail->code.'</td><td width="15%">'.$detail->marks.'&nbsp;Marks</td><td width="15%">'.JArrayHelper::indianDate($detail->duedate).'</td><td width="20%"><a href="'.$mlink.'">Enter Marks</td></tr></tbody>';
					//echo '<tr><td width="8%">&nbsp;</td><td width="32%">(<a href="'.$dlink.'">X</a>)<a href="'.$elink.'">'.$detail->title.'</a></td><td width="10%">'.$detail->code.'</td><td width="15%">'.$detail->marks.'&nbsp;Marks</td><td width="15%">'.$duedate.'</td><td width="20%"><a href="'.$mlink.'">Enter Marks</td></tr>';
				}
				//Add New Entry
	//			$alink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=addgradebookdetailentry&termid='.$this->termid.'&courseid='.$this->courseid.'&subjectid='.$this->subjectid.'&task=addentry&categoryid='.$rec->id.'&Itemid='.$Itemid);
	//			echo '<tr><td colspan="2">*&nbsp;Consider Best'.$bestof.' Sub-categorie(s) for weightage</td><td colspan="4" align="right"><a href="'.$alink.'">[Add Sub-category]</a></td></tr>';
				echo '</table>';
			?>	 
        <?php } ?>

</form>
