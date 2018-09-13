<?php
    session_start(); // so we can detect $_SESSION variables

    // is user is logged-in, they have session vars, so look for one:
    if(isset($_SESSION['user'])) { // is this exists, they are IN
        
        // make regular vars out of the session vars
        // Assuming authentication, assign a mbr ID
        $IDmbr = $_SESSION['IDmbr'];
        $user = $_SESSION['user'];
        $firstName = $_SESSION['firstName'];
        $lastName = $_SESSION['lastName'];
		if(isset($_SESSION['isAdmin'])) {
			$isAdmin = $_SESSION['isAdmin'];
		}
        
        // welcome the logged-in user
        $welcome_msg = '<div style="float:right; width:250px; font-size:1rem; margin-top:9px">';
        $welcome_msg .= "<h4 style='margin-top:1.25rem'><em>Welcome, " . $_SESSION['firstName'];
        $welcome_msg .= '</em> &nbsp; | &nbsp; 
        <a href="' . $_SERVER['PHP_SELF'] . '?logout=yes">Log Out</a></h4></div>';

    } else {
        // intruder alert! Redirect to login page
		header("Location: http://localhost/LoftyHeights/memberJoin-Login.php");	     
    }

    if(isset($_GET['logout'])) { // if user clicked logout link
        session_destroy(); // end the session and redirect
		header("Location: http://localhost/LoftyHeights/memberJoin-Login.php");		
    }
?>