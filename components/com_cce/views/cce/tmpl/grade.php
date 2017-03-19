<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';

   $faactivitieslink=JRoute::_("index.php?option=com_cce&controller=faactivities&view=faactivities");
   $fagradeslink=JRoute::_("index.php?option=com_cce&controller=fagrades&view=fagrades");
   $lsactivitieslink=JRoute::_("index.php?option=com_cce&controller=lsactivities&view=lsactivities");
   $attitudesandvalueslink=JRoute::_("index.php?option=com_cce&controller=attitudesandvalues&view=attitudesandvalues");
   $coscholasticaactivitieslink=JRoute::_("index.php?option=com_cce&controller=coscholasticaactivities&view=coscholasticaactivities");
   $coscholasticbactivitieslink=JRoute::_("index.php?option=com_cce&controller=coscholasticbactivities&view=coscholasticbactivities");
   $scholasticbgradeslink=JRoute::_("index.php?option=com_cce&controller=scholasticbgrades&view=scholasticbgrades");
   $tgradebooklink=JRoute::_("index.php?option=com_cce&controller=tgradebook&view=tgradebook");
?>
<br />
<h1>Examination Settings</h1>
<hr />
<table width="100%" cellpadding="10">
        <tr>
                <td align="center">
                        <a href="<?php echo $faactivitieslink; ?>"><img src="<?php echo $iconsDir.'/faactivities.png'; ?>" alt="FA Activities" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $faactivitieslink; ?>"><h1>FA Activities</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $fagradeslink; ?>"><img src="<?php echo $iconsDir.'/fagrades.png'; ?>" alt="FA Grades" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $fagradeslink; ?>"><h1>FA Grades</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $lsactivitieslink; ?>"><img src="<?php echo $iconsDir.'/lsactivities.png'; ?>" alt="Life Skills" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $lsactivitieslink; ?>"><h1>Life Skills</h1></a>
                </td>
	</tr><tr>
                <td align="center">
                        <a href="<?php echo $attitudesandvalueslink; ?>"><img src="<?php echo $iconsDir.'/attitudesandvalues.png'; ?>" alt="Attitude and Values" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $attitudesandvalueslink; ?>"><h1>Attitude and Values</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $coscholasticaactivitieslink; ?>"><img src="<?php echo $iconsDir.'/coscholasticaactivities.png'; ?>" alt="CoScholastic-A Activities" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $coscholasticaactivitieslink; ?>"><h1>CoScholastic-A Activities</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $coscholasticbactivitieslink; ?>"><img src="<?php echo $iconsDir.'/coscholasticbactivities.png'; ?>" alt="CoScholastic-B Activities" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $coscholasticbactivitieslink; ?>"><h1>CoScholastic-B Activities</h1></a>
                </td>
	</tr><tr>
                <td align="center">
                        <a href="<?php echo $scholasticbgradeslink; ?>"><img src="<?php echo $iconsDir.'/scholasticbgrades.png'; ?>" alt="Scholastic-B grades" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $scholasticbgradeslink; ?>"><h1>Scholastic-B Grades</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $tgradebooklink; ?>"><img src="<?php echo $iconsDir.'/tgradebook.png'; ?>" alt="Grade Book Template" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $tgradebooklink; ?>"><h1>Grade Book Template</h1></a>
                </td>
                <td align="center">
                </td>
	</tr>
</table>
