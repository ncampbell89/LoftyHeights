<?php 
    require_once('conn/connApts.php');

    ## This script processes the ajax call from setMainPic() function in profile.php

// these GET vars came in from the querystring of url
    $IDmbr = $_GET['IDmbr']; // the logged-in user
    $IDimg = $_GET['IDimg']; // the new main profile pic

// we need 2 queries: 1 to set current isMainPic = 0
// other to set IDimg as the new isMainPic = 1
    $query1 = "UPDATE images SET isMainPic=0 WHERE foreignID='$IDmbr' AND isMainPic=1 AND catID=3";
    mysqli_query($conn, $query1);

    $msg = "Server Says: <br/>";

    if(mysqli_affected_rows($conn) == 1) {
        // set new isMainPic = 1
        $query2 = "UPDATE images SET isMainPic=1 WHERE IDimg='$IDimg'";
        mysqli_query($conn, $query2);
        $msg .= "Old profile pic deactivated<br/>";
    } else {
        $msg .= "Current profile pic could not be changed<br/>";
    }

    if(mysqli_affected_rows($conn) == 1) {
        // it worked, echo msg back to ajax
        // this text comes back to ajax func as responseText
        $msg .= "New profile pic set!";
    } else {
        $msg .= "Sorry, new profile pic could not be set.";
    }

    echo $msg;

?>