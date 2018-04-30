<style>
<?php include 'main.css'; ?>
<?php include 'font-awesome.min.css'; ?>
<?php include 'font.css'; ?>
<?php include 'base.css'; ?>
</style>
<?php
// Include config file
//require_once 'config.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
	</head>
<body>
	</div>
	<div class="background"></div>
	<div class="backdrop"></div>
	<div class="login-form-container" id="login-form">
		<div class="login-form-content">
			<div class="login-form-header">

				<h3>Signup Today!</h3>
			</div>
			<form method="post" action="" class="login-form">
				<div class="input-container">
					<i class="fa fa-envelope"></i>
					<label for="username">Create username</label>
					<input type="username" id="username"  class="input" name="user" placeholder="Username"/>
				</div>
				<div class="input-container">
					<i class="fa fa-lock"></i>
					<label for="password">Create password</label>
					<input type="password"  id="password" class="input" name="password" placeholder="Password"/>
					<i id="show-password" class="fa fa-eye"></i>
				</div>
					<div class="input-container">
					<i class="fa fa-lock"></i>
					<label for="confimpassword">Confirm password</label>
					<input type="confimpassword"  id="confimpassword" class="input" name="password" placeholder="Confim Password"/>
					<i id="show-password" class="fa fa-eye"></i>
				</div>
					<div class="rememberme-container">
					<input type="checkbox" name="rememberme" id="rememberme"/>
					<label for="rememberme" class="rememberme"><span>Remember me</span></label>
					<a class="member" href="'http://pinpointwallet.com/wp-content/themes/App-website/header.php">Already a member?</a>
				</div>
        <input class="button" type="button" value="Submit" onclick="window.location.href='http://pinpointwallet.com/wp-content/themes/App-website/welcome.php'"/>
			</form>
		</div>
		<div class="attibution">
			&copy; 2018 pinpointwallet.com
		</div>
	</div>
</body>
</html>
