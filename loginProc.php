<?php

    session_start();

    // check if username & password combo entered into login form has ONE match in the members table of the database.
    require_once("conn/connApts.php");

    // grab the form vars
    $user = $_POST['user']; // Joey1
    $pswd = $_POST['pswd']; // abc123 is NOT hashed

    // step 1: query the database for just the user
    $query = "SELECT * FROM members WHERE user='$user'";
    
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    // step 2: see if the user's loaded pswd matches the pswd entered into the form
    if(password_verify($pswd, $row['pswd'])) {
        // user is verified!
        
        // ##**## MAKE SESSION VARIABLES ##**## 
        $_SESSION['user'] = $row['user'];
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];
        $_SESSION['IDmbr'] = $row['IDmbr'];
        
        $msg = 'Welcome ' . $_SESSION['firstName'];
        // provide logout link only when logged in
        $msg .= '<br/><a href="' . $_SERVER['PHP_SELF'] . '?logout=yes">Log Out</a>';
        
    } else {
        // intruder alert ! -- redirect to login page to try again
        $msg = "Login Failed! Intruder Alert! Redirecting Try Again...";
        header("Refresh:5; url='memberJoin-Login.php?tryagain=yes'", true, 303);
    }

    // run this is and only if logout exists as url var
    // $_GET['logout'] exists ONLY if Log Out link was clicked
    if(isset($_GET['logout'])) {
        session_destroy(); // delete all $_SESSION vars
        $msg = 'You are logged out';
    }

?>

<!DOCTYPE html>
<html lang="en-us">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Processor</title>
    <link rel="stylesheet" href="css/apts.css">
</head>

<body>
   
    <div id="container">
    
        <?php echo "<h1>$msg</h1>" ?>
        
    </div>
    
    <script src=""></script>
    
</body>
</html>
