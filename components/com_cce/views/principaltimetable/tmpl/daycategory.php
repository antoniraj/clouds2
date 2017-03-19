<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

    include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includecss.php');
   	$model = & $this->getModel('timetable');

	$daycategories= $model->getDayCategories();


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
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);

//Add Day Category
        $addlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=adddaycategory&layout=addeditdaycategory&Itemid='.$Itemid);

?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/daycategory.png'; ?>" alt="" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Day Category  Management</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>

	<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Sessions Management</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
					</div>
					</div>
					<div class="box-content">
<div class="row-fluid sortable">
				<?php
                 foreach($daycategories as $rec) {
				       $assignlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=dayassigncourses&sdid='.$rec->id.'&Itemid='.$Itemid);
                       $deletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=deletedaycategory&layout=daycategory&Itemid='.$Itemid.'&sdid='.$rec->id);
                       $editlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=addeditdaycategory&Itemid='.$Itemid.'&sdid='.$rec->id);
                       $dayslink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=days&Itemid='.$Itemid.'&sdid='.$rec->id);
				    	$cids = $model->getDayCourses($rec->id);	
					 
			    ?>
				<div class="box span3">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i>   <?php echo $rec->description; ?></h2>
						<div class="box-icon">
							<a href="<?php echo $deletelink; ?>"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	<div class="row-fluid">
						<div class="box-content">
						<table class="table table-striped">
						  <thead>
							  <tr>
								  <th>Class</th>
								  <th>Term</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
					foreach($cids as $cid) {
						                $r = $model->getTimeTableTerm($cid->termid,$trec);
                     	          		$coursedeletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=deletedaycourse&layout=daycategory&tid='.$cid->termid.'&Itemid='.$Itemid.'&cid='.$cid->cid.'&sdid='.$rec->id);
										$r = $model->getCourse($cid->cid,$crec);
						                 
                    	?>
							  <tr>
								<td><?php echo $crec->code; ?></td>
								<td><?php echo $trec->term; ?></td>
								<td>
								<a class="btn btn-mini btn-danger" href="<?php echo $coursedeletelink; ?>">
										<i class="icon-trash icon-white"></i> 
										Delete
									</a>
								</td>
								
								 </tr>
							<?php
								}
							?>
							 </tbody>
					  </table>    
					  <a class="btn btn-mini btn-success" href="<?php echo $assignlink; ?>">
										<i class="icon-plus-sign"></i>  
										Assign Courses                                           
					   </a>
					    <a class="btn btn-mini btn-info" href="<?php echo $dayslink; ?>">
										<i class="icon-zoom-in icon-white"></i>  
										Session Category                                          
					   </a>
					</div>

                    </div>                   
                  </div>
         
				</div><!--/span-->
                      <?php
				
				$i++;
				}
				?>
				
			</div><!--/row-->
				<div class="form-actions">
								<a href="#" class="btn btn-info btn-setting">Add Category</a>
								<button class="btn">Cancel</button>
							  </div>
	</div>
</div><!--/span-->
							
</div><!--/row-->

       <div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Add Category</h3>
			</div>
			<div class="modal-body">
				<?php
					$scid= JRequest::getVar('scid');
				   	$model = & $this->getModel('timetable');
					$rs = $model->getSessionCategory($scid,$rec);
					if($rs==false) {
						$rec->id = -1;
						$rec->description='';
					}

				?>
				
				<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
				 <div class="control-group">
								<label class="control-label" for="focusedInput">Category Description</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="description" type="text" value="<?php echo $rec->description; ?>" />
								</div>
				 </div>
						
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<button class="btn btn-primary"  value="Save" id="submit" name="submit">Save</button>
				
			 </div>
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="view" name="view" value="timetable" />
        <input type="hidden" id="controller" name="controller" value="timetable" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="task" id="task" value="savedaycategory" />
        <input type="hidden" name="layout" id="layout" value="daycategory" />
			</form>
		</div>


<?php
 include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includejs.php');
?>


