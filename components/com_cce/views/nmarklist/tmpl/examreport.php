<style>
table.subjects{
	border-collapse:collapse;
	background:#FFF;
}
table.subjects tr td{
	padding:7px;border:1px solid #919191;
	font-size:12px;
}
table.subjects tr th{
	background:#E8E8E8;
	padding:4px;
	border:1px solid #919191;
	font-size:14px;
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
	$Itemid = JRequest::getVar('Itemid');
	$examid=JRequest::getVar('examid');
	$staff=JRequest::getVar('staff');
	$print=JRequest::getVar('print');
	$courseid=JRequest::getVar('courseid');
	$subjectid=JRequest::getVar('subjectid');
	$title=JRequest::getVar('title');
	$max=JRequest::getVar('max');
	$passmark=JRequest::getVar('passmark');
?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=nmarklist&controller=ngradebookmarks&layout=examreport&courseid='.$courseid.'&subjectid='.$subjectid.'&title='.$title.'&max='.$max.'&Itemid='.$Itemid.'&staff='.$staff.'&examid='.$examid.'&passmark='.$passmark.'&tmpl=component&print=1" '.$href;
        }
if($print!=1)
{
?>
<div align="right">
<a href=<?php echo $href; ?> ><span title="Print" class="icon32 icon-green icon-print"></span></a>
</div>
<?php
}
	$model2=& $this->getModel('tngradebook');
	$model3=& $this->getModel('nmarks');
	$status=$model2->getTNGradeBookEntry($examid,$examrec);
	$status=$this->model->getSchoolInfo($rec);
?>
<center>

                <h1 style="font-size:26px;"><strong><?php echo $rec->schoolname; ?></strong></h1><br>
                <h3><?php echo $rec->schooladdress; ?></h3>
</center>
<br />
<br />
<table class="exam" width="100%">
<tr>
<td width="50%">
<table class="examreport">
<tr><td><b>Class</b></td><td>: <?php echo $this->crec->coursename.'-'.$this->crec->sectionname; ?></td></tr>

<tr><td><b>Subject Title</b></td><td>: <?php echo $this->srec->subjecttitle.' ['.$this->srec->subjectcode; ?>]</td></tr>
</table>
</td>
<td width="50%" align="right">
<table class="examreport">
<tr><td><b>Subject Teacher</b></td><td>:  <?php echo $staff; ?></td></tr>
<tr><td><b>Exam</b></td><td>: <?php echo $title; ?></td></tr>
</table>

</td>
</tr>
</table>

<hr /> <br />

<table class="subjects" width="100%">
        <tr>
                <th width="7%">SNO</th>
                <th width="10%">RNO</th>
                <th width="23%">NAME</th>
                <th width="8%">MARK/<?php echo $max; ?></th>
                <th width="3%">GRA</th>
                <th width="3%">RES</th>
                <th width="20%">COMMENTS</th>
	</tr>
	<form method="post" action="index.php" name="adminform">
	<?php
		$i=1;
		foreach($this->students as $student)
		{
		        $this->model->getNMarks($student->id,$examid,$subjectid,$courseid,$mrec);
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$student->registerno.'</td>';	
			echo '<td>'.$student->firstname.'</a></td>';
			if(isset($mrec->marks))
			{
				echo '<td>'.$mrec->marks.'</td>';	
				$model3->getNormalGradeLetter(round($mrec->marks/$max*100,2),$grl);
				echo '<td>'.$grl->letter.'</td>';
				if($mrec->marks < $passmark) $result='F';
				else $result='P';
				echo '<td>'.$result.'</td>';
				echo '<td>'.$mrec->comments.'</td>';
			}else{
				echo '<td>-</td>';
				echo '<td>-</td>';
				echo '<td>-</td>';
				echo '<td>-</td>';
			}
			echo '</tr>';
			echo '<input type="hidden" name="sid[]" value="'.$student->id.'">';
			echo '<input type="hidden" name="mid[]" value="'.$mrec->id.'">';
			echo '<input type="hidden" name="rno[]" value="'.$studen->registerno.'">';
			$i++;
		}
	?>

</table>
<br />
<br />
<br />
<div style="float: right;"><i>Subject Teacher</i></div>
</div>
<br />
<br />
