<?php

	
$pageId = $_GET['id'];
$pageDetails = fetchPageDetails($pageId); //Fetch information specific to page

//Forms posted

$pagePermissions = fetchPagePermissions($pageId);
$permissionData = fetchAllPermissions();



echo resultBlock($errors,$successes);

echo "
<form name='page' action='".$websiteUrl."/manager.php?save=page&id=".$pageId."' method='post'>
<input type='hidden' name='process' value='1'>
<table class='table table-bordered'>
<tr><td>
<h3>Page Information</h3>
<div id='regbox'>
<p>
<label>ID:</label>
".$pageDetails['id']."
</p>
<p>
<label>Name:</label>
".$pageDetails['page']."
</p>
<p>
<label>Private:</label>";

//Display private checkbox
if ($pageDetails['private'] == 1){
	echo "<input type='checkbox' name='private' id='private' value='Yes' checked>";
}
else {
	echo "<input type='checkbox' name='private' id='private' value='Yes'>";	
}

echo "
</p>
</div></td><td>
<h3>Page Access</h3>
<div id='regbox'>
<p>
Remove Access:";

//Display list of permission levels with access
foreach ($permissionData as $v1) {
	if(isset($pagePermissions[$v1['id']])){
		echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
	}
}

echo"
</p><p>Add Access:";

//Display list of permission levels without access
foreach ($permissionData as $v1) {
	if(!isset($pagePermissions[$v1['id']])){
		echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
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
