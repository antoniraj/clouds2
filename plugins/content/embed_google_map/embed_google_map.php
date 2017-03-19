<?php
/**
* @version		$Id: Embed Google Map v1.4.0 2013-12-06 09:07 $
* @package		Joomla 1.6
* @copyright	Copyright (C) 2012 Petteri Kivimäki. All rights reserved.
* @author		Petteri Kivimäki
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
 
 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgContentembed_google_map extends JPlugin
{
	function plgContentembed_google_map( &$subject, $params ) 
	{
		parent::__construct( $subject, $params );
	}

	function onContentPrepare($context, &$row, &$params, $limitstart)
	{	
		$output = $row->text;
		$regex = "#{google_map}(.*?){/google_map}#s";
		$found = preg_match_all($regex, $output, $matches);
			
		$count = 0;

		if ( $found )
		{
			foreach ( $matches[0] as $value ) 
			{			
				// Load plugin params info
				$map_type = $this->params->def('map_type', 'm');
				$zoom_level = $this->params->def('zoom', 14);
				$language = $this->params->def('language', '-');
				$add_link =  $this->params->def('add_link', 1);
				$link_label = $this->params->def('link_label', 'View Larger Map');
				$link_full = $this->params->def('link_full', 1);
				$show_info =  $this->params->def('show_info', 0);
				$height = $this->params->def('height', 300);
				$width =  $this->params->def('width', 400);
				$border =  $this->params->def('border', 0);
				$border_style =  $this->params->def('border_style', 'solid');
				$border_color =  $this->params->def('border_color', '#000000');
				$https = $this->params->def('https', 1);
				$protocol = "";
				$url = "maps.google.com/";
				$info_label = "";
							
				$map = $value;
				$map = str_replace('{google_map}','', $map);
				$map = str_replace('{/google_map}','', $map);
				$address = $map;
				$find = '|';

				if( strstr($map, $find) )
				{
					$arr = explode('|',$map);
					$address = $arr[0];

					foreach ( $arr as $phrase ) {
						if ( strstr(strtolower($phrase), 'type:') )
						{
							$tpm1 = explode(':',$phrase);
 							$tmp1 = trim($tpm1[1], '"');
							if(strcmp(strtolower($tmp1),'normal') == 0) {
								$map_type = 'm';
							} else if(strcmp(strtolower($tmp1),'satellite') == 0) {
								$map_type = 'k';
							} else if(strcmp(strtolower($tmp1),'hybrid') == 0) {
								$map_type = 'h';
							} else if(strcmp(strtolower($tmp1),'terrain') == 0) {
								$map_type = 'p';
							} 
						}
						
						if ( strstr(strtolower($phrase), 'zoom:') )	
						{       
							$tpm1 = explode(':',$phrase);
							$zoom_level = trim($tpm1[1], '"');
						}
						
						if ( strstr(strtolower($phrase), 'height:') )	
						{       
							$tpm1 = explode(':',$phrase);
							$height = trim($tpm1[1], '"');
						}
										
						if ( strstr(strtolower($phrase), 'width:') )
						{
							$tpm1 = explode(':',$phrase);
							$width = trim($tpm1[1], '"');
						}
						
						if ( strstr(strtolower($phrase), 'border:') )	
						{       
							$tpm1 = explode(':',$phrase);
							$border = trim($tpm1[1], '"');
						}	
						
						if ( strstr(strtolower($phrase), 'border_style:') )	
						{       
							$tpm1 = explode(':',$phrase);							
							$border_style = trim($tpm1[1], '"');
							$border_style = ( preg_match('/^(none|hidden|dotted|dashed|solid|double)$/i', $border_style) ? $border_style : 'solid' );
						}	
						
						if ( strstr(strtolower($phrase), 'border_color:') )	
						{       
							$tpm1 = explode(':',$phrase);
							$border_color = trim($tpm1[1], '"');							
						}	
						
						if ( strstr(strtolower($phrase), 'lang:') )	
						{       
							$tpm1 = explode(':',$phrase);
							$language = trim($tpm1[1], '"');
						}							
						
						if ( strstr(strtolower($phrase), 'link:') )
						{
							$tpm1 = explode(':',$phrase);
 							$tmp1 = trim($tpm1[1], '"');
							if(strcmp(strtolower($tmp1),'yes') == 0) {
								$add_link = 0;
							} else {
								$add_link = 1;
							}
						}
						
						if ( strstr(strtolower($phrase), 'link_label:') )	
						{       
							$tpm1 = explode(':',$phrase);
							$link_label = trim($tpm1[1], '"');
						}
						
						if ( strstr(strtolower($phrase), 'link_full:') )
						{
							$tpm1 = explode(':',$phrase);
 							$tmp1 = trim($tpm1[1], '"');
							if(strcmp(strtolower($tmp1),'yes') == 0) {
								$link_full = 0;
							} else {
								$link_full = 1;
							}
						}
						
						if ( strstr(strtolower($phrase), 'show_info:') )
						{
							$tpm1 = explode(':',$phrase);
 							$tmp1 = trim($tpm1[1], '"');
							if(strcmp(strtolower($tmp1),'yes') == 0) {
								$show_info = 0;
							} else {
								$show_info = 1;
							}
						}
						
						if ( strstr(strtolower($phrase), 'info_label:') )	
						{       
							$tpm1 = explode(':',$phrase);
							$info_label = trim($tpm1[1], '"');
						}

						if ( strstr(strtolower($phrase), 'https:') )
						{
							$tpm1 = explode(':',$phrase);
 							$tmp1 = trim($tpm1[1], '"');
							if(strcmp(strtolower($tmp1),'yes') == 0) {
								$https = 0;
							} else {
								$https = 1;
							}
						}						
					}
				}
				
				$protocol = ($https == 0) ? "https://" : "http://";				
				$url = "$protocol$url";
				
				if(strcmp($language,'system') == 0) {
					$lng = JFactory::getLanguage();
					$langtag = $lng->getTag();
					$langprfx = explode('-', $langtag);
					$language = "&hl=".$langprfx[0];
				} else if(strcmp($language,'-') != 0) {
					$language = "&hl=$language";
				} else {
					$language = "";
				}
				
				if(preg_match('/{(.*?)}/', $link_label, $mtcs)){
					$link_label = JText::_($mtcs[1]);
				}
				
				if(preg_match('/^http(s|):\/\//i', $address)) {
					$url = $address;
				} else {
					$url .= "?q=$address";
					if(strlen($info_label) > 0) {
						$url .= "($info_label)";
					}
				}
				
				$info = ($show_info == 0) ? "" : "&iwloc=near";			

				$border_color = (preg_match('/^#[a-f0-9]{6}$/i', $border_color) ? $border_color : '#000000');
				
				// Unicode properties are available only if PCRE is compiled with "--enable-unicode-properties" 
				// '\pL' = any Unicode letter
                if (preg_match('/^[^\pL]+$/u', $address)) {
					$info = ($show_info == 0) ? "&iwloc=near" : "";
                }
							
				$replacement[$count] = "\n<iframe width='$width' height='$height' style='border: ".$border."px $border_style $border_color' ";
				$replacement[$count] .= "src='$url&z=$zoom_level&output=embed$language&t=$map_type$info'></iframe>\n";
				if($add_link == 0) {
					$output = ($link_full == 0) ? "&output=embed" : "";
					$replacement[$count] .= "<div><a href='$url&z=$zoom_level$language&t=$map_type$info$output' target='new'>$link_label</a></div>\n";
				}
				$count++;
			}
			for( $i = 0; $i < count($replacement); $i++ )
			{
				$row->text = preg_replace( $regex, $replacement[$i], $row->text,1);
			}
		}
		return true;
	}	
}

?>
