<?php

    require_once('../conn/connApts.php');
    
    // echo "Hello from the Add a Bldg PHP Processor!";

    // 1.) "get" the vars from the querystring
    $hoodName = $_GET['hoodName'];
    $hoodName = mysqli_real_escape_string($conn, $hoodName);
    $borough = $_GET['borough'];
    $subway = $_GET['subway'];
    $hoodDesc = $_GET['hoodDesc'];
    $hoodDesc = mysqli_real_escape_string($conn, $hoodDesc);

    // 2.) query the hoods table: "C" for CRUD (Create new record)
    $query = "INSERT INTO neighborhoods(hoodName, borough, subway, hoodDesc) VALUES('$hoodName', '$borough', '$subway', '$hoodDesc')";

    mysqli_query($conn, $query); // add new bldg to buildings tbl

    // see if it worked:
    if(mysqli_affected_rows($conn) == 1) {
        // get the primary key ID of the new bldg
        echo mysqli_insert_id($conn);
    } else {
        echo -1;
    }

?>

