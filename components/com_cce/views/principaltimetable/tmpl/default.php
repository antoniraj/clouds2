<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('cce');

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

   	$atItemid = $model->getMenuItemid('master','Academic Terms');
   	if($atItemid) ;
   	else{
        	$atItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/terms.png'; ?>" alt="Terms" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Academic Terms</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1master.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>




<br />
<form action="<?php echo JRoute::_('index.php?option=com_cce&task=actionType&controller=terms'); ?>" method="POST" name="adminForm">
<table border="0" cellspacing="2" width="100%" cellpadding="3">
<tr>
        <th class="list-title">OPTION</th>
        <th class="list-title" width="20%">TERM</th>
        <th class="list-title" width="20%">CODE</th>
        <th class="list-title" width="20%">MONTHS</th>
        <th class="list-title" width="20%">START</th>
        <th class="list-title" width="20%">STOP</th>
</tr>
        <?php
                foreach($this->terms as $rec) {
                    //    $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=terms&controller=courses&task=edit&cid[]='.$rec->id);
        ?>
        <tr>
                <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
                <td><?php echo $rec->term; ?></td>
                <td><?php echo $rec->code; ?></td>
                <td><?php echo $rec->months; ?></td>
                <td><?php echo $rec->startdate; ?></td>
                <td><?php echo $rec->stopdate; ?></td>
        </tr>
        <?php } ?>
</table>
<br />
<table border="0" width="100%">
<tr  style="border:none;"> <td  style="border:none;" width="50%"><input type="submit" class="button_delete"  value="Delete" name="Delete">
<input type="submit" class="button_edit" name="Edit" value="Edit"></td>
<td  style="border:none;" width="50%" align="right"><input type="submit" class="button_add" name="Add" value="Add"> </td> </tr>
<input type="hidden" name="view" value="terms" />
<input type="hidden" name="controller" value="terms" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="aid" value="<?php echo $this->cay[0]->id; ?>" />
<input type="hidden" name="task" value="actions"/>
</table>
</form>
