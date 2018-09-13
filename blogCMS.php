<?php
    // handle the authentication
    include "includes/authenticate.php";

    require_once("conn/connApts.php");
    // query the members table for all mbrs
    $query = "SELECT IDmbr, firstName, lastName
    FROM members ORDER BY lastName ASC";
    
    // execute the query
    $result = mysqli_query($conn, $query);

    $title = 'Blog'; 
    include 'includes/head.php'; 
    include 'includes/header.php'; 

?>

<main>
    <h1 style="text-transform:uppercase">Your personal blog here</h1>
    <hr>
    <p>What do you think about Lofty heights? Share your thoughts in the blogs so we'll have more members in our website. The more the merrier!</p>
</main>

<aside>
    <form method="post" action="blogCMSProc.php" onsubmit="return checkAuthor()">
		<input type="hidden" name="IDmbr" id="IDmbr" value="<?php echo $IDmbr; ?>">

    <h2>
        <?php echo "Author: $firstName $lastName"; ?>
    </h2>

    <p>
        <input type="text" name="blogTitle" id="blogTitle" style="width:98%" placeholder="Title" required>
    </p>

    <p>
        <input type="text" name="blogBlurb" id="blogBlurb" style="width:98%" placeholder="Secondary Title" required>
    </p>

    <p>
        <textarea name="blogEntry" id="blogEntry" style="width:100%; font-size:1rem" rows="10" placeholder="Enter Blog Here" required></textarea>
    </p>

    <p>
        <button style="width:100%; padding:5px; background-color:#e4d9c7; font-weight:bold; font-size:1rem; letter-spacing:2px">SAVE</button>
    </p>

</form>
</aside>

    <script>
        
        function checkAuthor() {
            // make sure user chose an Author from select menu
            // get the value from the select menu (-1 if no author chosen)
            const IDmbr = document.getElementById('IDmbr').value;
            if(IDmbr == -1) { // first choice "Choose" value is -1
                alert('Please Choose An Author!');
                return false;
            }
        }
    
    </script>

<?php include 'includes/footer.php'; ?>