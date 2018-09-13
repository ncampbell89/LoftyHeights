<?php
    require_once('../conn/connApts.php');
    
    // incoming form vars
    $bldgName = $_GET['bldgName'];
    $bldgName = mysqli_real_escape_string($conn, $bldgName);

    $floors = $_GET['floors'];

    $yearBuilt = $_GET['yearBuilt'];

    $address = $_GET['address'];
    $address = mysqli_real_escape_string($conn, $address);

    $email = $_GET['email'];

    $phone = $_GET['phone'];

    // write query to insert a new record into buildings table
    $query = "INSERT INTO buildings(bldgName, floors, yearBuilt, address, email, phone) VALUES('$bldgName', '$floors', '$yearBuilt', '$address', '$email', '$phone')";

    mysqli_query($conn, $query);

    // send message back to ajax function
    if(mysqli_affected_rows($conn) == 1) {
        echo "New Building Saved! Congrats!";
    } else {
        echo "Oops! Could Not Save New Building!";
    }
?>

