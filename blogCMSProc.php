<?php
    // handle the authentication
    include "includes/authenticate.php";
    include "conn/connApts.php";

    // pass the POST vars from blogCMS.php form to "regular" variables
    $mbrID = $_POST['IDmbr'];
    
    // the strings need to have all single- and double-quotes escaped:
    $blogTitle = $_POST['blogTitle'];
    $blogTitle = mysqli_real_escape_string($conn, $blogTitle);

    $blogBlurb = $_POST['blogBlurb'];
    $blogBlurb = mysqli_real_escape_string($conn, $blogBlurb);

    $blogEntry = $_POST['blogEntry'];
    $blogEntry = mysqli_real_escape_string($conn, $blogEntry);

    // "C" for CRUD: Create new record with INSERT INTO command
    $query = "INSERT INTO blogs(blogTitle, blogBlurb, blogEntry, blogMbrID) VALUES('$blogTitle', '$blogBlurb', '$blogEntry', '$mbrID')";

    mysqli_query($conn, $query);

	$title = 'Blog Processor'; 
    include 'includes/head.php'; 
    include 'includes/header.php';
 
?>

<!DOCTYPE html>
<html lang="en-us">
    
<head>   
    <title>Blog CMS Processor</title>
<!--    <link href="css/apts.css" rel="stylesheet">   -->
</head>
    <main>     
        <?php 
            if(mysqli_affected_rows($conn) == 1) {
                header("Location:blog.php");
            } else {
                echo '<h1>Sorry! Could Not Save Blog!</h1>
                    <h2><em>Redirecting...</em></h2>';
                header("Refresh:5; url=blogCMS.php", true, 303);
            }      
        ?> 
    </main>
	
	<aside style="float:right; margin:2%; padding:1%; background-color:#EEE; overflow-y:scroll; height:78vh; padding-right: 15px;"></aside>

	<?php include 'includes/footer.php'; ?>
</html>