<?php

    require_once("conn/connApts.php");

    // load the requested Blog Archive

    // GET the blog ID from the Querystring in blog2.php (URL Variable)
    $IDblog = $_GET['IDblog']; // the ID of the requested Blog

    // the ONLY blog we want is one user clicked in Blog Archive links
    $query = "SELECT * FROM blogs, members, images WHERE blogs.blogMbrID = members.IDmbr
    AND images.foreignID = members.IDmbr
    AND images.catID = 3
    AND IDblog = '$IDblog'";

    $result = mysqli_query($conn, $query);

    // set aside the first result for prominent display in main
    $row = mysqli_fetch_array($result);

mysqli_error($conn);
 
?>

<?php 
    $title = 'Blog Archive'; 
    include 'includes/head.php'; 
    include 'includes/header.php'; 
?>
        
<main>
            
	<h1>Latest Blog</h1>
	<h2><?php echo $row['blogTitle']; ?></h2>
	<h3><?php echo $row['blogBlurb']; ?></h3>

	<img src="members/<?= $row['user']; ?>/images/<?= $row['imgName']; ?>" style="float:left; margin:10px; width:100px; height:100px; border-radius:50%">

	<h4>Author: <?php echo $row['firstName'] . ' ' . $row['lastName']; ?></h4>
	<h4>Posted: <?php echo date('D. M. d, Y - H:m', strtotime($row['blogDateTime'])); ?></h4>
	<hr/>
	<p><?php echo $row['blogEntry']; ?></p>

</main>

<aside>
	<h2 style="padding:5px; font-size:1rem; background-color:#e4d9c7; box-shadow:1px 1px 1px #000; font-weight:bold; letter-spacing:1px; text-align:center">
        <a href="blog.php" style="text-decoration:none">Back to Main Blog</a>
    </h2>

</aside>

<?php include 'includes/footer.php'; ?>
    