<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');

	$feeaccounts= $model->getFeeAccounts();


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
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);
   	//$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);

//Add Fee Category
        $addlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditfeeaccountt&Itemid='.$Itemid);

//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
 //       $pathway->addItem('Home', $dashboardlink);
        //$pathway->addItem('Fees',$modulelink);
   //     $pathway->addItem('Settings',$modulelink);
     //   $pathway->addItem('Fee Heads');
?>

<b style="font: bold 15px Georgia, serif;">FEE ACCOUNTS</b>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<div class="pull-right">
	<a class="btn btn-info" href="<?php echo $addlink; ?>"> <i class="icon-plus-sign icon-white"></i>  Add Fee Account</a>
</div>
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>SNO</th>
								  <th>FEE ACCOUNTS</th>
								  <th>ACCOUNT CODE</th>
								  <th>FEE RECEIPT PREFIX</th>
								  <th>CURRENT RECEIPT NUMBER</th>
								  <th>OPERATIONS</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
                if($feeaccounts){
		   $i=1;
                   foreach($feeaccounts as $rec) {
                       $deletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=deletefeeaccount&layout=feeaccounts&Itemid='.$Itemid.'&accountid='.$rec->id);
                       $editlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=addeditfeeaccountt&Itemid='.$Itemid.'&accountid='.$rec->id);
        ?>
        <tr>
                 <td><?php echo $i; ?></td>
                 <td>
			<?php echo $rec->title; ?>
		</td>
                 <td>
			<?php echo $rec->code; ?>
		</td>
                 <td>
			<?php echo $rec->feeprefix; ?>
		</td>
                 <td>
			<?php echo $rec->receiptno; ?>
		</td>
                 <td>
			<a href="<?php echo $editlink; ?>"><img src="<?php echo $iconsDir.'/edit.png'; ?>" alt="EditFeeAccount" style="width: 20px; height: 20px;" /></a>
			<a href="<?php echo $deletelink; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="DeleteFeeAccount" style="width: 20px; height: 20px;" /></a>
		</td>
        </tr>
        <?php
		$i++;
                  }
                }else{?>
                <tr> <td  align="center">...</td><td></td><td></td><td></td></tr>
                <?php }
         ?>
	
							 </tbody>
					  </table>            
					</div>
                     
					  <div style="width:100%;">
						 <div style="float:left;"></div>
							<div style="float:right;">
							
							  <a class="btn btn-info" href="<?php echo $addlink; ?>"> <i class="icon-plus-sign icon-white"></i>  Add Fee Account</a>
	                         </div> 
					         <br>
					         <br>
	                 </div>
				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="layout" value="addeditfeeaccountt" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display"/>
</form>



