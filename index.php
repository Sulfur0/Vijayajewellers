<?php session_start(); 
if(isset($_SESSION["usuario"])&&!$_SESSION["usuario"]==null){
    header("Location: admin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/login-style.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>

<!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
    <div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <!--
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            -->
            <?php
			if(isset($_REQUEST["fail"])){
				echo '<div class="alert alert-danger alert-dismissable fade in">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
				if(isset($_REQUEST["auth"])){
					echo '<strong>Error!</strong> Username or password incorrect.';
				}else if(isset($_REQUEST["not-authorized"])){
					echo '<strong>Error!</strong> You must login before entering this page.';
				}
				echo '</div>';
			}
			?>
            <form class="form-signin" action="backend/validate.php" method="POST">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="remember" name="remember" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
            </form><!-- /form -->
            <a href="#" class="forgot-password">
                Forgot the password?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->

    <script src="js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>
</body>
</html>