<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $scid= JRequest::getVar('scid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model = & $this->getModel('timetable');
	$sessions = $model->getSessions($scid);

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
        $scItemid = $model->getMenuItemid('manageschool','Session Category');
        if($scItemid) ;
        else{
                $scItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
        $sclink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=sessioncategory&Itemid='.$Itemid);

        $addlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=addsession&layout=addeditsession&scid='.$scid.'&Itemid='.$Itemid);
?>
<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
                <div style="float:left">
                        <img src="<?php echo $iconsDir.'/sessiontimings.png'; ?>" alt="SessionTimings" style="width: 44px; height: 44px;" />
                </div>
                <div style="float:left">
			<h1></h1>
                        <h1 class="item-page-title" align="left">Session Timings</h1>
                </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $sclink; ?>"><img src="<?php echo $iconsDir.'/sessions.png'; ?>" alt="Sessions" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>

<br />
<table border="0" cellspacing="2" width="100%" cellpadding="3">
<tr>
        <th class="list-title" width="5%">SNO</th>
        <th class="list-title" width="30%">SESSION TITLE</th>
        <th class="list-title" width="5%">CODE</th>
        <th class="list-title" width="20%">START</th>
        <th class="list-title" width="20%">STOP</th>
        <th class="list-title" width="20%">OPTIONS</th>
</tr>
  <?php
                if($sessions){
		   $i=1;
                   foreach($sessions as $rec) {
                       $deletelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=deletesession&layout=sessiontimings&scid='.$scid.'&Itemid='.$Itemid.'&stid='.$rec->id);
                       $editlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=timetable&controller=timetable&task=display&layout=addeditsession&scid='.$scid.'&Itemid='.$Itemid.'&stid='.$rec->id);
        ?>
        <tr>
                 <td><?php echo $i; ?></td>
                 <td>
			<a href="<?php echo $editlink; ?>"><?php echo $rec->title; ?></a>
		</td>
                 <td> <?php echo $rec->code; ?> </td>
                 <td> <?php echo $rec->start; ?> </td>
                 <td> <?php echo $rec->stop; ?> </td>
                 <td align="center">
			<a href="<?php echo $editlink; ?>"><img src="<?php echo $iconsDir.'/edit.png'; ?>" alt="EditTiming" style="width: 20px; height: 20px;" /></a>
			<a href="<?php echo $deletelink; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="DeleteTiming" style="width: 20px; height: 20px;" /></a>
		</td>
        </tr>
        <?php
		$i++;
                  }
                }else{?>
                <tr> <td colspan="4" align="center">...Nil.... </td></tr>
                <?php }
         ?>
	<tr><td colspan="5" align="left"> <a href="<?php echo $addlink; ?>"><img src="<?php echo $iconsDir.'/add.png'; ?>" alt="AddSession" style="width: 20px; height: 20px;" />Add Session</a> </td></tr>
</table>
