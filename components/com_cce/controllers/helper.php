<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
require_once( JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php' );

class Helper
{

	static function checkuser()
	{
		$user = JFactory::getUser();
		if($user->get('id')==0){
			return false;
		} 
		return true;
	}
	
	static function checkgroup($gname)
	{
	        $user =& JFactory::getUser();
	        $fl=0;
	        foreach ($user->groups as $groupId => $value){
	                $db = JFactory::getDbo();
	                $db->setQuery(
	                    'SELECT `title`' .
	                    ' FROM `#__usergroups`' .
	                    ' WHERE `id` = '. (int) $groupId
	                );
	                $groupName = $db->loadResult();
	                if($groupName==$gname){
	                         $fl=1;
	                         break;
	                }
	                
	        }
	
	        if($fl==0) {
	                echo "ERROR";
	                return false;
	        }

		return true;
	}

}

?>
