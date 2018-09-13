<?php
    require_once('conn/connApts.php');
    // get email entered by user in the Forgot form
    $email = $_POST['email'];
    // look for that email in the members table
    $query = "SELECT * FROM members WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        $msg = "<h3>Please check your email for your username and instructions on how to reset your password.</h3>";
        
        // send the email to the user
        $row = mysqli_fetch_array($result);
        $user = $row['user'];
        
        $subject = 'Reset Your Loftyheights for User: ' . $user;
        
        $email_msg = "Password Reset Instructions for User: " . $user;
        $email_msg .= "\n Click the link below to reset your password:";
        $email_msg .= "\n http://localhost/PHP-MySQL-03-July-2018/Lesson12/memberJoin-login.php";
                
        mail($email, $subject, $email_msg); // send the email
        
    } else { // looking up that email in the DB failed.
        $msg = "Email Not Found in Database!";
        $msg .= "<br/>Please Join As a New Member!";
        $msg .= "<br/>Redirecting...";
        header("Refresh:5; url=memberJoin-Login.php", true, 303);
    }   
?>
<!DOCTYPE html>
<html lang="us-en">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/apts.css">
</head>

<body>
    
    <div id="container">
    
        <?php echo $msg; ?>
        
    </div>
    
</body>
</html>
