<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelAttitudesAndValues extends JModel
{

	function __construct(){
        	parent::__construct();
        }

	function getAttitudeAndValue($pid,&$rec)
        {
                $q = 'SELECT id,activityname,activitycode,description FROM #__attitudesandvalues WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addAttitudeAndValue($pactivity,$pactivitycode,$pdescription)
       {
                $q = "INSERT INTO #__attitudesandvalues(activityname,activitycode,description) VALUES('".$pactivity."','".$pactivitycode."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateAttitudeAndValue($id,$pactivity,$pactivitycode,$pdescription)
        {
                $q = "UPDATE #__attitudesandvalues SET activityname='".$pactivity."', activitycode='".$pactivitycode."', description='".$pdescription."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteAttitudeAndValue($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__attitudesandvalues WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getAttitudesAndValues()
        {
                $query = "SELECT id,activityname,activitycode,description FROM #__attitudesandvalues";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }
}
