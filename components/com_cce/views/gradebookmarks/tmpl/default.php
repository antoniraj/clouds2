<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $templateDir = JURI::base() . 'templates/' . $app->getTemplate();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
?>
<div>
        <div style="float:left;">
           <img src="<?php echo JURI::root().'templates/'.$app->getTemplate().'/images/64x64/gradebook.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Grade Book</h1>
        </div>
</div>
<?php
	echo '<center><h1>['.$this->srec->subjectcode.']'.$this->srec->subjecttitle.'</h1><h3>['.$this->trec->term.']</h3></center>';
?>
<hr /> <br />
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=gradebook&task=actionType'); ?>" method="POST" name="adminForm">
        <?php
                foreach($this->gradebook as $rec) {
        ?>
<table border="1" cellspacing="2" cellpadding="3">
        <tr>
                <th class="list-title" width="5%"><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </th>
                <th class="list-title" width="45%"><?php echo $rec->title; ?></th>
                <th class="list-title" width="5%"><?php echo $rec->code; ?></th>
                <th class="list-title" width="10%"><?php echo $rec->weightage; ?>%</th>
	</tr>
</table>
			<?php
			   	$details=$this->model->getGradeBookDetails($rec->id);
				echo '<table>';
			    	foreach($details as $detail)
				{
					$a=explode('-',$detail->duedate); 
					$duedate="$a[2]-$a[1]-$a[0]"; 
					$dlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=gradebook&termid='.$this->termid.'&subjectid='.$this->subjectid.'&task=removeentry&entryid='.$detail->id);
					$mlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebookmarks&view=gradebookmarks&termid='.$this->termid.'&subjectid='.$this->subjectid.'&task=entermarks&entryid='.$detail->id);
					$elink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=addgradebookdetailentry&termid='.$this->termid.'&subjectid='.$this->subjectid.'&task=editentry&entryid='.$detail->id);

					echo '<tr><td width="8%">&nbsp;</td><td width="32%">(<a href="'.$dlink.'">X</a>)<a href="'.$elink.'">'.$detail->title.'</a></td><td width="10%">'.$detail->code.'</td><td width="15%">'.$detail->marks.'&nbsp;Marks</td><td width="15%">'.$duedate.'</td><td width="20%"><a href="'.$mlink.'">Enter Marks</td></tr>';
				}
				//Add New Entry
				$alink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=addgradebookdetailentry&termid='.$this->termid.'&subjectid='.$this->subjectid.'&task=addentry&categoryid='.$rec->id);
				echo '<tr><td colspan="5" align="right"><a href="'.$alink.'">[Add Entry]</a></td></tr>';
				echo '</table>';
			?>	 
        <?php } ?>
<table border="0" width="100%">
<tr> <td width="50%"><input type="submit" class="button_delete"  value="Delete" name="Delete">
<input type="submit" class="button_edit" name="Edit" value="Edit"></td>
<td width="50%" align="right"><input type="submit" class="button_add" name="Add" value="Add"> </td> </tr>
<input type="hidden" name="controller" value="gradebook" />
<input type="hidden" name="view" value="gradebook" />
<input type="hidden" name="subjectid" id="subjectid" value="<?php echo $this->subjectid; ?>" />
<input type="hidden" name="courseid" id="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="termid" id="termid" value="<?php echo $this->termid; ?>" />
<input type="hidden" name="task" value="actions"/>
</table>
</form>
