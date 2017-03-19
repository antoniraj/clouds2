

<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model = & $this->getModel('timetable');

        $days = $model->getDays();


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
?>


<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-edit"></i>Days</h2>
                        <div class="box-icon">
			<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=timetable&view=timetable&task=display&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
				<div class="pull-right">
					<button class="btn btn-small btn-primary" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Add Day</button>        
				</div>	
				<input type="hidden" name="view" value="timetable" />
				<input type="hidden" name="controller" value="timetable" />
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="addday"/>
				<input type="hidden" name="layout" value="addeditday"/>
			</form>
                        </div>
                </div>
                <div class="box-content">
                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                        <tr>
                                                <th  class="sorting_disabled">S.No</th>
                                                <th class="list-title" width="50%">DAY TITLE</th>
                                                <th class="list-title" width="15%">CODE</th>
                                                <th class="list-title" width="10%">ACTIVE</th>
                                                <th class="list-title" width="20%">OPTIONS</th>
                                        </tr>
                                </thead>
                                <tbody>

<?php
        $i=1;
        foreach($days as $rec) {
                $deletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=deleteday&layout=days&sdid='.$sdid.'&Itemid='.$Itemid.'&ddid='.$rec->id);
                $editlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=addeditday&sdid='.$sdid.'&Itemid='.$Itemid.'&ddid='.$rec->id);
?>
                                        <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $rec->title; ?></td>
                                                <td> <?php echo $rec->code; ?> </td>
                                                <td> <?php
                                                        if($rec->active==1)
                                                        {
                                                                echo '<span class="label label-success">Active</span>';
                                                        }
                                                        else{
                                                                echo '<span class="label label-important">Inactive</span>';
                                                        }
                                                ?></td>
                                                <td align="center">
                                                        <a href="<?php echo $editlink; ?>"><img src="<?php echo $iconsDir.'/edit.png'; ?>" alt="Edit" style="width: 20px; height: 20px;" /></a>
                                                        <a href="<?php echo $deletelink; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="Delete" style="width: 20px; height: 20px;" /></a>
                                                </td>
                                        </tr>
                                        <?php
                                                $i++;
         }
                                        ?>
                                </tbody>
                         </table>
		</div><!--/span-->
	</div><!--/row-->
</div><!--/row-->

