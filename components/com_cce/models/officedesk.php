<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

include_once('cce.php');
class CceModelOfficeDesk extends CceModelCce {
        function __construct(){
                parent::__construct();
        }

        function getDeskInfo(&$rec)
        {
                $q = 'SELECT `id`,`message` FROM #__officedesk LIMIT 1';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

       function saveDeskInfo($pmessage)
       {
                $q = "INSERT INTO #__officedesk(`message`) VALUES(trim('".$pmessage."'))";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateDeskInfo($id,$ptext)
        {
                $q = "UPDATE #__officedesk SET `message`=trim('".$ptext."') WHERE `id`=".$id;
                $db = & JFactory::getDBO();

                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}
}
