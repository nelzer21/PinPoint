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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
  <div class="bg">
    <div id="wrapper">
      <div class="form_div">
          <p class="form_label"><h2>Login</h2></p>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">

            </div>
            </br>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>
