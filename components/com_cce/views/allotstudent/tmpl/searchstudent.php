
<?php
    defined('_JEXEC') OR DIE('Access denied..');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
    $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$stopid  = JRequest::getVar('stopid');
	$vid  = JRequest::getVar('vid');
	$did  = JRequest::getVar('did');
	$type  = JRequest::getVar('type');
	$a_seats  = JRequest::getVar('a_seats');
 
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('cce');

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
   $busroutelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$masterItemid);
	 $busroute= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=allotstudent&view=allotstudent&task=display&layout=default&Itemid='.$masterItemid);
	
  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&Itemid='.$studentsItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->

<table width="100%" cellpadding="10">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir.'/students.png'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left">
        <div>&nbsp;&nbsp;</div>
        <h1 class="item-page-title"><?php echo " $this->coursename".' '.$this->section; ?></h1>
      </div>
      <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
       <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
      </div>
       <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroute; ?>"><img src="<?php echo $iconsDir.'/student.jpeg'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
      </div>
      </td>
  </tr>
</table>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span7">
  <h2><i class="icon-edit"></i> Allot Student</h2>
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
    <input type="hidden" name="controller" value="allotstudent" />
    <input type="hidden" name="view" value="allotstudent" />
    <input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
    <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="stopid" value="<?php echo $stopid; ?>" />
    <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
    <input type="hidden" name="did" value="<?php echo $did; ?>" />
    <input type="hidden" name="type" value="<?php echo $type; ?>" />
     <input type="hidden" name="a_seats" value="<?php echo $a_seats; ?>" />
    <input type="hidden" name="task" value="display"/>
    <input type="hidden" name="layout" value="searchstudent"/>
</form>
</div>
</div>
<div class="box-content">
  <table class="table table-striped table-bordered bootstrap-datatable datatable stu-admission">
    <thead>
      <tr>
        <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
      <th><span class="icon icon-color icon-triangle-ns"></span>RegNo</th>
      <th><span class="icon icon-color icon-triangle-ns"></span>Name</th>
      <th><span class="icon icon-color icon-triangle-ns"></span>Gen</th>
      <th><span class="icon icon-color icon-triangle-ns"></span>Father Mobile</th>
      </tr>
    </thead>
    <tbody>
    <?php
	if($this->students){
		   $sno=1;
                   foreach($this->students as $rec) {
        ?>
    <tr style="height:25px;">
        <td><input type="checkbox"  name="cid[]" value="<?php echo $rec->id; ?>" /></td>
        <?php
                  echo "<td>$rec->registerno</td>";
                  echo "<td>$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
                 echo "<td>$rec->gender</td>";

                  echo "<td>$rec->mobile</td>";
				   }
	}
?>
    </tr>
    </tbody>
  </table>
</div>
<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="save" value="Save">Save</button>
							  <button type="reset" class="btn">Cancel</button>
			</div>
</div>
<!--/span-->

</div>
<!--/row-->
    <input type="hidden" name="controller" value="allotstudent" />
    <input type="hidden" name="view" value="allotstudent" />
    <input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
    <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
    <input type="hidden" name="stopid" value="<?php echo $stopid; ?>" />
    <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
    <input type="hidden" name="did" value="<?php echo $did; ?>" />
    <input type="hidden" name="type" value="<?php echo $type; ?>" />
     <input type="hidden" name="a_seats" value="<?php echo $a_seats; ?>" />
    <input type="hidden" name="task" value="display"/>
    <input type="hidden" name="layout" value="searchstudent"/>
</form>


