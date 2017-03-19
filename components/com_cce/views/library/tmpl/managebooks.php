
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	 $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
    $iconsDir1 = JURI::base() . 'components/com_cce/images';
     $library = JURI::base() . 'components/com_cce/images/library/';
	$Itemid = JRequest::getVar('Itemid');
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
 

   $addbook= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&view=librarymanagebooks&layout=addbook&task=add&Itemid='.$smsItemid);
   $listbook= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&view=librarymanagebooks&layout=listbook&task=view&Itemid='.$smsItemid);
   $searchbook= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&view=librarymanagebooks&layout=searchbook&task=view&Itemid='.$smsItemid);
 ?>



<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/book.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Manage Books </h1>
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

<div align="center">
			<div class="row-fluid">
<div class="span3"></div>
				<div class="span3  show-grid">
				                <a href="<?php echo $addbook; ?>"><img src="<?php echo $library.'/addbook.png'; ?>" alt="Add book" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $addbook; ?>"><h2 class="item-page-title">Add Book</h2></a>
        
				</div>
					<div class="span1"></div>
				<div class="span3  show-grid">
				            <a href="<?php echo $listbook; ?>"><img src="<?php echo $library.'/listbook.png'; ?>" alt="List books" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $listbook; ?>"><h2 class="item-page-title">List Books</h2></a>
            
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

