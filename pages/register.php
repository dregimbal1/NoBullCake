<?php
echo $error;
?>
<form name="newUser" action="process.php?do=register" method="post" role="form">
  <hr>
  <h2>Account Information</h2>
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="password">Confirm Password</label>
    <input type="password" class="form-control" id="password" name="passwordc" placeholder="Confirm Password">
  </div>
  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
  </div>
<!--
  <hr>
  <h2>Connect Consoles</h2>
  <div class="form-group">
    <label for="gamertag">GamerTag</label>
    <input type="text" class="form-control" id="gamertag" name="gamertag" placeholder="GamerTag">
	<span class="help-block">Xbox One and Xbox 360</span>
  </div>
  <div class="form-group">
    <label for="psn">PSN</label>
    <input type="text" class="form-control" id="psn" name="psn" placeholder="PSN">
	<span class="help-block">Playstation Network ID (Online ID)</span>
  </div>
-->
  <hr>
  <h2>Verify Brain Cells</h2>
  <div class="form-group">
	<img src='models/captcha.php'>
    <input type="captcha" class="form-control" id="captcha" name="captcha" placeholder="Security Code">
	<span class="help-block">Enter the security code printed above</span>
  </div>
  <button type="submit" class="btn btn-default">Register</button>
</form>

