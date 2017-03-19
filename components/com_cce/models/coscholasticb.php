<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelCoScholasticB extends JModel
{

	function __construct(){
        	parent::__construct();
        }

	function getCoScholasticBActivity($pid,&$rec)
        {
                $q = 'SELECT id,activityname,activitycode,description FROM #__coscholasticbactivities WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addCoScholasticBActivity($pactivity,$pactivitycode,$pdescription)
       {
                $q = "INSERT INTO #__coscholasticbactivities(activityname,activitycode,description) VALUES('".$pactivity."','".$pactivitycode."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateCoScholasticBActivity($id,$pactivity,$pactivitycode,$pdescription)
        {
                $q = "UPDATE #__coscholasticbactivities SET activityname='".$pactivity."', activitycode='".$pactivitycode."', description='".$pdescription."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteCoScholasticBActivity($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__coscholasticbactivities WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getCoScholasticBActivities()
        {
                $query = "SELECT id,activityname,activitycode,description FROM #__coscholasticbactivities";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }
}
