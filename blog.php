<?php

    include "conn/connApts.php";

    // load the 11 most recent blogs: 1 for main and 10 for archive
    // load the newest blog first (catID = 3 = members)
    $query = "SELECT * FROM blogs, members, images WHERE blogs.blogMbrID = members.IDmbr
    AND images.foreignID = members.IDmbr
    AND images.catID = 3
	AND images.isMainPic = 1
    ORDER BY blogDateTime DESC LIMIT 11";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);  

    $title = 'Blog'; 
    include 'includes/head.php'; 
    include 'includes/header.php'; 

?>

<main>
	<h1>Latest Blog</h1>
	<h2>Title: <?php echo $row['blogTitle']; ?></h2>
	<h3>Subtitle: <?php echo $row['blogBlurb']; ?></h3>
	<br>
	<img src="members/<?php echo $row['user']; ?>/images/<?php echo $row['imgName']; ?>" style="float:left; margin:10px; width:100px; height:100px; border-radius:50%">

	<h4><?php echo "Author: $firstName $lastName"; ?></h4>
	<h4>
		Posted: <?= date('D. M. d, Y - g:i A', strtotime($row['blogDateTime'])); ?>
	</h4>
	<!--D - Day of the week, M - Month, d - day of the month, Y - Year, H - Hour, m - minute, A - AM or PM, a - am or pm -->
	<hr/>
	<p style="padding-left: 7.5em;"><?php echo $row['blogEntry']; ?></p>

</main>

<aside>
    <h2>Blog Archives</h2>

    <?php while($row = mysqli_fetch_array($result)) { ?>

        <img src="members/<?php echo $row['user']; ?>/images/<?php echo $row['imgName']; ?>" style="float:left; margin:10px; width:50px; height:50px; border-radius:50%">

        <a style="text-decoration:none; color:#3b87c1" href="blogArchive.php?IDblog=<?php echo $row['IDblog']; ?>">
            <h4>Title: <?php echo $row['blogTitle']; ?></h4> <!--$row['databaseName']-->
        </a>

    <p><?php echo "Author: $firstName $lastName"; ?></p>

    <p>
        Posted: <?= date('D. M. d, Y - g:i A', strtotime($row['blogDateTime'])); ?>
    </p>

        <hr>
    <?php } ?>
</aside>

<?php include 'includes/footer.php'; ?>