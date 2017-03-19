
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
    	$photoDir = JURI::base() . 'components/com_cce/staffphoto/';
   	$model = & $this->getModel('cce');

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('master','Staff Details');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=staff&Itemid='.$masterItemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Staff',$modulelink);
        $pathway->addItem('Manage Staff');
?>



<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=staffs&view=staffs&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="pull-right">
    <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Add</button>
    <button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit icon-white"></i> Edit</button>
    <button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
</div>
<div class="span5">
  <h2><i class="icon-edit"></i> Staff Records</h2>
</div>
</div>

<div class="box-content">

  <table class="table table-striped table-bordered bootstrap-datatable datatable stu-admission">
    <thead>
      <tr>
        <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
        <th>Staff Code</th>
        <th>Staff Name</th>
        <th>Gender</th>
        <th  class="hidden-phone">Mobile</th>
        <th  class="hidden-phone">Photo</th>
         <th>Operation</th>
      </tr>
    </thead>
    <tbody>
      <?php
		if($this->staffs){
                   foreach($this->staffs as $rec) {
     	      $link1= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffs&controller=staffs&layout=profile&staffid='.$rec->id);
     ?>
      <tr>
        <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td>
        <td><?php echo $rec->staffcode; ?></td>
        <td><?php echo "$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname"; ?></td>
        <?php

			
			echo "<td>$rec->gender</td>";

			$rs=$this->model->getDepartment($rec->department,$drec);

	                echo "<td>$rec->mobile </td>";
  
              $filename=$model->getsiglestaffphoto($rec->id,$file);
             if($file->image_name)
			 {
			 ?>
        <center>
          <td  class="hidden-phone"><img src="<?php echo  $photoDir.$file->scode.'.'.$file->extention;  ?>"  alt="photo"/></td>
        </center>
        <?php
							     }
							     else{
							     ?>
        <td  class="hidden-phone"><img src="<?php echo $photoDir.'no-image.gif'; ?>" alt="photo" /></td>
        <?php 
							} 
															
				echo '<td class="center hidden-phone">';
				echo '<a class="btn btn-info" href="'.$link1.'">';
				echo '<i class="icon-zoom-in icon-white"></i>  View	</a>';
				echo '</td>';
		?>
      </tr>
      <?php 
	  } 
		}
		?>
    </tbody>
  </table>
  
  		<div class="form-actions">
	
  <div class="span4">
    <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Add</button>
    <button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit icon-white"></i> Edit</button>
    <button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
    <input type="hidden" name="controller" value="staffs" />
<input type="hidden" name="view" value="staffs" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>	

  </div>
  <div class="span7" align="right">
      <form name="upload" method="post" enctype="multipart/form-data">
      Select a CSV file to import:
      <input class="input-file uniform_on" id="fileInput" type="file" name="recs">
      <button class="btn btn-small btn-info" name="import" value="import"><i class="icon-upload icon-white"></i> Upload</button>
      <input type="hidden" name="controller" value="staffs" />
      <input type="hidden" name="view" value="staffs" />
      <input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
      <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
      <input type="hidden" name="task" value="importRecords"/>
    </form>
  </div>
  </div>	

</div>
</div>
<!--/span-->
	

  </div>
</div>
</div>
<!--/row-->


