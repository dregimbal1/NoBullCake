<?php 
/*
"NoBull"Cake
built using UserCake Version: 2.0.2
*/

// Require UserCake
require_once('models/config.php');
if (!securePage($_SERVER['PHP_SELF'])){die();}
// Get the template
$folder = $settings['template']['value'];
if(empty($settings['template']['value'])){
	$folder = 'default';
}
$root_theme = 'styles/' . $folder . '/';
$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
// Handle page request
require_once('external/pagehand.php');
// Output
include($root_theme . 'header.php'); 
if(isset($inc_file_filerun)){}else{ $inc_file_filerun = "";} 
if($inc_file_filerun == 'YESRUN'){ 
    require_once("$inc_file_file"); 
} else { 
    echo "$inc_file_content";  
}
include($root_theme . 'footer.php');