<?php

require_once("../conn/connApts.php");
// prime key
$IDbldg = $_POST['IDbldg'];
// numbers
$floors = $_POST['floors'];
$yearBuilt = $_POST['yearBuilt'];
$phone = $_POST['phone'];
$doorman = $_POST['doorman'];
$pets = $_POST['pets'];
$parking = $_POST['parking'];
$gym = $_POST['gym'];
// text
$bldgName = $_POST['bldgName'];
$bldgName = mysqli_real_escape_string($conn, $bldgName);
$bldgDesc = $_POST['bldgDesc'];
$bldgDesc = mysqli_real_escape_string($conn, $bldgDesc);
$address = $_POST['address'];
$address = mysqli_real_escape_string($conn, $address);
$email = $_POST['email'];
$email = mysqli_real_escape_string($conn, $email);

// query to update 
$query = "UPDATE buildings SET floors='$floors', yearBuilt='$yearBuilt', phone='$phone',
isDoorman='$doorman', isPets='$pets', isParking='$parking', isGym='$gym', bldgName='$bldgName',
bldgDesc='$bldgDesc', address='$address', email='$email' WHERE IDbldg='$IDbldg'";
//var_dump($_POST);
//echo $query;exit();
mysqli_query($conn, $query);

$registered = mysqli_affected_rows($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Apt Details Update</title>
	<link href="css/apts.css" rel="stylesheet">
</head>
<body>
	<div id="container">
		<h3 align="center">
			<?php
				if($registered == 1){
					echo 'Building Listing Updated Successfully!';
				} else {
					echo "Couldn't Update Building Listing! $query.".mysqli_error($conn);
				}
			?>
			<br><a href="CMS/searchApts.php">Return to Apt Search CMS</a>
		</h3>
	</div>
</body>
</html>