<?php

$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels

echo resultBlock($errors,$successes);

echo "
<form name='adminPermissions' action='".$websiteUrl."/manager.php?save=permissions' method='post'>
<table class='table table-bordered'>
<tr>
<th>Delete</th><th>Permission Name</th>
</tr>";

//List each permission level
foreach ($permissionData as $v1) {
	echo "
	<tr>
	<td><input type='checkbox' name='delete[".$v1['id']."]' id='delete[".$v1['id']."]' value='".$v1['id']."'></td>
	<td><a href='permission&id=".$v1['id']."'>".$v1['name']."</a></td>
	</tr>";
}

echo "
</table>
<p>
<label>Permission Name:</label>
<input type='text' name='newPermission' />
</p>                                
<input type='submit' name='Submit' value='Execute' class='btn btn-default' />
</form>";

?>
