<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
class CceModelLibrary extends JModel
{
	function __construct(){
        	parent::__construct();
        }

/* Library settings*/

	
        
	  function RouteEdit($rid){

                $db = & JFactory::getDBO();
                $q = "select id from `#__trans_route` WHERE `id` = ".$rid;
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) return false;
                else return true;
        }
		 function addRoute($dest,$cost,$mr)
       {
                $q = "INSERT INTO #__trans_route(destination,cost,mainroute)VALUES('".$dest."','".$cost."','".$mr."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateRoute($id,$dest,$cost,$mr)
        {
                $q = "UPDATE #__trans_route SET destination='".$dest."', cost='".$cost."', mainroute='".$mr."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

         function deleteRoute($rids)
        {
                $ids = implode(',',$rids);
                $q = 'DELETE FROM #__trans_route WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
	


}

