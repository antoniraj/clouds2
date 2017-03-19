
<?php
        defined('_JEXEC') or die('Denied..');
	$app = JFactory::getApplication();
	$iconsdir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	     $library1 = JURI::base() . 'components/com_cce/images/library/';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
   	$model = & $this->getModel('cce');
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$library= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=library&Itemid='.$masterItemid);
 	$issuebook= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&task=display&layout=circulation&Itemid='.$masterItemid);

  	$aylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=academicyears&view=academicyears&task=display&Itemid='.$ayItemid);


?>

<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $library1.'/issuebook.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> SearCh Student </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 28px; height: 28px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $library; ?>"><img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="Master" style="width: 30px; height: 30px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $issuebook; ?>"><img src="<?php echo $library1.'/issuebook.png'; ?>" alt="Master" style="width: 28px; height: 28px;" /></a><br />
			</div>
			
                </td>
        </tr>
</table>
				
			<div class="row-fluid sortable">
				<div class="box">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Search Student</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
							<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
					
							<fieldset>
								<div class="span3"></div>
								<div class="span5">
									<br>
								<div class="control-group">
								<label class="control-label" for="appendedInputButton">Roll Number</label>
								<div class="controls">
								  <div class="input-append">
									<input id="appendedInputButton" size="16" name="rollno" type="text" value="<?php echo $this->student->rollno; ?>"><button class="btn" type="submit" value="Go" name="Go">Go!</button>
								  </div>
								</div>
							  </div>
							  <div class="span3"></div>
						
				
							</fieldset>
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="bookid" name="bookid" value="<?php echo echo JRequest::getVar('bookid');  ?>" />
							<input type="hidden" id="view" name="view" value="circulation" />
							<input type="hidden" id="controller" name="controller" value="circulation" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="Go" />
							<input type="hidden" name="layout" id="layout" value="issuestudent" />	
													
						  </form>
					
				</div><!--/span-->
			</div><!--/row-->
