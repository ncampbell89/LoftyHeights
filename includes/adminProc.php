<?php
	$admin = $_GET['admin'];
	if($admin == '-1') {
		echo '<script language="javascript">';
		echo 'alert("Please choose an admin option.")';
		echo '</script>';
	} else if($admin == 'add') {
		include '../CMS/add-apt-bldg-hood.php';
	} else if($admin == 'apt') {
		require('../CMS/aptDetails.php');
	} else {
		require('../CMS/bldgDetails.php');
	}
?>