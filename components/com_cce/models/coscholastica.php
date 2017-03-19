<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelCoScholasticA extends JModel
{

	function __construct(){
        	parent::__construct();
        }

	function getCoScholasticAActivity($pid,&$rec)
        {
                $q = 'SELECT id,activityname,activitycode,description FROM #__coscholasticaactivities WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addCoScholasticAActivity($pactivity,$pactivitycode,$pdescription)
       {
                $q = "INSERT INTO #__coscholasticaactivities(activityname,activitycode,description) VALUES('".$pactivity."','".$pactivitycode."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateCoScholasticAActivity($id,$pactivity,$pactivitycode,$pdescription)
        {
                $q = "UPDATE #__coscholasticaactivities SET activityname='".$pactivity."', activitycode='".$pactivitycode."', description='".$pdescription."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteCoScholasticAActivity($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__coscholasticaactivities WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getCoScholasticAActivities()
        {
                $query = "SELECT id,activityname,activitycode,description FROM #__coscholasticaactivities";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }
}
