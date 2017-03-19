<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$il= JRequest::getVar('includeleave1');
	if(!$il) $includeleave='1';
	else $includeleave='0';
	$model = & $this->getModel('classattendance');
	$model1 = & $this->getModel('classleave');
	$model->getRegularAbsentees($arecs);
  
	$iconsDir1 = JURI::base() . 'components/com_cce/images';


        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('attendance','Absentees By Date');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=attendance&Itemid='.$masterItemid);


	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Attendance',$modulelink);
        $pathway->addItem("Regular Absentees");

		
?>




	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Regular Absentees with Permission</h2>
					
							<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th><input type="checkbox" value=""></th>
								  <th>Reg. No</th>
								  <th>Name</th>
								  <th>Class</th>
								  <th>No.of Days</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
						$i=1;
							foreach($arecs as $rec){
								$model->getStudent($rec['studentid'],$srec);
								$model1->getRegularLeaveTakersByID($rec['studentid'],$lrec);
								$model->getCourse($srec->joinedclassid,$crec);
								echo '<tr>';
								echo '<td>'.$i++.'</td>';
								echo '<td>'.$srec->registerno.'</td>';
								echo '<td>'.$srec->firstname.'</td>';
								echo '<td>'.$crec->code.'-'.$crec->sectionname.'</td>';
								echo '<td>'.(round(($rec['abs']),2)).'</td>';
								echo '</tr>';
							}

                            ?>
							 </tbody>
					  </table>            
					</div>

				</div><!--/span-->
			
			</div><!--/row-->
						

