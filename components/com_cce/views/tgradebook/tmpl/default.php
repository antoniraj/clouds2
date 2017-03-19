<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	$Itemid = JRequest::getVar('Itemid');
	  	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);

?>

<div class="row-fluid">
<div class="span6"> 
   <div class="row-fluid">
   <div class="span1">
     <img src="<?php echo $iconsDir.'/gradebooktemplate.png'; ?>" alt="Template" style="width: 68px; height: 48px;" />

   </div>
   <div class="span6">
    <h1>Grade Book Template(Normal)</h1>
   </div>
   </div>
 </div>
<div class="span6" align="right">
   <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir.'/1results.png'; ?>" alt="Grades" style="width: 48px; height: 48px;" /></a> 

     <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a> 
   
</div>
</div>
  <?php
                foreach($this->tgradebook as $rec) {
         ?>
    <div class="box-header well" data-original-title>
      <?php	
			if($rec->bestof==0)
				$bestof = 'All';
			else
				$bestof = $rec->bestof;
					?>
      <div class="row-fluid">
        <div class="span6">
          <h2><b><?php echo $rec->title."(".$rec->grouptag.")"; ?></b></h2>
        </div>
        <div class="span2">
          <h2><b><?php echo $rec->code; ?></b></h2>
        </div>
        <div class="span2">
          <h2><b><?php echo $rec->weightage; ?>%</b></h2>
        </div>
      </div>
    </div>
    <div class="box-content">
      <form action="<?php echo JRoute::_('index.php?option=com_cce&controller=tgradebook&task=actionType'); ?>" method="POST" name="adminForm">
        <table class="table table-striped bootstrap-datatable datatable">
          <thead>
            <tr>
              <th>Title</th>
              <th>Short Code</th>
              <th>Marks</th>
              <th>Due Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
			   	$details=$this->model->getTGradeBookDetails($rec->id);		
			    	foreach($details as $detail)
				{
					$dlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=tgradebook&view=tgradebook&task=removeentry&entryid='.$detail->id.'&Itemid='.$Itemid);
					$elink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=tgradebook&view=addtgradebookdetailentry&task=editentry&entryid='.$detail->id.'&Itemid='.$Itemid);
 					echo '<tr><td><a href="'.$elink.'">'.$detail->title.'</a></td><td>'.$detail->code.'</td><td>'.$detail->marks.'&nbsp;Marks</td><td>'.JArrayHelper::indianDate($detail->duedate).'</td></tr>';
				}
				
			?>
          </tbody>
        </table>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary" name="Edit" value="Edit">Edit</button>
        </div>
        <input type="hidden" name="controller" value="tgradebook" />
        <input type="hidden" name="view" value="tgradebook" />
        <input type="hidden" name="task" value="actions"/>
        <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
        <input type="hidden" name="cid" value="<?php echo $rec->id; ?>"/>
      </form>
    </div>
<br>
<?php } ?>
