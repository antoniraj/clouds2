<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');

   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

   $model = & $this->getModel('cce');
 $model = & $this->getModel('cce');
   $this->assignRef( 'model', $model);
   $Itemid=JRequest::getVar('Itemid');
   $app =& JFactory::getApplication();
   $pathway =& $app->getPathway();
   $pathway->addItem('News');
   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   $topnewslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=topnews&controller=news&task=display&Itemid='.$topnewsItemid);
   $stafflink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffnews&controller=news&task=display&Itemid='.$staffItemid);
   $parentlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=parentnews&controller=news&task=display&Itemid='.$parentItemid);
   $studentlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentnews&controller=news&task=display&Itemid='.$studentItemid);
   $officedesklink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=officedesk&controller=officedesk&task=display&Itemid='.$DeskItemid);
   $thoughtslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&view=thoughtsfortheday&controller=news&task=display&Itemid='.$DeskItemid);

?>

			<br>
<div align="center">
	<div class="row-fluid">
				<div class="span3 show-grid">
				          <a href="<?php echo $topnewslink; ?>"><img src="<?php echo $iconsDir1.'/topnews.png'; ?>" alt="Flash News" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $topnewslink; ?>"><h2 class="item-page-title">Flash News</h2></a>
            
				</div>
				<div class="span3 show-grid">
				            <a href="<?php echo $stafflink; ?>"><img src="<?php echo $iconsDir1.'/staffnews.png'; ?>" alt="Staff News" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $stafflink; ?>"><h2 class="item-page-title">Staff News</h2></a>
           
				</div>
				<div class="span3 show-grid">
				               <a href="<?php echo $studentlink; ?>"><img src="<?php echo $iconsDir1.'/studentnews.png'; ?>" alt="Student News" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $studentlink; ?>"><h2 class="item-page-title">Student News</h2></a>
         
				</div>
				<div class="span3 show-grid">
				               <a href="<?php echo $parentlink; ?>"><img src="<?php echo $iconsDir1.'/parentnews.png'; ?>" alt="Parent News" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $parentlink; ?>"><h2 class="item-page-title">Parent News</h2></a>
         
				</div>
			</div>
				<div class="row-fluid">
				<div class="span3 show-grid">
				            <a href="<?php echo $officedesklink; ?>"><img src="<?php echo $iconsDir1.'/officedesk.png'; ?>" alt="" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $officedesklink; ?>"><h2 class="item-page-title">Office Desk</h2></a>
           
				</div>
          			<div class="span3 show-grid">
				            <a href="<?php echo $thoughtslink; ?>"><img src="<?php echo $iconsDir1.'/t_thoughts.png'; ?>" alt="" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $thoughtslink; ?>"><h2 class="item-page-title">Thoughts for the day</h2></a>
           
				</div>	
			</div>
			<br>

			

</div>
