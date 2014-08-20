<?php 
/*
"NoBull"Cake
built using UserCake Version: 2.0.2
*/

// manager processes
require_once('models/config.php');
$save = $_GET['save'];
if(!$loggedInUser->checkPermission(array(2))){
	header("Location:index.php");
	die();
}
if(empty($save)){
	header("Location:manager");
	die();
}
if($save == 'users'){
	$deletions = $_POST['delete'];
	if ($deletion_count = deleteUsers($deletions)){
		$_SESSION['success'] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
	}
	else {
		$_SESSION['errors'] = lang("SQL_ERROR");
	}
}
if($save == 'user'){
	$userId = $_GET['id'];

//Check if selected user exists
/*
if(!userIdExists($userId)){
	header("Location: admin_users.php"); die();
}
*/

	$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details
	//Delete selected account
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deleteUsers($deletions)) {
			$_SESSION['success'] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
		else {
			$_SESSION['errors'] = lang("SQL_ERROR");
		}
		header("Location: manager/users"); die();
	}
	else
	{
		
		//Activate account
		if(isset($_POST['activate']) && $_POST['activate'] == "activate"){
			if (setUserActive($userdetails['activation_token'])){
				$_SESSION['success'] = lang("ACCOUNT_MANUALLY_ACTIVATED", array($displayname));
			}
			else {
				$_SESSION['errors'] = lang("SQL_ERROR");
			}
		}
		
		//Update email
		if ($userdetails['email'] != $_POST['email']){
			$email = trim($_POST["email"]);
			
			//Validate email
			if(!isValidEmail($email))
			{
				$_SESSION['errors'] = lang("ACCOUNT_INVALID_EMAIL");

			}
			elseif(emailExists($email))
			{
				$_SESSION['errors'] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
	
			}
			else {
				if (updateEmail($userId, $email)){
					$_SESSION['success'] = lang("ACCOUNT_EMAIL_UPDATED");
				}
				else {
					$_SESSION['errors'] = lang("SQL_ERROR");
					
				}
			}
		}
		
		//Update title
		if ($userdetails['title'] != $_POST['title']){
			$title = trim($_POST['title']);
			
			//Validate title
			if(minMaxRange(1,50,$title))
			{
				$_SESSION['errors'] = lang("ACCOUNT_TITLE_CHAR_LIMIT",array(1,50));
			}
			else {
				if (updateTitle($userId, $title)){
					$_SESSION['success'] = lang("ACCOUNT_TITLE_UPDATED", array ($displayname, $title));
				}
				else {
					$_SESSION['errors'] = lang("SQL_ERROR");
				}
			}
		}
		
		//Remove permission level
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($remove, $userId)){
				$_SESSION['success'] = lang("ACCOUNT_PERMISSION_REMOVED", array ($deletion_count));
			}
			else {
				$_SESSION['errors'] = lang("SQL_ERROR");
			}
		}
		
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($add, $userId)){
				$_SESSION['success'] = lang("ACCOUNT_PERMISSION_ADDED", array ($addition_count));
			}
			else {
				$_SESSION['errors'] = lang("SQL_ERROR");
			}
		}
		
		$userdetails = fetchUserDetails(NULL, NULL, $userId);
		header("Location: manager/user&id=$userId"); die();
	}
}
if($save == 'permissions'){
	//Delete permission levels
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deletePermission($deletions)){
		$successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
	}
	
	//Create new permission level
	if(!empty($_POST['newPermission'])) {
		$permission = trim($_POST['newPermission']);
		
		//Validate request
		if (permissionNameExists($permission)){
			$errors[] = lang("PERMISSION_NAME_IN_USE", array($permission));
		}
		elseif (minMaxRange(1, 50, $permission)){
			$errors[] = lang("PERMISSION_CHAR_LIMIT", array(1, 50));	
		}
		else{
			if (createPermission($permission)) {
			$successes[] = lang("PERMISSION_CREATION_SUCCESSFUL", array($permission));
		}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
	}
	header("Location: manager/permissions"); die();
}
if($save == 'permission'){

	$permissionId = $_GET['id'];

	//Check if selected permission level exists
	/*
	if(!permissionIdExists($permissionId)){
		header("Location: admin_permissions.php"); die();	
	}
	*/
	$permissionDetails = fetchPermissionDetails($permissionId); //Fetch information specific to permission level
	//Delete selected permission level
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deletePermission($deletions)){
		$successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
		header("Location: manager/permissions"); die();
	}
	else
	{
		//Update permission level name
		if($permissionDetails['name'] != $_POST['name']) {
			$permission = trim($_POST['name']);
			
			//Validate new name
			if (permissionNameExists($permission)){
				$errors[] = lang("ACCOUNT_PERMISSIONNAME_IN_USE", array($permission));
			}
			elseif (minMaxRange(1, 50, $permission)){
				$errors[] = lang("ACCOUNT_PERMISSION_CHAR_LIMIT", array(1, 50));	
			}
			else {
				if (updatePermissionName($permissionId, $permission)){
					$successes[] = lang("PERMISSION_NAME_UPDATE", array($permission));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Remove access to pages
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($permissionId, $remove)) {
				$successes[] = lang("PERMISSION_REMOVE_USERS", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Add access to pages
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($permissionId, $add)) {
				$successes[] = lang("PERMISSION_ADD_USERS", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Remove access to pages
		if(!empty($_POST['removePage'])){
			$remove = $_POST['removePage'];
			if ($deletion_count = removePage($remove, $permissionId)) {
				$successes[] = lang("PERMISSION_REMOVE_PAGES", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Add access to pages
		if(!empty($_POST['addPage'])){
			$add = $_POST['addPage'];
			if ($addition_count = addPage($add, $permissionId)) {
				$successes[] = lang("PERMISSION_ADD_PAGES", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
			$permissionDetails = fetchPermissionDetails($permissionId);
			header("Location: manager/permission&id=$permissionId"); die();
	}
}
if($save == 'configuration'){
	$cfgId = array();
	$newSettings = $_POST['settings'];
	
	//Validate new site name
	if ($newSettings[1] != $websiteName) {
		$newWebsiteName = $newSettings[1];
		if(minMaxRange(1,150,$newWebsiteName))
		{
			$_SESSION['errors'] = lang("CONFIG_NAME_CHAR_LIMIT",array(1,150));
		}
		else if (count($errors) == 0) {
			$cfgId[] = 1;
			$cfgValue[1] = $newWebsiteName;
			$websiteName = $newWebsiteName;
		}
	}
	
	//Validate new URL
	if ($newSettings[2] != $websiteUrl) {
		$newWebsiteUrl = $newSettings[2];
		if(minMaxRange(1,150,$newWebsiteUrl))
		{
			$_SESSION['errors'] = lang("CONFIG_URL_CHAR_LIMIT",array(1,150));
		}
		else if (substr($newWebsiteUrl, -1) != "/"){
			$_SESSION['errors'] = lang("CONFIG_INVALID_URL_END");
		}
		else if (count($errors) == 0) {
			$cfgId[] = 2;
			$cfgValue[2] = $newWebsiteUrl;
			$websiteUrl = $newWebsiteUrl;
		}
	}
	
	//Validate new site email address
	if ($newSettings[3] != $emailAddress) {
		$newEmail = $newSettings[3];
		if(minMaxRange(1,150,$newEmail))
		{
			$_SESSION['errors'] = lang("CONFIG_EMAIL_CHAR_LIMIT",array(1,150));
		}
		elseif(!isValidEmail($newEmail))
		{
			$_SESSION['errors'] = lang("CONFIG_EMAIL_INVALID");
		}
		else if (count($errors) == 0) {
			$cfgId[] = 3;
			$cfgValue[3] = $newEmail;
			$emailAddress = $newEmail;
		}
	}
	
	//Validate email activation selection
	if ($newSettings[4] != $emailActivation) {
		$newActivation = $newSettings[4];
		if($newActivation != "true" AND $newActivation != "false")
		{
			$_SESSION['errors'] = lang("CONFIG_ACTIVATION_TRUE_FALSE");
		}
		else if (count($errors) == 0) {
			$cfgId[] = 4;
			$cfgValue[4] = $newActivation;
			$emailActivation = $newActivation;
		}
	}
	
	//Validate new email activation resend threshold
	if ($newSettings[5] != $resend_activation_threshold) {
		$newResend_activation_threshold = $newSettings[5];
		if($newResend_activation_threshold > 72 OR $newResend_activation_threshold < 0)
		{
			$_SESSION['errors'] = lang("CONFIG_ACTIVATION_RESEND_RANGE",array(0,72));
		}
		else if (count($errors) == 0) {
			$cfgId[] = 5;
			$cfgValue[5] = $newResend_activation_threshold;
			$resend_activation_threshold = $newResend_activation_threshold;
		}
	}
	
	//Validate new language selection
	if ($newSettings[6] != $language) {
		$newLanguage = $newSettings[6];
		if(minMaxRange(1,150,$language))
		{
			$_SESSION['errors'] = lang("CONFIG_LANGUAGE_CHAR_LIMIT",array(1,150));
		}
		elseif (!file_exists($newLanguage)) {
			$_SESSION['errors'] = lang("CONFIG_LANGUAGE_INVALID",array($newLanguage));				
		}
		else if (count($errors) == 0) {
			$cfgId[] = 6;
			$cfgValue[6] = $newLanguage;
			$language = $newLanguage;
		}
	}
	
	//Validate new template selection
	if ($newSettings[7] != $template) {
		$newTemplate = $newSettings[7];
		if(minMaxRange(1,150,$template))
		{
			$_SESSION['errors'] = lang("CONFIG_TEMPLATE_CHAR_LIMIT",array(1,150));
		}
		elseif (!file_exists($newTemplate)) {
			$_SESSION['errors'] = lang("CONFIG_TEMPLATE_INVALID",array($newTemplate));				
		}
		else if (count($errors) == 0) {
			$cfgId[] = 7;
			$cfgValue[7] = $newTemplate;
			$template = $newTemplate;
		}
	}
	
	//Update configuration table with new settings
	if (count($errors) == 0 AND count($cfgId) > 0) {
		updateConfig($cfgId, $cfgValue);
		$_SESSION['success'] = lang("CONFIG_UPDATE_SUCCESSFUL");
		header("Location:manager/configuration");
		die();
	}
}

if($save == 'page'){
	$pageId = $_GET['id'];
	$pageDetails = fetchPageDetails($pageId); //Fetch information specific to page
	/*
	if(!pageIdExists($pageId)){
			header("Location: pages"); die();	
	}
	*/

		$update = 0;
		
		if(!empty($_POST['private'])){ $private = $_POST['private']; }
		
		//Toggle private page setting
		if (isset($private) AND $private == 'Yes'){
			if ($pageDetails['private'] == 0){
				if (updatePrivate($pageId, 1)){
					$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("private"));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		elseif ($pageDetails['private'] == 1){
			if (updatePrivate($pageId, 0)){
				$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("public"));
			}
			else {
				$errors[] = lang("SQL_ERROR");	
			}
		}
		
		//Remove permission level(s) access to page
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePage($pageId, $remove)){
				$successes[] = lang("PAGE_ACCESS_REMOVED", array($deletion_count));
				
			}
			else {
				$errors[] = lang("SQL_ERROR");	
			}
			
		}
		
		//Add permission level(s) access to page
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPage($pageId, $add)){
				$successes[] = lang("PAGE_ACCESS_ADDED", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");	
			}
		}
		
		$pageDetails = fetchPageDetails($pageId);
		header("Location: manager/page&id=$pageId");
		die();
}