 <!--  <?php

 require_once "authController.php";
  
    if(isset($_SESSION['voter'])){
      header('location: home.php');
    }



?>
<?php // include 'includes/header.php'; ?>
<body class="hold-transition login-page">
<div class="login-box">
  	<div class="login-logo">
  		<b>Voting System</b>
  	</div>
  
  	<div class="login-box-body">
    	<p class="login-box-msg">Sign in to start your session</p>

    	<form action="login.php" method="POST">
      		<div class="form-group has-feedback">
        		<input type="text" class="form-control" name="voter" placeholder="Voter's ID" required>
        		<span class="glyphicon glyphicon-user form-control-feedback"></span>
      		</div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" class="btn btn-primary btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
        		</div>
      		</div>
    	</form>
  	</div>
  	<?php
  		// if(isset($_SESSION['error'])){
  		// 	echo "
  		// 		<div class='callout callout-danger text-center mt20'>
		// 	  		<p>".$_SESSION['error']."</p> 
		// 	  	</div>
  		// 	";
  		// 	unset($_SESSION['error']);
  		// }
  	?>
</div>
	
<?php  // include 'includes/scripts.php' ?>
</body>
</html> --> -->






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Voter login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="register/styles.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form action="loginvoter.php" method="POST" autocomplete="">
                    <h3 class="text-center">login Here</h3>
                    <div class="alert alert-primary" role="alert">
                        Info: Your Account needs to be verified by the adminstration before login.
                    </div>


                    <?php
                    if(count($errors) > 0){
                        ?>
                    <div class="alert alert-danger text-center">
                        <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="text" name="voterid" placeholder="Voter Id" required
                            value="<?php //echo $voter_id ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="link forget-pass text-left"><a href="forgot-password.php">Forgot password?</a></div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="login" value="Login">
                    </div>
                    <div class="link login-link text-center ">Not yet a member? <a href="register.php">register
                            now</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>