<?php
$userId = $_GET['id'];

//Check if selected user exists
/*
if(!userIdExists($userId)){
	header("Location: admin_users.php"); die();
}
*/

$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details


$userPermission = fetchUserPermissions($userId);
$permissionData = fetchAllPermissions();

//echo $errors;

echo "
<form name='adminUser' action='".$websiteUrl."/manager.php?save=user&id=".$userId."' method='post'>
<table class='table table-bordered'><tr><td>
<h3>User Information</h3>
<div id='regbox'>
<p>
<label>ID:</label>
".$userdetails['id']."
</p>
<p>
<label>Username:</label>
".$userdetails['user_name']."
</p>
<p>
<label>Display Name:</label>
<input type='text' name='display' value='".$userdetails['display_name']."' />
</p>
<p>
<label>Email:</label>
<input type='text' name='email' value='".$userdetails['email']."' />
</p>
<p>
<label>Active:</label>";

//Display activation link, if account inactive
if ($userdetails['active'] == '1'){
	echo "Yes";	
}
else{
	echo "No
	</p>
	<p>
	<label>Activate:</label>
	<input type='checkbox' name='activate' id='activate' value='activate'>
	";
}

echo "
</p>
<p>
<label>Title:</label>
<input type='text' name='title' value='".$userdetails['title']."' />
</p>
<p>
<label>Sign Up:</label>
".date("j M, Y", $userdetails['sign_up_stamp'])."
</p>
<p>
<label>Last Sign In:</label>";

//Last sign in, interpretation
if ($userdetails['last_sign_in_stamp'] == '0'){
	echo "Never";	
}
else {
	echo date("j M, Y", $userdetails['last_sign_in_stamp']);
}

echo "
</p>
<p>
<label>Delete:</label>
<input type='checkbox' name='delete[".$userdetails['id']."]' id='delete[".$userdetails['id']."]' value='".$userdetails['id']."'>
</p>
<p>
<label>&nbsp;</label>
<input type='submit' value='Execute' class='btn btn-default' />
</p>
</div>
</td>
<td>
<h3>Permission Membership</h3>
<div id='regbox'>
<p>Remove Permission:";

//List of permission levels user is apart of
foreach ($permissionData as $v1) {
	if(isset($userPermission[$v1['id']])){
		echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
	}
}

//List of permission levels user is not apart of
echo "</p><p>Add Permission:";
foreach ($permissionData as $v1) {
	if(!isset($userPermission[$v1['id']])){
		echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
	}
}

echo"
</p>
</div>
</td>
</tr>
</table>
</form>
";

?>
