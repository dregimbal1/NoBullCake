<?php 
/*
"NoBull"Cake
built using UserCake Version: 2.0.2
*/

// login.php
require_once('models/config.php');

// Get the template
$folder = $settings['template']['value'];
if(empty($settings['template']['value'])){
	$folder = 'default';
}
$root = 'styles/' . $folder . '/';

$do = $_GET['do'];

if(empty($do)){
	header("Location:index.php");
	die();
}
if($do == 'login'){
		$errors = array();
		$username = sanitize(trim($_POST["username"]));
		$password = trim($_POST["password"]);

		//Perform some validation
		//Feel free to edit / change as required
		if($username == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
			header("Location:login");
			die();
		}
		if($password == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
			header("Location:login");
			die();
		}

		if(count($errors) == 0)
		{
			//A security note here, never tell the user which credential was incorrect
			if(!usernameExists($username))
			{
				$_SESSION['errors'] = lang("ACCOUNT_USER_OR_PASS_INVALID");
				header("Location:login");
				die();
			}
			else
			{
				$userdetails = fetchUserDetails($username);
				//See if the user's account is activated
				if($userdetails["active"]==0)
				{
					$_SESSION['errors'] = lang("ACCOUNT_INACTIVE");
					header("Location:login");
					die();
				}
				else
				{
					//Hash the password and use the salt from the database to compare the password.
					$entered_pass = generateHash($password,$userdetails["password"]);
					
					if($entered_pass != $userdetails["password"])
					{
						//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
						//$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
						$_SESSION['errors'] = lang("ACCOUNT_USER_OR_PASS_INVALID");
						header("Location:login");
						die();
					}
					else
					{
						//Passwords match! we're good to go'
						
						//Construct a new logged in user object
						//Transfer some db data to the session object
						$loggedInUser = new loggedInUser();
						$loggedInUser->email = $userdetails["email"];
						$loggedInUser->user_id = $userdetails["id"];
						$loggedInUser->hash_pw = $userdetails["password"];
						$loggedInUser->title = $userdetails["title"];
						$loggedInUser->username = $userdetails["user_name"];
						
						//Update last sign in
						$loggedInUser->updateLastSignIn();
						$_SESSION["userCakeUser"] = $loggedInUser;
						
						//Redirect to user account page
						//print("you will be redirected after 3 seconds..");
						//flush();sleep(3);
						//header("Location: pages/account.php");
						header("Location:account");
						die();
						//redirect('pages/account.php');
					}
				}
			}
		}
}
if($do == 'register'){
		$errors = array();
		$email = trim($_POST["email"]);
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$confirm_pass = trim($_POST["passwordc"]);
		$captcha = md5($_POST["captcha"]);
		
		
		if ($captcha != $_SESSION['captcha'])
		{
			$_SESSION['errors'] = lang("CAPTCHA_FAIL");
			header("Location:register");
			die();
		}
		if(minMaxRange(5,25,$username))
		{
			$_SESSION['errors'] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
			header("Location:register");
			die();

		}
		if(!ctype_alnum($username)){
			$_SESSION['errors'] = lang("ACCOUNT_USER_INVALID_CHARACTERS");
			header("Location:register");
			die();

		}
		if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
		{
			$_SESSION['errors'] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
			header("Location:register");
			die();

		}
		else if($password != $confirm_pass)
		{
			$_SESSION['errors'] = lang("ACCOUNT_PASS_MISMATCH");
			header("Location:register");
			die();

		}
		if(!isValidEmail($email))
		{
			$_SESSION['errors'] = lang("ACCOUNT_INVALID_EMAIL");
			header("Location:register");
			die();

		}
		//End data validation
		if(count($errors) == 0)
		{	
			//Construct a user object
			$user = new User($username,$password,$email);
			
			//Checking this flag tells us whether there were any errors such as possible data duplication occured
			if(!$user->status)
			{
				if($user->username_taken) $_SESSION['errors'] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
				if($user->email_taken) 	  $_SESSION['errors'] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
				header("Location:register");
				die();
			}
			else
			{
				//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
				if(!$user->userCakeAddUser())
				{
					if($user->mail_failure) $_SESSION['errors'] = lang("MAIL_ERROR");
					if($user->sql_failure)  $_SESSION['errors'] = lang("SQL_ERROR");
					$_SESSION['success'] = $user->success;
					header("Location:login");
					die();
				}
			}
		}
}

include($root . 'header.php'); 
//echo resultBlock($errors,$successes);
?>
Oh no! Something went wrong. <a href="<?php echo $websiteUrl; ?>">Return home</a>
<?php
include($root . 'footer.php');
