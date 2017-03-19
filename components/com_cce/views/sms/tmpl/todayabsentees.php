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
	$model->gettodayabsentees($trecs);
  
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

	$sstext="Dear Parents,<br /> Your GENDER NAME [CLASS] is absent today ".date("d-m-Y").". <br /><br />Principal";

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
        $pathway->addItem("Today's Absentees");


		
?>

<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>

<?php
        $this->showlinks();
?>


  <form action="index.php" method="post" name="admin">

	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>  Today's Absentees</h2>
					
							<div class="box-icon">
                                                        <button type="submit" class="btn btn-primary">Send Sms</button>
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
								  <th>Session</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
						$i=1;
							foreach($trecs as $rec){
								$model->getStudent($rec['studentid'],$srec);
								$model1->getRegularLeaveTakersByID($rec['studentid'],$lrec);
								$model->getCourse($srec->joinedclassid,$crec);
								echo '<tr>';
								echo '<td>'.$i++.'</td>';
								echo '<td>'.$srec->registerno.'</td>';
								echo '<td>'.$srec->firstname.'</td>';
								echo '<td>'.$crec->code.'-'.$crec->sectionname.'</td>';
										if($rec['sessiontype']=='M' AND $rec['day']==1)
										{
											echo '<td><span class="label label-warning">Morning</span></td>';
										}
										else if($rec['day']==3 or $rec['day']==2)
										{
											echo '<td><span class="label label-success">Whole Day</span></td>';
										}
										else if($rec['sessiontype']=='E' AND $rec['day']==1)
										{
											echo '<td><span class="label label-important">Evening</span></td>';
										}
										else{
											echo '<td></td>';
											}
										
								echo '</tr>';
							}

                            ?>
							 </tbody>
					  </table>            
                                        <fieldset>
                                                <div class="control-group">
                                                        <label class="control-label" for="textarea2">Sms Message</label>
                                                        <div class="controls">
                                                                <textarea class="cleditor" style="width:500px;" id="textarea" rows="3" name="smstext"><?php echo $sstext; ?></textarea>
*** NAME,GENDER, CLASS and DATE  will be replaced with the actual name automatically.
                                                        </div>
                                                </div>
                                                <div class="form-actions">
                                                        <button type="submit" class="btn btn-primary">Send Sms</button>
                                                </div>
                                                </fieldset>
                                                        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
                                                        <input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
                                                        <input type="hidden" id="view" name="view" value="sms" />
                                                        <input type="hidden" id="layout" name="layout" value="smsqueue" />
                                                        <input type="hidden" id="controller" name="controller" value="sms" />
                                                        <input type="hidden" name="task" id="task" value="logtodaysabsenteessms" />
                                                        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />

                                        </form>

					</div>

				</div><!--/span-->
			
			</div><!--/row-->
						
