<?php

$languages = getLanguageFiles(); //Retrieve list of language files
$templates = getTemplateFiles(); //Retrieve list of template files
$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels

//echo $errors;
//echo $success;
?>
<form name="adminConfiguration" action="<?php echo $websiteUrl; ?>/manager.php?save=configuration" method="post" role="form">
  <hr>
  <h2>General Settings</h2>
  <div class="form-group">
    <label for="settings[<?php echo $settings['website_name']['id']; ?>]">Website Name</label>
    <input type="text" class="form-control" name="settings[<?php echo $settings['website_name']['id']; ?>]" placeholder="<?php echo $websiteName; ?>" value="<?php echo $websiteName; ?>">
  </div>
  <div class="form-group">
    <label for="settings[<?php echo $settings['website_url']['id']; ?>]">Website URL</label>
    <input type="text" class="form-control" name="settings[<?php echo $settings['website_url']['id']; ?>]" placeholder="<?php echo $websiteUrl; ?>" value="<?php echo $websiteUrl; ?>"">
  </div>
  <div class="form-group">
    <label for="settings[<?php echo $settings['email']['id']; ?>]">System Email</label>
    <input type="text" class="form-control" name="settings[<?php echo $settings['email']['id']; ?>]" placeholder="<?php echo $emailAddress; ?>" value="<?php echo $emailAddress; ?>">
  </div>
  <div class="form-group">
    <label for="settings[<?php echo $settings['resend_activation_threshold']['id']; ?>]">Activation Threshold</label>
    <input type="text" class="form-control" name="settings[<?php echo $settings['resend_activation_threshold']['id']; ?>]" placeholder="<?php echo $resend_activation_threshold; ?>" value="<?php echo $resend_activation_threshold; ?>">
  </div>
  <div class="form-group">
    <label for="settings[<?php echo $settings['language']['id']; ?>]">Language</label>
    <select name='settings[<?php echo $settings['language']['id']; ?>]'>
	<?php
	//Display language options
	foreach ($languages as $optLang){
		if ($optLang == $language){
			echo "<option value='".$optLang."' selected>$optLang</option>";
		}
		else {
			echo "<option value='".$optLang."'>$optLang</option>";
		}
	}
	?>
	</select>
  </div>
  <div class="form-group">
    <label for="settings[<?php echo $settings['activation']['id']; ?>]">Email Activation</label>
    <select name='settings[<?php echo $settings['activation']['id']; ?>]'>
	<?php
	//Display email activation options
	if ($emailActivation == "true"){
		echo "
		<option value='true' selected>True</option>
		<option value='false'>False</option>
		</select>";
	}
	else {
		echo "
		<option value='true'>True</option>
		<option value='false' selected>False</option>
		</select>";
	}
	?>
  </div>
  <div class="form-group">
    <label for="settings[<?php echo $settings['template']['id']; ?>]">Active Theme</label>
    <select name='settings[<?php echo $settings['template']['id']; ?>]'>
	<?php
	//Display template options
	foreach ($templates as $temp){
		if ($temp == $template){
			echo "<option value='".$temp."' selected>$temp</option>";
		}
		else {
			echo "<option value='".$temp."'>$temp</option>";
		}
	}
	?>
	</select>
  </div>
  <button type="submit" class="btn btn-default">Save</button>
</form>
