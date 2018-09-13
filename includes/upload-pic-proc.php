<?php
    include 'includes/authenticate.php';

    require_once("conn/connApts.php");

    $OKtoUpload = 1; // set to 0 if file is not okay to upload
    $folderPath = "members/$user/images/";
    $imgName = basename($_FILES['myPic']['name']);
    $fullPath = $folderPath . $imgName;
    
    // echo "File size: " . $_FILES['myPic']['size'];
    // ##** UPLOAD PIC PROCESSOR ##**
    // **## receives multipart form data from profile.php
    // DOES 3 THINGS: 
    // 0.) Analyzes file to ensure it is a new image and not too big
    // 1.) INSERT pic file name to images table of database
    // 2.) Uploads actual pic to user's own images folder
    
    // is the checkbox checked? If so, this is user's main profile pic
    if(isset($_POST['isMainPic'])) {
        $isMainPic = 1;
    } else { // not user's main pic -- just some pic
        $isMainPic = 0;
    }

    // if user clicked Upload w/o choosing file
    if(empty($_FILES['myPic']['name'])) {
         $msg = " No file chosen! Try Again ";
         $OKtoUpload = 0; // mark file as bad
    }

    if($OKtoUpload == 1) {
        $fileType = pathinfo($imgName, PATHINFO_EXTENSION);
        // if file is of any of these img types, it is a legit image
        if($fileType != "jpg" && $fileType != "png" 
            && $fileType != "jpeg" && $fileType != "gif" 
            && $fileType != "svg" && $fileType != "JPEG" 
            && $fileType != "JPG") {
            $msg = 'File uploaded is not a supported image type.';
            $OKtoUpload = 0;            
        }
    }

    if($OKtoUpload == 1) { // if so far, so good
        // check db to see if image already exists for user
        $query = "SELECT * FROM images WHERE imgName='$imgName' 
                  AND foreignID='$IDmbr' AND catID=3";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) { // if the image file name is not found in the images table, save it there
            $msg = 'Image already exists in the database.';
            $OKtoUpload = 0;
        }
    }

    // if img already exists in the user's images folder
    if($OKtoUpload == 1 && file_exists($fullPath)) { 
         $msg = " File already exists! Upload cancelled! ";
         $OKtoUpload = 0;
    }

   if($OKtoUpload == 1 && $_FILES['myPic']['size'] > 6000000) {
        // image exceeds max file size of 6 MB
        $msg = " Image exceeds 6 MB max! Upload cancelled! ";
        $OKtoUpload = 0;
    }

    if($OKtoUpload == 1) {
       if($isMainPic == 1) { // if this is user's main pic, set old isMainPic = 0
            $queryUpdate = "UPDATE images SET isMainPic=0 WHERE isMainPic=1 AND foreignID='$IDmbr' AND catID=3";
            mysqli_query($conn, $queryUpdate);
        }
        // insert record for the new pic
        $queryInsert = "INSERT INTO images(imgName, foreignID, catID, isMainPic) VALUES('$imgName', '$IDmbr', 3, '$isMainPic')";
        mysqli_query($conn, $queryInsert);
        
        if(mysqli_affected_rows($conn) != 1) { // if nothing inserted
            $msg = 'Could not save image name to the database.';
             $OKtoUpload = 0;                        
        }
    }
   
    // try to upload the file
    if($OKtoUpload == 1 && 
       move_uploaded_file($_FILES['myPic']['tmp_name'], $fullPath) == false) {
        $msg = " Image file could not be uploaded to the user's images folder ";
        $OKtoUpload = 0;
    } 

    if($OKtoUpload == 1) { // if file is still ok, it got uploaded
        $msg = "Image uploaded successfully!<br/>";

        $msg .= "File Size: " . $_FILES['myPic']['size'] . " bytes";
    }

    $msg .= "<br/>Redirecting...";

    // whatever the result, redirect in 5 sec back to profile.php
    header("Refresh:7; url=profile.php", true, 303);

?>




