<?php

    require_once('../conn/connApts.php');
    
    // echo "Hello from the Add a Bldg PHP Processor!";

    // 1.) "get" the vars from the querystring
    $bldgName = $_GET['bldgName'];
    $bldgName = mysqli_real_escape_string($conn, $bldgName);
    $floors = $_GET['floors'];
    $yearBuilt = $_GET['yearBuilt'];
    $address = $_GET['address'];
    $address = mysqli_real_escape_string($conn, $address);
    $phone = $_GET['phone'];
    $phone = mysqli_real_escape_string($conn, $phone);
    $email = $_GET['email'];

    // "get" the checkboxes w values of either 1 or 0
    $doorman = $_GET['doorman'];
    $pets = $_GET['pets'];
    $gym = $_GET['gym'];
    $parking = $_GET['parking'];
    $laundry = $_GET['laundry'];
    $elevator = $_GET['elevator'];

    // "get" the value of the hood menu (the select)
    $hoodID = $_GET['hoodID'];
    // "get" the value of the bldg desc (the textarea)
    $bldgDesc = $_GET['bldgDesc'];
    $bldgDesc = mysqli_real_escape_string($conn, $bldgDesc);

    // 2.) query the buildings table: "C" for CRUD (Create new record)
    $query = "INSERT INTO buildings(bldgName, floors, yearBuilt, address, phone, email, isDoorman, isPets, isGym, isParking, isElevator, isLaundry, hoodID, bldgDesc) VALUES('$bldgName', '$floors', '$yearBuilt', '$address', '$phone', '$email', '$doorman', '$pets', '$gym', '$parking', '$elevator', '$laundry', '$hoodID', '$bldgDesc')";

    mysqli_query($conn, $query); // add new bldg to buildings tbl

    // see if it worked:
    if(mysqli_affected_rows($conn) == 1) {
        // get the primary key ID of the new bldg
        echo mysqli_insert_id($conn);
    } else {
        echo -1;
    }

?>

