<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $sdid= JRequest::getVar('sdid');
  
    include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includecss.php');
        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model = & $this->getModel('timetable');
	$courses = $model->getCurrentCourses();
	$terms = $model->getCurrentTimeTableTerms();

        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Time Table');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $sdItemid = $model->getMenuItemid('manageschool','Day Category');
        if($sdItemid) ;
        else{
                $sdItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
        $sdlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=daycategory&Itemid='.$Itemid);

?>
<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
                <div style="float:left">
                        <img src="<?php echo $iconsDir.'/courses.png'; ?>" alt="Courses" style="width: 44px; height: 44px;" />
                </div>
                <div style="float:left">
			<h1></h1>
                        <h1 class="item-page-title" align="left">Select the Courses</h1>
                </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $sdlink; ?>"><img src="<?php echo $iconsDir.'/daycategory.png'; ?>" alt="Days" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>


<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						    <h2>Select the Courses</h2>
								<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>

							  <tr>
								  <th>Option</th>
								  <th>Code</th>
								  <th>Course Name</th>
							  </tr>
						  </thead>   
						  <tbody>
					
					
								<?php
								if($courses){
										   foreach($courses as $rec) {   ?>
									 <tr>
											<td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
											<td><?php echo $rec->code; ?></td>
											<td><?php echo $rec->coursename; ?></td>
									 </tr>
								<?php 
								  }
							  }
								  ?>
							 </tbody>
							 

					  </table>  
					  				<div align="left">
							            Select Term:   <select name="terms">
												<option value="">Select any option</option>
										<?php
												foreach($terms as $term)
												{
														echo '<option value="'.$term->id.'">'.$term->term.'</option>';
												}
										?>
										</select>
										</div>          
					</div>
					 <div class="form-actions">

								<button type="submit" class="btn btn-primary">Assign</button>
							  </div>
   				    
				
				</div><!--/span-->
			
			</div><!--/row-->
						

<input type="hidden" name="controller" value="timetable" />
<input type="hidden" id="view" name="view" value="timetable" />
<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" id="task" value="dayassigncourses" />
<input type="hidden" name="layout" id="layout" value="daycategory" />
<input type="hidden" name="sdid" id="sdid" value="<?php echo $sdid; ?>" />
</form>


<?php
 include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includejs.php');
?>


