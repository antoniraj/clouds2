<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$accountid= JRequest::getVar('accountid');
	$model = & $this->getModel('fees');

	$rs = $model->getFeeAccount($accountid,$rec);
	if($rs==false) {
		$rec->id = -1;
		$rec->title='';
		$rec->code='';
		$rec->feeprefix='';
		$rec->receiptno='0';
	}
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';


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
	$fcItemid = $model->getMenuItemid('manageschool','Fee Category');
        if($fcItemid) ;
        else{
                $fcItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);
   	$accountlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeaccounts&Itemid='.$Itemid);
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
    //    $pathway->addItem('Home', $dashboardlink);
      //  $pathway->addItem('Fees',$modulelink);
//        $pathway->addItem('Fee Structures',$fclink);
  //      $pathway->addItem('Edit Fee Head' );



?>


<b style="font: bold 15px Georgia, serif;">ADD/EDIT FEE ACCOUNT</b>

<div class="row-fluid sortable" width="50%">
				<div class="box span12">
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
		                      <div class="control-group">
								<label class="control-label" for="focusedInput">Account Title</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="title" type="text" value="<?php echo $rec->title; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Account Code</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="code" type="text" value="<?php echo $rec->code; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Fee Prefix</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="feeprefix" type="text" value="<?php echo $rec->feeprefix; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Current Receipt No</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="receiptno" type="text" value="<?php echo $rec->receiptno; ?>">
								</div>
							  </div>

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
							</div>
						  </fieldset>
						  
						  
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="view" name="view" value="fees" />
        <input type="hidden" id="controller" name="controller" value="fees" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="task" id="task" value="savefeeaccount" />
        <input type="hidden" name="layout" id="layout" value="feeaccounts" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

</form>
