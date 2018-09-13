<?php
    session_start();

	if(isset($_SESSION['user'])) {
		$IDmbr = $_SESSION['IDmbr'];
		
		if($IDmbr > 0) {
			echo '<script language="javascript">';
			echo 'const blog = document.getElementById("blog")';
			echo 'const blogCMS = document.getElementById("blogCMS")';

			echo 'blog.style.display = "none"';
			echo 'blogCMS.style.display = "block"';
			echo '</script>';
		}
		
		// welcome the logged-in user
        $welcome_msg = '<div style="float:right; width:250px; font-size:1rem; margin-top:9px">';
        $welcome_msg .= "<h4 style='margin-top:1.25rem'><em>Welcome, " . $_SESSION['firstName'];
        $welcome_msg .= '</em> &nbsp; | &nbsp; 
        <a href="' . $_SERVER['PHP_SELF'] . '?logout=yes">Log Out</a></h4></div>';
	}

	if(isset($_GET['logout'])) { // if user clicked logout link
        session_destroy(); // end the session and redirect
		header("Location: ../memberJoin-Login.php");
    }
?>