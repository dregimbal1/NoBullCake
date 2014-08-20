<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title><?php echo $websiteName; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $websiteUrl; ?>/styles/default/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Validator -->
	<link rel="stylesheet" href="<?php echo $websiteUrl; ?>/styles/default/css/bootstrapValidator.css"/>

    <!-- Custom styles for this template -->
    <link href="<?php echo $websiteUrl; ?>/styles/default/css/jumbotron.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?php echo $websiteUrl; ?>/styles/default/js/bootstrap.min.js"></script>
	<script src="<?php echo $websiteUrl; ?>/styles/default/js/bootstrapValidator.js"></script>
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $websiteUrl; ?>">userCake</a>
        </div>
		<!--
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <?php //include('models/navbar.php'); ?>
          </ul>
        </div><!--/.nav-collapse -->
        <div class="navbar-collapse collapse">
		<?php if(!isUserLoggedIn()){ ?>
          <form name="login" id="login" class="navbar-form navbar-right" role="form" action="<?php echo $websiteUrl; ?>/process.php?do=login" method="post">
            <div class="form-group">
              <input type="text" id="username" name="username" placeholder="Username" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
			<a href="<?php echo $websiteUrl; ?>/register" class="btn btn-primary">
			   Register
			</a>
          </form>
		<?php }else{ ?>
		  <form name="logout" class="navbar-form navbar-right" role="form" action="<?php echo $websiteUrl; ?>/logout" method="post">
			 <button type="submit" class="btn btn-danger">Logout</button>
		  </form>
		<?php } ?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
	<!-- Keep to homepage -->
    <div class="jumbotron">
      <div class="container">
        <h1>Welcome to userCake!</h1>
        <p>Totally Free. Totally Open Source. And Totally Awesome.</p>
      </div>
    </div>

    <div class="container">