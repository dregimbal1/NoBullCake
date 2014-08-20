<?php
$permissionId = $_GET['id'];
$permissionDetails = fetchPermissionDetails($permissionId); //Fetch information specific to permission level

$pagePermissions = fetchPermissionPages($permissionId); //Retrieve list of accessible pages
$permissionUsers = fetchPermissionUsers($permissionId); //Retrieve list of users with membership
$userData = fetchAllUsers(); //Fetch all users
$pageData = fetchAllPages(); //Fetch all pages


echo resultBlock($errors,$successes);

echo "
<form name='adminPermission' action='".$websiteUrl."/manager.php?save=permission&id=".$permissionId."' method='post'>
<table class='table table-bordered'>
<tr><td>
<h3>Permission Information</h3>
<div id='regbox'>
<p>
<label>ID:</label>
".$permissionDetails['id']."
</p>
<p>
<label>Name:</label>
<input type='text' name='name' value='".$permissionDetails['name']."' />
</p>
<label>Delete:</label>
<input type='checkbox' name='delete[".$permissionDetails['id']."]' id='delete[".$permissionDetails['id']."]' value='".$permissionDetails['id']."'>
</p>
</div></td><td>
<h3>Permission Membership</h3>
<div id='regbox'>
<p>
Remove Members:";

//List users with permission level
foreach ($userData as $v1) {
	if(isset($permissionUsers[$v1['id']])){
		echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['user_name'];
	}
}

echo"
</p><p>Add Members:";

//List users without permission level
foreach ($userData as $v1) {
	if(!isset($permissionUsers[$v1['id']])){
		echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['user_name'];
	}
}

echo"
</p>
</div>
</td>
<td>
<h3>Permission Access</h3>
<div id='regbox'>
<p>
Public Access:";

//List public pages
foreach ($pageData as $v1) {
	if($v1['private'] != 1){
		echo "<br>".$v1['page'];
	}
}

echo"
</p>
<p>
Remove Access:";

//List pages accessible to permission level
foreach ($pageData as $v1) {
	if(isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){
		echo "<br><input type='checkbox' name='removePage[".$v1['id']."]' id='removePage[".$v1['id']."]' value='".$v1['id']."'> ".$v1['page'];
	}
}

echo"
</p><p>Add Access:";

//List pages inaccessible to permission level
foreach ($pageData as $v1) {
	if(!isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){
		echo "<br><input type='checkbox' name='addPage[".$v1['id']."]' id='addPage[".$v1['id']."]' value='".$v1['id']."'> ".$v1['page'];
	}
}

echo"
</p>
</div>
</td>
</tr>
</table>
<p>
<label>&nbsp;</label>
<input type='submit' value='Execute' class='btn btn-default' />
</p>
</form>
";

?>
