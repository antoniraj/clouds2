<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$fcid= JRequest::getVar('fcid');
	$fpid= JRequest::getVar('fpid');
	$accountid= JRequest::getVar('accountid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');
	$rs = $model->getFeeParticular_t($fpid,$rec);
	if($rs==false) {
		$rec->id = -1;
		$rec->name='';
		$rec->description='';
		$rec->amount=0.0;
	}

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
	$fpItemid = $model->getMenuItemid('manageschool','Fee Particulars');
        if($fpItemid) ;
        else{
                $fpItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);
   	$fclink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeheads&fcid='.$fcid.'&Itemid='.$Itemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Fee Structures',$fclink);
        $pathway->addItem('Add/Edit Particular');
?>
<!-- TOP LINKS....DASHBOARD 
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/fees.png'; ?>" alt="" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-description" align="left">Add/Edit Fee Particular</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/fees.png'; ?>" alt="Module" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $sclink; ?>"><img src="<?php echo $iconsDir.'/fees.png'; ?>" alt="Fees" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>

-->

<b style="font: bold 15px Georgia, serif;">EDIT FEE PARTICULAR</b>
<div class="box-content" style="width:30%;">
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
<center>
	<table width="100%" cellpadding="10">
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Particular Name</td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="name" name="name" size="32" maxlength="30" value="<?php echo $rec->name; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Description </td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="description" name="description" size="50" maxlength="100" value="<?php echo $rec->description; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Amount</td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="amount" name="amount" size="32" maxlength="10" value="<?php echo $rec->amount; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Applicable for Groups Only</td>
                        <td align="left" style="border:none;" >
                                                                <?php if($rec->groupbased==1) { ?>
                                                                  <input class="input-xlarge focused" id="focusedInput" checked="true" name="groupbased" type="checkbox" value="<?php echo $rec->groupbased; ?>">
                                                                <?php }
                                                                else { ?>
                                                                  <input class="input-xlarge focused" id="focusedInput"  name="groupbased" type="checkbox" value="<?php echo $rec->groupbased; ?>">
                                                                <?php } ?>
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Account</td>
                        <td align="left" style="border:none;" >
  <select id="selectError" data-rel="chosen" style="width:230px;" name="accountid">
                <option value="">Select an Account</option>
                <?php
		$accounts = $model->getFeeAccounts();
                foreach($accounts as $account) :
                        echo "<option value=\"".$account->id."\" ".($account->id == $accountid ? "selected=\"yes\"" : "").">".$account->title."</option>";
                endforeach;
                ?>
        </select>
			</td>
		</tr>


                <tr style="border:none;" >
                        <td align="center" style="border:none;" >
			<input type="submit" class="button_save" value="Save" id="submit" name="submit" />
			</td>
		</tr>
        </table>
</center>
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="view" name="view" value="fees" />
        <input type="hidden" id="controller" name="controller" value="fees" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="fcid" id="fcid" value="<?php echo $fcid; ?>" />
        <input type="hidden" name="fpid" id="fpid" value="<?php echo $fpid; ?>" />
        <input type="hidden" name="task" id="task" value="savefeeparticular_t" />
        <input type="hidden" name="layout" id="layout" value="feeheads" />
</form>

</div>
