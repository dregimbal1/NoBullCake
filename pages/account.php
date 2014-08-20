<h3>Welcome, <?php echo strtoupper($loggedInUser->username); ?>!</h3>
<hr>
This is an example secure page designed to demonstrate some of the basic features of UserCake. You registered this account on <?php echo date("M d, Y", $loggedInUser->signupTimeStamp()); ?>.
