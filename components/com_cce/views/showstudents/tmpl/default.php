

<?php
    defined('_JEXEC') OR DIE('Access denied..');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$courseid=JRequest::getVar('courseid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$model = & $this->getModel('cce');
	$courses = $model->getCurrentCourses();
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);
  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&Itemid='.$studentsItemid);
?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=printstudents&controller=creports&layout=default&task=display&reportkey='.$this->reportkey.'&re_type='.$this->re_type.'&tmpl=component&print=1" '.$href;
        }
?>
 
	



<!-- 
<table width="100%" cellpadding="10">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir.'/students.png'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left">
        <div>&nbsp;</div>
        <h1 class="item-page-title"><?php echo "$this->coursename".'  '.$this->section; ?></h1>
      </div>
      <div style="float:right;"> <a  title="Home" data-rel="tooltip" href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a  title="Students" data-rel="tooltip" href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1students.png'; ?>" alt="Students" style="width: 32px; height: 32px;" /></a><br />
      </div></td>
  </tr>
</table>

-->


<div align="right"><a href=<?php echo $href; ?> ><span title="Print" class="icon32 icon-color icon-xls"></span></a></div>
<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						
						<h2><i class="icon-user"></i> Students Report</h2>

						</div>
					</div>
													
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">		
<div class="box-content">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
							   <div class="control-group" >
								<label class="control-label" for="selectError">Select Type</label>
								<div class="controls">
								  <select id="reporttype" data-rel="chosen" name="courseid">
										<option value="">Select</option>
										<option value="class" <?php if($this->re_type=="class") echo 'selected="selected"'; ?>>Class Wise Report</option>
										<option value="caste" <?php if($this->re_type=="caste") echo 'selected="selected"'; ?>>Caste Wise Report</option>
								  </select>
								</div>
							  </div>
							   <div class="control-group" >
								<label class="control-label" for="selectError">Select Class</label>
								<div class="controls">
								  <select data-rel="chosen" name="class">
										<option value="">Select</option>
									 <?php
													foreach($courses as $course) :
													echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
													endforeach;
									?>
								  </select>
								</div>
							  </div>
 							<div class="control-group">
							  <label class="control-label" for="date01">Caste</label>
							  <div class="controls">
								<input type="text" class="focusinput" name="caste"value="<?php echo $this->caste; ?>">
							  </div>
							</div>

<div class="form-actions">
<button class="btn btn-primary" name="go" value="go"><i class="icon-plus-sign icon-white"></i> Go</button>
</div>

<input type="hidden" name="controller" value="creports" />
<input type="hidden" name="view" value="showstudents" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
	 </form>			




  <table class="table table-striped table-bordered bootstrap-datatable datatable stu-admission">
    <thead>
      <tr>
        <th>Student Name</th>
        <th>Gender</th>
        <th>Father Name</th>
        <th class="hidden-phone">Mobile No</th>   
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
        <?php 
								 echo "<td>$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
								 echo "<td >$rec->gender</td>";
								 echo "<td >$rec->pfathername</td>";
								 echo '<td class="hidden-phone">'.$rec->mobile.'</td>';
		
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
</div>

<input type="hidden" name="controller" value="creports" />
<input type="hidden" name="view" value="showstudents" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $("#reporttype").change(function(){
            $( "select option:selected").each(function(){
                if($(this).attr("value")=="caste"){
                    $(".report").hide();
                    $(".caste").show();
                }
                if($(this).attr("value")=="class"){
                    $(".report").hide();
                    $(".class").show();
                }
              
            });
        }).change();
    });
</script>

