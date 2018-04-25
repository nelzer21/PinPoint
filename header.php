<style>
<?php include 'main.css'; ?>
<?php include 'font-awesome.min.css'; ?>
<?php include 'font.css'; ?>
<?php include 'base.css'; ?>
</style>

<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = " + $username;

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                       if(password_verify($username, $hashed_password)){
                      //  if("Brandy15!", "Brandy15!"){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;
                            // header('location:/wp-content/themes/App-website/test.html');
                            header('location:test.html');
                        } else{
                          //  header("location: welcome.php");
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="shortcut icon" href="img/logo.png"/>
	</head>
<body>
	</div>
	<div class="background"></div>
	<div class="backdrop"></div>
	<div class="login-form-container" id="login-form">
		<div class="login-form-content">
			<div class="login-form-header">

				<h3>Welcome to PinPoint</h3>
			</div>
<!-- 			<form method="post" action="" class="login-form">
  <fieldset>
    <legend>Login form</legend>
    <div>
      <label for="username">Your username</label>
	  <input type="text" id="username" aria-describedby="username-tip" required />
	  <div role="tooltip" id="username-tip">Your username is your email address</div>
	</div>
	<div>
	  <label for="password">Your password</label>
	  <input type="text" id="password" aria-describedby="password-tip" required />
	  <div role="tooltip" id="password-tip">Was emailed to you when you signed up</div>
	</div>
  </fieldset>
</form> -->
			<form method="post" action="" class="login-form">
				<div class="input-container">
					<i class="fa fa-envelope"></i>
					<input type="username" class="input" name="user" placeholder="Username"/>
				</div>
				<div class="input-container">
					<div class="input-container">

					<input type="password" class="input" name="password" placeholder="Password" alt = "enter password"/>
					<i id="show-password" class="fa fa-eye"></i>
				</div>
				<div class="rememberme-container">
					<input type="checkbox" name="rememberme" id="rememberme"/>
					<label for="rememberme" class="rememberme"><span>Remember me</span></label>
					<a class="forgot-password" href="#">Forgot Password?</a>
				</div>
        <input class="button" type="button" value="Login" onclick="window.location.href='http://pinpointwallet.com/wp-content/themes/App-website/welcome.php'" />
        <input class="button" type="button" value="Signup" onclick="window.location.href= 'http://pinpointwallet.com/wp-content/themes/App-website/register.php'"></a>
   		</form>
		</div>
		<div class="attibution">
			&copy; 2018 pinpointwallet.com
		</div>
	</div>
</body>
</html>
