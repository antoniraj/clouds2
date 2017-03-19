
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        JHTML::script('validate.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $fcids= JRequest::getVar('fcids');
        $fpid= JRequest::getVar('fpid');
        $flag= JRequest::getVar('flag');
        $eon= JRequest::getVar('eon');

        $fstid= JRequest::getVar('fstid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model = & $this->getModel('fees');
	$courses = $model->getCurrentCourses();

        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Fees');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $fcItemid = $model->getMenuItemid('manageschool','Fee Category');
        if($fcItemid) ;
        else{
                $fcItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);
        $fclink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feecategory&Itemid='.$Itemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Fee Structures',$fclink);
        $pathway->addItem('Assign Courses');

?>
<!-- TOP LINKS....DASHBOARD 
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
                <div style="float:left">
                        <img src="<?php echo $iconsDir.'/courses.png'; ?>" alt="Courses" style="width: 44px; height: 44px;" />
                </div>
                <div style="float:left">
                        <h1 class="item-page-title" align="left">Select the Courses</h1>
                </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/fees.png'; ?>" alt="Fees" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $fclink; ?>"><img src="<?php echo $iconsDir.'/fees.png'; ?>" alt="Fees" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>
-->

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Assign Courses</strong></h2>
						<div class="box-icon">
							<button class="btn btn-small btn-success" name="Add" value="Assign"><i class="icon-plus-sign icon-white"></i> Assign</button>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
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
						<div class="form-actions" align="right">
							<button class="btn btn-small btn-success" name="Add" value="Assign"><i class="icon-plus-sign icon-white"></i> Assign</button>
	                 </div>          
					</div>
				</div><!--/span-->
			</div><!--/row-->
<input type="hidden" name="controller" value="fees" />
<input type="hidden" id="view" name="view" value="fees" />
<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" id="task" value="assigncourses" />
<input type="hidden" name="layout" id="layout" value="feecategory" />
<input type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>" />
<input type="hidden" name="fpid" id="fpid" value="<?php echo $fpid; ?>" />
<input type="hidden" name="fcids" id="fcids" value="<?php echo $fcids; ?>" />
<input type="hidden" name="eon" id="eon" value="<?php echo $eon; ?>" />
<input type="hidden" name="fstid" id="fstid" value="<?php echo $fstid; ?>" />
</form>
