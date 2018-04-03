<?php
// Include config file
require_once 'config.php';

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
    body {
       margin:0 auto;
       height: 100vh;
       padding:0px;
       text-align:center;
       width:100%;
       font-family: "Myriad Pro","Helvetica Neue",Helvetica,Arial,Sans-Serif;
       color:white;
     }

     .bg {
         background-image: url("wallet.jpg");
         height: 100%;
         background-position: center;
         background-repeat: no-repeat;
         background-size: cover;
     }

    #wrapper {
       margin:0 auto;
       padding:0px;
       text-align:center;
       width:995px;
     }

    #wrapper h1 {
     margin-top:50px;
     font-size:45px;
     color:#424949;
    }

    #wrapper h1 p {
      font-size:18px;
    }

    .form_div {
      width:330px;
      margin-left:320px;
      padding:10px;
      background-color:#33A164;
      box-shadow: 2px 2px 1px #545454;
    }

    .form_div .form_label {
      margin:100px;
      margin-bottom:30px;
      font-size:25px;
      font-weight:bold;
      color:white;
      text-decoration:underline;
    }

    .form_div input[type="text"],input[type="password"] {
      width:300px;
      height:40px;
      border-radius:2px;
      font-size:17px;
      padding-left:5px;
      border:none;
    }

    .form_div input[type="submit"] {
      width:230px;
      height:40px;
      border:none;
      border-radius:5px;
      font-size:17px;
      background-color:#1d7042;
      color:white;
      font-weight:bold;
    }

    @media only screen and (min-width:700px) and (max-width:995px) {
        #wrapper{
          width:100%;
        }
        #wrapper h1{
          font-size:30px;
        }
    .form_div {
      width:50%;
      margin-left:25%;
      padding-left:0px;
      padding-right:0px;
    }

    .form_div input[type="text"],input[type="password"] {
      width:80%;
      }
    .form_div textarea {
      width:80%;
      }
    .form_div input[type="submit"] {
      width:80%;
      }
    }
    @media only screen and (min-width:400px) and (max-width:699px) {
      #wrapper {
        width:100%;
      }
      #wrapper h1 {
        font-size:30px;
      }

    .form_div {
      width:60%;
      margin-left:20%;
    }

    .form_div input[type="text"],input[type="password"] {
      width:80%;
    }

    .form_div input[type="submit"] {
      width:80%;
      }

    @media only screen and (min-width:100px) and (max-width:399px) {
      #wrapper {
        width:100%;
      }
      #wrapper h1 {
        font-size:25px;
      }

    .form_div {
      width:90%;
      margin-left:5%;
      padding-left:0px;
      padding-right:0px;
      }

    .form_div input[type="text"],input[type="password"] {
      width:80%;
      }

    .form_div input[type="submit"] {
      width:80%;
    }

    </style>
</head>
<body>
    <div class="wrapper">
      <div id="wrapper">
        <div class="form_div">
    <p class="form_label"><h2>Sign Up</h2></p>
    <form method="post" action="">
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>
