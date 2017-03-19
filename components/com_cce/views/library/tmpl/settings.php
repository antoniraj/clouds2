
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$library = JURI::base() . 'components/com_cce/images/library/';
    $iconsDir1 = JURI::base() . 'components/com_cce/images/';
     $iconsDir = JURI::base() . 'components/com_cce/images/64x64/';
	$Itemid = JRequest::getVar('Itemid');
	$model = & $this->getModel();
	$model4 = & $this->getModel('news');
	$courses=$model->getCurrentCourses();
	$cdate=date('d-m-Y');
	$staffphotoDir = JURI::base() . 'components/com_cce/staffphoto/';
 	$studentphotoDir = JURI::base() . 'components/com_cce/studentsphoto/';
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

$librarymodule= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=library&Itemid='.$masterItemid);
 
   $bookcategory= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarysettings&view=librarysettings&layout=bookcategory&task=view&Itemid='.$smsItemid);
   $studentdetails= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarysettings&view=librarysettings&layout=studentdetails&task=view&Itemid='.$smsItemid);
   $viewauthors= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarysettings&view=librarysettings&layout=authordetails&task=view&Itemid='.$smsItemid);
 ?>



<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Library Settings </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 28px; height: 28px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $librarymodule; ?>"><img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="Master" style="width: 30px; height: 30px;" /></a><br />
			</div>

			
                </td>
        </tr>
</table>
<br>
<br>
<br>

<div align="center">
			<div class="row-fluid">
								<div class="span2"></div>
				<div class="span3 show-grid">
				                <a href="<?php echo $bookcategory; ?>"><img src="<?php echo $library.'/bookcategory.png'; ?>" alt="BulkSMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $bookcategory; ?>"><h2 class="item-page-title">Add Book Category</h2></a>
        
				</div>
					<div class="span1"></div>
				<div class="span3 show-grid">
				            <a href="<?php echo $studentdetails; ?>"><img src="<?php echo $iconsDir1.'/1students.png'; ?>" alt="Group SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $studentdetails; ?>"><h2 class="item-page-title">View Student Details</h2></a>
            
				</div>
					<div class="span1"></div>
			</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</div>

