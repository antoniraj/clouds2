<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
        $model = & $this->getModel();
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
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
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
 //       $pathway->addItem('SMS',$modulelink);
        $pathway->addItem('BULK SMS');



?>

<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>
<?php
        $this->showlinks();
?>

<!-- The following script is used to show the limit in the text area box -->
<script>
$(document).ready(function () {

  $('#smstext').keypress(function (event) {
    var max = 315;
    var len = $(this).val().length;

    if (event.which < 0x20) {
      // e.which < 0x20, then it's not a printable character
      // e.which === 0 - Not a character
      return; // Do nothing
    }

    if (len >= max) {
      event.preventDefault();
    }

  });

  $('#smstext').keyup(function (event) {
    var max = 315;
    var len = $(this).val().length;
    var char = max - len;

    $('#textleft').text(char + ' characters left');

  });

});
</script>



<br />
<br />
<br />


			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Bulk Sms</h2>
						<div class="box-icon">
						<div class="pull-right">
							  <button type="submit" class="btn btn-primary">Send Sms</button>
						</div>

						</div>
					</div>
					<div class="box-content">
						<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
						  <fieldset>
         
							<div class="control-group">
							  <label class="control-label" for="textarea2">SMS Message <br /></label>
							  <div class="controls">
								<textarea class=""  style="width:400px;" id="smstext" rows="3" name="smstext" maxlength="315"><?php echo $this->rec->smstext; ?></textarea>
<div id="textleft">315 characters left</div>
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
							<input type="hidden" name="task" id="task" value="logbulksms" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->


