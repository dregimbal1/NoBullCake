<?php
echo $error;
echo $success;
?>
<script>
	$(document).ready(function() {
		$('#login-page').bootstrapValidator();
	});	
</script>
<form data-bv-message="Required Field" name="login-page" id="login-page" role="form" action="<?php echo $websiteUrl; ?>/process.php?do=login" method="post">
<div class="form-group">
  <input data-bv-notempty="true" type="text" id="username" name="username" placeholder="Username" class="form-control">
</div>
<div class="form-group">
  <input data-bv-notempty="true" type="password" name="password" placeholder="Password" class="form-control">
</div>
<button type="submit" class="btn btn-success">Sign in</button>
<a href="<?php echo $websiteUrl; ?>/register" class="btn btn-primary">
   Register
</a>
</form>

