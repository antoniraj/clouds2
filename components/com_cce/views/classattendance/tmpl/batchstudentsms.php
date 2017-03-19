<?php

        defined('_JEXEC') OR DIE('Access denied..');

        $app = JFactory::getApplication();

	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';

	$Itemid  = JRequest::getVar('Itemid');

		$courseid  = JRequest::getVar('courseid');

		JHtml::stylesheet('styles.css','./components/com_cce/css/');

        JHTML::script('academicyear.js', 'components/com_cce/js/');

           JHTML::script('validate.js', 'components/com_cce/js/');

        $model = & $this->getModel();

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);

        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('SMS',$modulelink);
        $pathway->addItem('Batch SMS');





?>

<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>

<?php
        $this->showlinks();
?>



<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">

<div class="row-fluid sortable">		

				<div class="box span12">

					<div class="box-header well" data-original-title>

						

						<h2><i class="icon-user"></i> Student Batch Sms</h2>
						<div class="pull-right">
							<button type="submit" class="btn btn-primary" name="send" value="Send">Send Sms</button>
						</div>

						<div style="float:right;margin-top:-5px;">

								

					</div>

						</div>

					</div>

													

				

					<div class="box-content">

                    

                    		 <div class="control-group">

								<label class="control-label" for="selectError1">Select Course</label>

								<div class="controls">

								  <select id="selectError1" multiple data-rel="chosen" name="courses[]">

									<?php

								$courses=$model->getCurrentCourses();

								foreach($courses as $course)

								{

									echo '<option value="'.$course->id.'">'.$course->code.'</option>';

								}

								?>

								  </select>

								</div>

							  </div>

							<div class="control-group">

							  <label class="control-label" for="textarea2">SMS Message<br />(Max. 300 Characters allowed)</label>

							  <div class="controls">

								<textarea class="" id="textarea2" rows="3" name="smstext" onkeypress="if (this.value.length > 300) { return false; }"  maxlength="300"> <?php echo $this->rec->smstext; ?></textarea>

							  </div>

							</div>

					</div>

				</div><!--/span-->
							<div class="form-actions">
							<button type="submit" class="btn btn-primary" name="send" value="Send">Send Sms</button>
							  </div>

			</div><!--/row-->

<br />

<input type="hidden" name="controller" value="sms" />
<input type="hidden" name="view" value="sms" />
<input type="hidden" name="layout" value="batchstudentsms" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="logstudentsbatchsms"/>
</form>




