<?php
$userData = fetchAllUsers(); //Fetch information for all users

echo resultBlock($errors,$successes);

echo "
<form name='adminUsers' action='".$websiteUrl."/manager.php?save=users' method='post'>
<table class='table table-bordered'>
<tr>
<th>Delete</th><th>Username</th><th>Title</th><th>Last Sign In</th>
</tr>";

//Cycle through users
foreach ($userData as $v1) {
	echo "
	<tr>
	<td><input type='checkbox' name='delete[".$v1['id']."]' id='delete[".$v1['id']."]' value='".$v1['id']."'></td>
	<td><a href='user&id=".$v1['id']."'>".$v1['user_name']."</a></td>
	<td>".$v1['title']."</td>
	<td>
	";
	
	//Interprety last login
	if ($v1['last_sign_in_stamp'] == '0'){
		echo "Never";	
	}
	else {
		echo date("j M, Y", $v1['last_sign_in_stamp']);
	}
	echo "
	</td>
	</tr>";
}

echo "
</table>
<input type='submit' name='Submit' value='Delete' class='btn btn-default' />
</form>
";

?>
