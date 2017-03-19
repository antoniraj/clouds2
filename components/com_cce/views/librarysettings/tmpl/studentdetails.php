<script type="text/javascript">
function check()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
 }
</script>
<?php
        defined('_JEXEC') OR DIE('Access denied..');
 
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$photoDir = JURI::base() . 'components/com_cce/studentsphoto/';
   	$model = & $this->getModel('cce');
    $courseid = JRequest::getVar('courseid');
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

   	$studentsItemid = $model->getMenuItemid('master','Students Details');
   	if($studentsItemid) ;
   	else{
        	$studentsItemid = $model->getMenuItemid('manageschool','Dash Board');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$library= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=library&task=display&Itemid='.$studentsItemid);
   	$librarysettings= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&layout=settings&task=display&Itemid='.$studentsItemid);
  
   
    if(!$courseid)
    {
    $cstatus=$model->getCourse($this->cid,$re);
	}
	else{
	 $cstatus=$model->getCourse($courseid,$re);	
	}

?>
<!--
TOP LINKS....DASHBOARD
-->

<table width="100%" cellpadding="10">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir1.'/1students.png'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left">
        <div>&nbsp;</div>
        <h1 class="item-page-title">Students <?php echo "-$re->coursename".'-'.$re->sectionname; ?></h1>
      </div>
      <div style="float:right;"> <a  title="Home" data-rel="tooltip" href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a  title="Students" data-rel="tooltip" href="<?php echo $library; ?>"><img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="Students" style="width: 32px; height: 32px;" /></a><br />
      </div>
       <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a  title="Students" data-rel="tooltip" href="<?php echo $librarysettings; ?>"><img src="<?php echo $iconsDir1.'/1students.png'; ?>" alt="Students" style="width: 32px; height: 32px;" /></a><br />
      </div>
      </td>
  </tr>
</table>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span7">
  <h2><i class="icon-edit"></i> Students Management</h2>
</div>
<div class="span3">
<form class="form-horizontal pull-right" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <fieldset>
    <div class="control-group">
      <label class="control-label" for="selectError">Select Course/Class</label>
      <div class="controls">
        <select id="selectError" data-rel="chosen" onchange="submit();" name="courses">
          <?php
					
													foreach($this->courses as $course) :
													echo "<option value=\"".$course->id."\" ".($course->id == $this->courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
													endforeach;
										?>
        </select>
      </div>
    </div>
  </fieldset>
  <input type="hidden" name="controller" value="librarysettings" />
  <input type="hidden" name="view" value="librarysettings" />
  <input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
  <input type="hidden" name="task" value="Go"/>
  <input type="hidden" name="layout" value="studentdetails"/>
</form>
</div>
</div>
<div class="box-content">
  <table class="table table-striped table-bordered bootstrap-datatable datatable stu-admission">
    <thead>
      <tr>
        <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
        <th>Reg.No</th>
        <th>Student Name</th>
        <th>Gender</th>
        <th class="hidden-phone">Mobile No</th>
        <th  class="hidden-phone">Photo</th>
        <th  class="hidden-phone">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
						if($this->students){
							 foreach($this->students as $rec) {
								 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentstc&controller=studentstc&layout=entertc&task=display&sid='.$rec->id.'',false);	
							      $link = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=profile&id='.$rec->id);

								
								?>
      <tr>
        <td><input type="checkbox"  name="cid[]" value="<?php echo $rec->id; ?>" /></td>
        <?php 
								 echo "<td>$rec->registerno</td>";
								 echo "<td>$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
								 echo "<td >$rec->gender</td>";
								 echo '<td class="hidden-phone">'.$rec->mobile.'</td>';
		
							 	$filename=$model->getsiglestudentphoto($rec->id,$file);
						        if($file->imagename)
						        {
						        ?>
        <center>
          <td  class="hidden-phone"><img src="<?php echo  $photoDir.$file->scode.'.'.$file->ext;  ?>"  alt="photo"/></td>
        </center>
        <?php
							     }
							     else{
							     ?>
        <td  class="hidden-phone"><img src="<?php echo $photoDir.'no-image.gif'; ?>" alt="photo" /></td>
        <?php 
							} 
							
								
								 echo '<td class="center hidden-phone">';
								 echo '<a class="btn btn-info" href="'.$link.'">';
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
</div>
</div>
<!--/span-->


  <input type="hidden" name="controller" value="librarysettings" />
  <input type="hidden" name="view" value="librarysettings" />
  <input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
  <input type="hidden" name="task" value="Go"/>
  <input type="hidden" name="layout" value="studentdetails"/>
</form>
