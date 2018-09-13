<?php 

    require_once("../conn/connApts.php"); 
    // handle the incoming form data from CMS-aptDetails.php
    $IDapt = $_POST['IDapt']; // the hidden form field value (primary key)
    // numbers
    $rent = $_POST['rent'];
    $sqft = $_POST['sqft'];
    $floor = $_POST['floor'];
    $isAvail = $_POST['isAvail']; // radio btn Available (1) Occupied (0)
    $bdrms = $_POST['bdrms'];
    $baths = $_POST['baths'];
    // text requires escaping quotes from strings
    $apt =  $_POST['apt'];
    $aptTitle =  $_POST['aptTitle'];
    $aptTitle = mysqli_real_escape_string($conn, $aptTitle); // escape ' "
    $aptDesc =  $_POST['aptDesc'];
    $aptDesc = mysqli_real_escape_string($conn, $aptDesc); // escape ' "

    // write the query; this is a "U" in CRUD (Update)
    $query = "UPDATE apartments SET apt='$apt', rent='$rent', 
    floor='$floor', bdrms='$bdrms', baths='$baths', aptTitle='$aptTitle', aptDesc='$aptDesc', isAvail='$isAvail', sqft='$sqft' WHERE IDapt='$IDapt'";

    // execute the query
    mysqli_query($conn, $query);

    header("Refresh:4; url=aptDetails.php?IDapt=$IDapt", true, 303);

?>

<!DOCTYPE html>
<html>
    
<head>
    <title>Apt Details Processor</title>
    <link href="css/apts.css" rel="stylesheet">
</head>
    
<body>
    
    <h1>Changes Saved!</h1>
    
</body>
</html>