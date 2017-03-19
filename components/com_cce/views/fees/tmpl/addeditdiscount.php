<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$fcid= JRequest::getVar('fcid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');
	$rs = $model->getFeeCategory($fcid,$rec);
	if($rs==false) {
		$rec->id = -1;
		$rec->description='';
	}

	$studentcategories= $model->getStudentCategories();

	$courses = $model->getFeeCategoryCourses($fcid);

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
   	$fdlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=discounts&Itemid='.$Itemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Discounts',$fdlink);
        $pathway->addItem('Add/Edit Discounts');


?>
<!-- TOP LINKS....DASHBOARD 
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/fees.png'; ?>" alt="" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Add/Edit Fee Discounts</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/fees.png'; ?>" alt="Module" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $fdlink; ?>"><img src="<?php echo $iconsDir.'/fees.png'; ?>" alt="Fees" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>
-->


<b style="font: bold 15px Georgia, serif;">FEE DISCOUNT ADD/EDIT FORM</b>
<form action="index.php" method="POST" name="addform" id="addform">
        <table>
                <tr style="border:none;" >
                        <td align="left" style="border:none;" >Select a Student Category:
        <select name="studentcategoryid" style="width:180px;">
        <?php
                echo '<option>--Select a Category--</option>';
                foreach($studentcategories as $rec1)
                {
                 echo '<option value="'.$rec1->id.'">'.$rec1->categoryname.'('.$rec1->categorycode.')</option>';
                }
        ?>
        </select> 
     </td>
   </tr>

    		<tr style="border:none;" >
       			<td align="left" style="border:none;" >Select the Classes:
		<?php
			foreach($courses as $crec){
                		echo '<br /><input type="checkbox" name="class[]" checked="true" value="'.$crec->id.'" />'.$crec->code;
			}
		?>
                	</td>
                </tr>

                <tr style="border:none;" >
                        <td align="left" style="border:none;" >Fee Discount(%)
                                <input type="text" id="discount" name="discount" size="20" maxlength="5" value="<?php echo $rec1->discount; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="left" style="border:none;" colspan="2">
				<input type="submit" class="button_save" value="Save" id="submit" name="submit" />
			</td>
		</tr>
        </table>
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="fcid" name="fcid" value="<?php echo $fcid; ?>" />
        <input type="hidden" id="view" name="view" value="fees" />
        <input type="hidden" id="controller" name="controller" value="fees" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="task" id="task" value="savediscount" />
        <input type="hidden" name="layout" id="layout" value="discounts" />
</form>

