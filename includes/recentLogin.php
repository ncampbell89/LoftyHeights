<?php 
    require_once('conn/connApts.php');

    $queryCookie = "SELECT * FROM members, images WHERE members.IDmbr=images.foreignID";
    $resultCookie = mysqli_query($conn, $queryCookie);

    $row = mysqli_fetch_array($resultCookie);

    $cookie_name = $row['user'];
    $cookie_value = $row['firstName'];
    $cookie_image = $row['imgName'];
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
?>