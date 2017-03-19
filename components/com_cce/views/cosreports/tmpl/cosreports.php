<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$termid = JRequest::getVar('termid');
	$studentid = JRequest::getVar('termid');
	$courseid = JRequest::getVar('courseid');
	$lsrecs=$this->model->getLSActivities();
	$avrecs=$this->model->getAttitudeAndValuesActivities();
	$carecs=$this->model->getCoScholasticAActivities();
	$cbrecs=$this->model->getCoScholasticBActivities();
	$r=$this->model->getTerm($termid,$trec);
	$r=$this->model->getCourse($courseid,$crec);
?>

<?php
	echo '<center><h1>'.$crec->coursename.' - CoScholastic Areas</h1><h3>['.$trec->term.']</h3></center>';
?>
<hr /> <br />
<h1>Life Skills</h1>
<table border="1" cellspacing="2" cellpadding="3" class="school">
<tr><th class="list-title">activitycode</th><th class="list-title">Activity</th><th class="list-title">Grade</th></tr>
<?php
	   foreach($lsrecs as $lsrec){
		$i=1;
  		  $r = $this->model->getLSCoSMarks($studentid,$lsrec->id,$courseid,$termid,$data);	
	          echo $data[0]['marks'];
		  echo $data[0]['indicators']; 
		  echo $data[0]['id']; 
		}
?>
</table>
	
