<?php 
/*
"NoBull"Cake
built using UserCake Version: 2.0.2
*/

// Check if someone needs to get displayed to the user
if(!empty($_SESSION['errors'])){
	$error = err($_SESSION['errors']);
}
if(!empty($_SESSION['success'])){
	$success = success($_SESSION['success']);
}
//Get the Page the user has requested to view 
if(isset($_REQUEST['page'])){ 
    if(isset($_REQUEST['page'])){ $inc_file = $_REQUEST['page']; } 

    //Cleans up the url if there is a forward slash at end of requested page 
    $inc_file = rtrim($inc_file,'/'); 

    //Loads requested page 
    $inc_file_dir = "pages/"; 
    $inc_file_ext = ".php"; 
     
    $inc_file_file = "${inc_file_dir}${inc_file}${inc_file_ext}"; 
	
	// Lockout { Determine if private page or not }
	$lockout = fetchAllPages();
	$thisPage = "${inc_file}${inc_file_ext}";

	if( $lockout[$thisPage]['private'] == 1 ){
		// This is a private page
		if(!isUserLoggedIn()){
			if(!empty($websiteUrl)) 
			{
				$add_http = "";
				
				if(strpos($websiteUrl,"http://") === false)
				{
					$add_http = "http://";
				}
				
				header("Location: ".$add_http.$websiteUrl);
				die();
			}
			else
			{
				header("Location: http://".$_SERVER['HTTP_HOST']);
				die();
			}
		}
	}
	
	// Logging out? Lets handle that here -
	if($thisPage == 'logout.php'){
		if(isUserLoggedIn()){
			$loggedInUser->userLogOut();

			if(!empty($websiteUrl)) 
			{
				$add_http = "";
				
				if(strpos($websiteUrl,"http://") === false)
				{
					$add_http = "http://";
				}
				
				header("Location: ".$add_http.$websiteUrl);
				die();
			}
			else
			{
				header("Location: http://".$_SERVER['HTTP_HOST']);
				die();
			}
			
		}else{

			if(!empty($websiteUrl)) 
			{
				$add_http = "";
				
				if(strpos($websiteUrl,"http://") === false)
				{
					$add_http = "http://";
				}
				
				header("Location: ".$add_http.$websiteUrl);
				die();
			}
			else
			{
				header("Location: http://".$_SERVER['HTTP_HOST']);
				die();
			}
			
		}
	}
	// Logging In/Registering? Better not be logged in!
	if($thisPage == 'login.php' || $thisPage == 'register.php'){
		if(isUserLoggedIn()){
			if(!empty($websiteUrl)) 
			{
				$add_http = "";
				
				if(strpos($websiteUrl,"http://") === false)
				{
					$add_http = "http://";
				}
				
				header("Location: ".$add_http.$websiteUrl);
				die();
			}
			else
			{
				header("Location: http://".$_SERVER['HTTP_HOST']);
				die();
			}
		
		}
	}
	
} 
if(isset($_REQUEST['profile'])){ 
    if(isset($_REQUEST['profile'])){ $inc_file = $_REQUEST['profile']; } 

    //Cleans up the url if there is a forward slash at end of requested page 
    $username = rtrim($inc_file,'/'); 
	$inc_file = "profile";
	$inc_file_ext = ".php"; 
	// Load profile data
	if(!isset($username)){
		echo 'Sorry, it appears that user does not exist.';
		 $inc_file_file = "${inc_file}${inc_file_ext}?=${username}"; 
	}else{
		if(!usernameExists($username)){
			echo 'Sorry, it appears that user does not exist.';
			 $inc_file_file = "${inc_file}${inc_file_ext}?=${user}"; 
		}else{
			# Found in database
			$data = array(
				'username' => $username
			);
			$inc_file_file = "${inc_file}${inc_file_ext}"; 
		}
	}
}
if(isset($_REQUEST['manager'])){ 
    if(isset($_REQUEST['manager'])){ $inc_file = $_REQUEST['manager']; } 

    //Cleans up the url if there is a forward slash at end of requested page 
    $inc_file = rtrim($inc_file,'/'); 

    //Loads requested page 
    $inc_file_dir = "pages/manager/"; 
    $inc_file_ext = ".php"; 
	
	if(isUserLoggedIn()){
		if($loggedInUser->checkPermission(array(2))){
			$inc_file_file = "${inc_file_dir}${inc_file}${inc_file_ext}"; 
		}
	}else{
		// we know it is not a 404, but lets not give away the fact this is the right directory
        $inc_file_content = " 
            <center> 
			404 Not Found
			<br>
            Go <a href='".$websiteUrl."'>Home</a></center> 
        "; 	
	}	
}
if(!empty($inc_file)){ 
    if(file_exists($inc_file_file)) { 
        $inc_file_filerun = "YESRUN"; 
    } else { 
        // Displays Error if page requested does not exist 
        $inc_file_content = " 
            <center> 
			404 Not Found
			<br>
            Go <a href='".$websiteUrl."'>Home</a></center> 
        "; 
    } 
} else { 
    if(isUserLoggedIn()){ 
        // File to show if user is logged in and no page requested 
        $inc_file_filerun = "YESRUN"; 
        $inc_file_file = "pages/index.inc.php";     
    }else{ 
        // File to show is user is not logged in and no page requested 
        $inc_file_filerun = "YESRUN"; 
        $inc_file_file = "pages/index.inc.php";     
    } 
} 
