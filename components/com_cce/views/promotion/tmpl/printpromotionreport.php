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

$document = JFactory::getDocument();
$document->setName('PromotionReport-'.$cay->academicyear.'-To-'.$nay->academicyear);

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

	echo '<center><h1>'.$school->schoolname.'</h1></center>';
	echo '<center><h3>'.$school->schooladdress.'</h3></center>';
	echo '<center><h2>Promotion Report</h2></center>';
?>
<center>
  <h4>
<?php
echo $cay->academicyear.' TO '.$nay->academicyear;
?>
</h4>
</center>

  <table width="100%">
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
