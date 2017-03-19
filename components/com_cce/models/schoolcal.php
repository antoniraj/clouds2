<?php

include_once('cce.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelSchoolCal extends CceModelCce
{

	function __construct(){
        	parent::__construct();
        }

	function getCalEntry($pdate,&$data)
        {
                $q = 'SELECT `id`, `cdate`,`description`,`daytype`,`dayorder` FROM #__schoolcal WHERE `cdate` = \''.$pdate.'\'';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }


       function addCalEntry($pdate,$pdescription,$pdaytype,$pdayorder)
       {

                $q = "INSERT INTO #__schoolcal(`cdate`,`description`,`daytype`,`dayorder`) VALUES('".$pdate."','".$pdescription."','".$pdaytype."','".$pdayorder."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateCalEntry($pid,$pdescription,$pdaytype,$pdayorder)
        {

                $q = "UPDATE #__schoolcal SET `description`='".$pdescription."', `dayorder`='".$pdayorder."', `daytype`='".$pdaytype."' WHERE `id` =".$pid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



	function getCal($pfromdate,$ptodate,&$data)
        {
                $q = "SELECT `id`, `cdate`,`pdescription`,`daytype`,`dayorder` FROM #__schoolcal WHERE `cdate` BETWEEN '".$pfromdate."' AND '".$ptodate."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }
        function upcomingEvents(&$data)
        {
                $query = "SELECT id,cdate,description,daytype FROM #__schoolcal WHERE length(description) >= 3  AND cdate >= current_date LIMIT 10";
				$db = & JFactory::getDBO();
                $db->setQuery($query);
                $data = $db->loadObjectList();
                if($data==null)
                        return false;
                return true;
        }
	
        function getTotalHalfWorkingDays($pfromdate,$ptodate,&$wds){
                $q = "SELECT count(*) AS hdays FROM `#__schoolcal` WHERE `daytype` = 'HAD' AND  `cdate` BETWEEN '".$pfromdate."' AND '".$ptodate."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $wds = $db->loadAssocList();
                if($wds==null)
                        return false;
                return true;
        }


	function getTotalLeaveDays($pfromdate,$ptodate,&$lds){
                $q = "SELECT count(*) AS days FROM `#__schoolcal` WHERE `daytype` = 'HD' AND  `cdate` BETWEEN '".$pfromdate."' AND '".$ptodate."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $wds = $db->loadAssocList();
                if($wds==null)
                        return false;
                return true;
	}

	function getTotalWorkingDays($pfromdate,$ptodate,&$wds){
                $q = "SELECT count(*) AS days FROM `#__schoolcal` WHERE `daytype` = 'WD' AND  `cdate` BETWEEN '".$pfromdate."' AND '".$ptodate."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $wds = $db->loadAssocList();
                if($wds==null)
                        return false;
                return true;
	}
}




