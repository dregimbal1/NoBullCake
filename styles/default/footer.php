      <hr>

      <footer>
        <p>&copy; Company 2014
		<?php
		if(isUserLoggedIn()){
			if ($loggedInUser->checkPermission(array(2))){
			?>	<br />
				  <div class="btn-group">
					  <a href="<?php echo $websiteUrl; ?>/manager/configuration" class="btn btn-default">Settings</a>
					  <a href="<?php echo $websiteUrl; ?>/manager/users" class="btn btn-default">Users</a>
					  <a href="<?php echo $websiteUrl; ?>/manager/pages" class="btn btn-default">Pages</a>
					  <a href="<?php echo $websiteUrl; ?>/manager/permissions" class="btn btn-default">Permissions</a>
				  </div>
			<?php
			}
		}
		?>
		</p>
      </footer>
    </div> <!-- /container -->
  </body>
</html>