<?php

include_once('cce.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelReminders extends CceModelCce
{

	function __construct(){
        	parent::__construct();
        }

	function getReminderEntry($pdate,&$data)
        {
                $q = 'SELECT `id`, `cdate`,`description` FROM #__reminders WHERE `cdate` = \''.$pdate.'\'';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }


       function addReminderEntry($pdate,$pdescription)
       {
                $q = "INSERT INTO #__reminders(`cdate`,`description`) VALUES('".$pdate."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateReminderEntry($pid,$pdescription)
        {
                $q = "UPDATE #__reminders SET `description`='".$pdescription."' WHERE `id` =".$pid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



	function getReminder($pfromdate,$ptodate,&$data)
        {
                $q = "SELECT `id`, `cdate`,`pdescription` FROM #__reminders WHERE `cdate` BETWEEN '".$pfromdate."' AND '".$ptodate."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }
	




}



