<?php 
    // handle the authentication
    include "includes/authenticate.php";

    require_once('conn/connApts.php');
    
    // query images table to see if this user has an image where isMainPic=1
    $query_mainPic = "SELECT * FROM images WHERE foreignID='$IDmbr' AND isMainPic=1 AND catID=3";

    $result_mainPic = mysqli_query($conn, $query_mainPic);

    if(mysqli_num_rows($result_mainPic) > 0) {
        $row_mainPic = mysqli_fetch_array($result_mainPic);
        $imgName = $row_mainPic['imgName'];
        $userPic = "members/$user/images/$imgName";
    } else { // there is no user main pic in the images table
        // so use the generic coming soon image for the time being
        $userPic = "images/pic-coming-soon.jpg";
    }

    // a second query for all pics to display as thumbs
    $query_all = "SELECT * FROM images WHERE foreignID='$IDmbr' AND catID=3";

    $result_all = mysqli_query($conn, $query_all);

    // load profile pic as uploaded by user. IF user has NOT uploaded a profile pic (WHERE isMainPic=1) default to Coming Soon pic
    $title = 'My Profile'; 
    include 'includes/head.php'; 
    include 'includes/header.php'; 
?>

<main>
    
    <h1><?php echo $user; ?>'s Profile</h1>
    
    <div id="thumbs" style="background-color:#e4d9c7; overflow-x:scroll; max-height:100px; white-space:nowrap; box-shadow:inset 2px 2px 2px #777">
       <!-- all user-uploaded pics here as thumbs -->
       <?php
         while($row_all=mysqli_fetch_array($result_all)) {
            // make image after image
            $img = $row_all['imgName'];
            $IDimg = $row_all['IDimg'];
            echo "<img src='members/$user/images/$img' height='90px' style='margin:5px; cursor:pointer' onclick='swapImg()' id='$IDimg'>";
         }
       ?>
    </div>

    <!-- big main profile pic -->
    <img src="<?php echo $userPic; ?>" width="350px" height="auto" id="big-pic" style="margin-top:15px">
    <h4 id="server-resp" style="display:none">&nbsp;</h4>
    <br>
    <button id="update-btn" onclick="setMainPic()" style="font-size:1rem; padding:5px; background-color:#eee; display:none">Make this my profile pic</button>
    
</main>

<aside>
    <h1>Upload Image:</h1>
    
    <form method="post" action="upload-proc.php" enctype="multipart/form-data" style="font-size:1.3rem">
        <p><input style="padding:0px" type="file" name="myPic" id="myPic"></p>
        <p><input type="checkbox" name="isMainPic" id="isMainPic">
            <label for="isMainPic">My Main Profile Pic</label>
        </p>
        <p><input style="background-color:#e4d9c7; padding:5px; width:51%; text-align:center; box-shadow: 1px 1px 1px #000" type="submit" name="submit-pic" id="submit-pic" value="Upload"></p>
        
    </form>
      
</aside>

<script>
    
    // runs on click of any thumb pic
    const bigPic = document.getElementById('big-pic');
    const updateBtn = document.getElementById('update-btn');
    var IDimg = 0; // for storing ID of preview pic(the most recently clicked thumb, now temporarily acting as a main big pic)
    var serverResp = document.getElementById('server-resp');
    
    function swapImg() {
        // take src of thumb and "copy it" to bigPic
        bigPic.src = event.target.src;
        IDimg = event.target.id; // ID of new temp big pic
        updateBtn.style.display = "inline-block";
    }
    
    function setMainPic() {
//        alert('Hello');
        let IDmbr = <?php echo $IDmbr; ?>;
        // get the id of the current big pic
        let xhr = new XMLHttpRequest();
        
        xhr.onload = function() {
            serverResp.style.display = "block";
            serverResp.innerHTML = xhr.responseText;
            setTimeout(function() { serverResp.style.display = "none"; }, 5000)
            updateBtn.style.display = "none";
        }
        
        let url = "updateMainPicProc.php?IDimg=" + IDimg + "&IDmbr=" + IDmbr;
        xhr.open("GET", url, true);
        xhr.send(); // in post vars go in the send method
    } // end function
    
</script>

<?php include 'includes/footer.php'; ?>

