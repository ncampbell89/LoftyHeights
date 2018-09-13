<?php
    
    require_once('../conn/connApts.php');
    
    // 1.) "get" the vars from the querystring
    $bldgID = $_GET['bldgID'];
    $floor = $_GET['floor'];
    $rent = $_GET['rent'];
    $sqft = $_GET['sqft'];
    $isAvail = $_GET['isAvail'];
    $bdrms = $_GET['bdrms'];
    $baths = $_GET['baths'];
    $apt = $_GET['aptUnit']; 
    $aptTitle = $_GET['aptTitle'];
    $aptTitle = mysqli_real_escape_string($conn, $aptTitle);
    $aptDesc = $_GET['aptDesc'];
    $aptDesc = mysqli_real_escape_string($conn, $aptDesc);

    // 2.) query the apartments table: "C" for CRUD (Create new record)
    $query = "INSERT INTO apartments(bldgID, floor, rent, sqft, isAvail, bdrms, baths, apt, aptTitle, aptDesc) VALUES('$bldgID', '$floor', '$rent', '$sqft', '$isAvail', '$bdrms', '$baths', '$apt', '$aptTitle', '$aptDesc')";

    mysqli_query($conn, $query); // add new bldg to buildings tbl

    // see if it worked:
    if(mysqli_affected_rows($conn) == 1) {
        // get the primary key ID of the new bldg
        echo mysqli_insert_id($conn);
    } else {
        echo -1;
    }

?>

