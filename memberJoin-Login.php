<?php 
    include "includes/CMS.php";

    $title = 'Join/Login'; 
    include 'includes/head.php'; 
    include 'includes/header.php';
    include 'includes/recentLogin.php';

    // set only if user clicked I Forgot My Pswd link
    $forgot_msg = "";
    if(isset($_GET['forgot'])) {
          $forgot_msg = '<p style="position:relative; top:9px; left:9px">Please Enter the Email Associated with this Account:</p>';
          $forgot_msg .= '<form method="post" action="forgot-pswd-proc.php">';
          $forgot_msg .= '<input style="margin-left:9px; margin-bottom: 9px;" type="email" name="email" id="email" placeholder="Email" required>';
          $forgot_msg .= '<input type="submit" style="width:100px" name="submit" id="submit"></form>';
    }
?>

<style>
    #recent:hover{
        cursor: pointer;
    }
</style>

<main>
    <?php
        if(!isset($_COOKIE[$cookie_name])) {
//             echo "Cookie named '" . $cookie_name . "' is not set!";
            echo "
                <h1 style='text-transform:uppercase'>Create An Account</h1>
                <hr style='margin-bottom:33px'>
                
                <h2 style='float:left; width:50%; margin-top:0'>Sellers! Share NYC your place to sell</h2>
                <h2 style='float:left; text-align:right; width:50%; margin-top:0'>Seekers! Find your next luxury place</h2>
                
                <div style='font-size:1.5rem; width:60%; margin: 7rem auto;'>
                    Lofty Heights is also great for:
                    <ul>
                        <li>Seeking a comfortable neighborhood</li>
                        <br>
                        <li>Transportation convenience</li>
                        <br>
                        <li>Networking</li>
                    </ul>
                </div>
            ";
        } else {
//             echo "Cookie '" . $cookie_name . "' is set!<br>";
//             echo "Value is: " . $_COOKIE[$cookie_name];
            echo
                "
                <h1>Recent Logins</h1>
                <hr style='margin-bottom:33px'>

                <a id='cookie' onclick='showLogin()'>
                    <div id='recent' style='margin:0; width:200px; height:227px; box-shadow: 2px 2px 2px #000'>
                        <img src='members/$cookie_name/images/$cookie_image' width='200' height='auto'>

                        <div id='caption' style='background-color: #e4d9c7; width:192px; text-align:center; position:relative; bottom:5px; padding:4px'>$cookie_value</div> 
                    </div>
                </a>";
        }
    ?>
    
</main>

<aside>
      
    <h2 id="join-now">Join Now -- It's FREE!</h2>
      
    <h3 id="already-mbr">Already a member? Please 
        <button onclick="showLogin()" style="font-size:1.1rem; background-color:#DDD; font-weight:bold">Log in</button>
    </h3>
      
    <!-- help the user recover their password -->
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?forgot=true">
        I Forgot my Username and/or Password</a><br/><br/>
    
    <!-- this div is only visible if user clicks Forgot Pswd -->
    <div style="background-color:#FEE">
        <?php echo $forgot_msg; ?>
    </div>
      
    <div id="login-div" style="padding:10px; background-color:#e4d9c799; border: 1px solid #000; display:none">       
        <button onclick="hideLogin()" style="font-size:1.1rem; background-color:#FFF; font-weight:bold; float:right">X </button>
        
        <form method="post" action="loginProc2.php">           
            <h3>Please Log in:</h3>
            
            <p><input type="text" name="user" id="user" placeholder="User Name" required></p>

            <p><input type="password" name="pswd" placeholder="Password" required></p>
            
            <p><button style="width:200px; padding:5px; font-size:1rem; font-weight:bold">Log In</button></p>           
        </form>     
    </div>
    
    <div id="join-div" style="padding:10px; background-color:#e4d9c799; border: 1px solid #000">
        
        <form method="post" action="memberJoin-Proc.php" onsubmit="return validatePasswords()">

            <p><input type="text" name="firstName" id="firstName" required placeholder="First Name"></p>

            <p><input type="text" name="lastName" id="lastName" required placeholder="Last Name"></p>

            <p><input type="email" name="email" id="email" required placeholder="Email"></p>

            <p><input type="text" name="user" id="user" required placeholder="User Name"></p>

            <p><input type="password" name="pswd" id="pswd" required placeholder="Password"></p>

            <p><input type="password" name="pswd2" id="pswd2" required placeholder="Re-type Password"></p>

            <p><button style="width:200px; padding:5px; font-size:1rem; font-weight:bold">Submit</button></p>

        </form>
      
      </div><!-- close login-div -->
      
</aside>

<?php include 'includes/footer.php'; ?>

<script>
    
    function validatePasswords() {
        //check to see if the passwords match
        var pswd = document.getElementById("pswd").value;
        var pswd2 = document.getElementById("pswd2").value;
        if(pswd != pswd2) {
            alert("Passwords do not match!");
            return false;
        } // end if
    } // end function
    
    const loginDiv = document.getElementById('login-div');
    const joinDiv = document.getElementById('join-div');
    
    // click the Log In button or pic to show the login div
    function showLogin() {
        loginDiv.style.display = "block";
        joinDiv.style.display = "none";
    }
     
    // click the X button in login div to hide login div
    function hideLogin() { 
        loginDiv.style.display = "none";
        joinDiv.style.display = "block";
    }
    
    let cookie = document.getElementById('cookie');
    cookie.addEventListener('click', myCookies);
    function myCookies() {
        document.getElementById('user').value = "<?= $cookie_name; ?>";
    }
    
</script>

   <?php
    
      // Are we landing on this page fresh, or due to a redirect to try again after a failed login attempt?

      // set only if redirected after failed login attempt
      if(isset($_GET['tryagain'])) { 
        // show the login form
        echo '<script>showLogin();</script>';
      }

    ?>