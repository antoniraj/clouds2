<?php
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
 
$hello = modRemindersHelper::getReport( $params );
require( JModuleHelper::getLayoutPath( 'mod_reminders' ) );
?>

