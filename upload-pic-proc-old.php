<?php

    require_once("conn/connApts.php");

    // Assuming authentication, assign a mbr ID
    $IDmbr = 39; // $_SESSION['IDmbr'];
    $user = 'Paul1'; // $_SESSION['user'];

    $OKtoUpload = 1; // set to 0 if file is not okay to upload
    $folderPath = "members/$user/images/";
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

    // get the incoming file (the one the user browsed to)
    // if the user didn't just click Upload w/o first browsing to a file
    if($_FILES['myPic']['name'] != "") {
        $imgName = basename($_FILES['myPic']['name']);
        $fullPath = $folderPath . $imgName;
        // check images table to see if this file already exists
        $query = "SELECT * FROM images WHERE imgName='$imgName' 
                  AND foreignID='$IDmbr' AND catID=3";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) == 0) { // if the image file name is not found in the images table, save it there
            
          // TEST : First make sure the file is actually an image: 
            $fileType = pathinfo($imgName, PATHINFO_EXTENSION);
            // if file is of any of these img types, it is a legit image
            if($fileType == "jpg" || $fileType == "png" 
                || $fileType == "jpeg" || $fileType == "gif" 
                || $fileType == "svg" || $fileType == "JPEG" 
                || $fileType == "JPG") {
            
                // There can only be ONE Main Pic for any given user. If user checked Main Pic, the image to upload needs to be set to isMainPic = 1. But first, before inserting the new record, set any existing Main Pic to isMainPic = 0: 
                if($isMainPic == 1) { // if this is user's main pic
                    $queryU = "UPDATE images SET isMainPic=0 WHERE isMainPic=1 AND foreignID='$IDmbr' AND catID=3";
                    mysqli_query($conn, $queryU);
                }

                // insert record for the pic
                $query2 = "INSERT INTO images(imgName, foreignID, catID, isMainPic) VALUES('$imgName', '$IDmbr', 3, '$isMainPic')";
                mysqli_query($conn, $query2);
                echo 'Congrats! File ' . $imgName . ' uploaded successfully!  Redirecting...';
                //$itWorked = 1;
                // if the image got saved to DB, we next need to upload the image itself to the user's images folder
                
            } else {
                echo " File is NOT an image! File NOT saved to Database! File NOT Uploaded!";
            }// if it is a supported image type, update and insert
            
            // UPLOAD THE ACTUAL IMAGE FILE TO THE USER/IMAGES FOLDER
            if(mysqli_affected_rows($conn) == 1) { // if insert into db worked
                // upload the image to the user's folder if it does not already exist in that folder
                // run the image through a series of tests to determine if we should proceed to upload it: if image already exists or if it is too big or if it is the wrong file type -- cancel
                
                // TEST 1 of 3: Does File Already Exist..?
                if(file_exists($fullPath)) { // if img already exists in the user's images folder
                     echo " File already exists! Upload cancelled! ";
                     $OKtoUpload = 0;
                }
                
                // TEST 2 of 3: Is File Not too Big..?
                if($_FILES['myPic']['size'] > 5000000) {
                    // image exceeds max file size of 5 MB
                    echo " Image exceeds 5 MB max! Upload cancelled! ";
                    $OKtoUpload = 0;
                }
                
                // TEST 3 of 3: Is File a Supported Image File Type..?
                $fileType = pathinfo($imgName, PATHINFO_EXTENSION);
                // if NOT any type of img ext, it's a BAD file
                if($fileType != "jpg" && $fileType != "png" 
                    && $fileType != "jpeg" && $fileType != "gif" 
                    && $fileType != "svg" && $fileType != "JPEG" 
                    && $fileType != "JPG") {
                    echo " This is NOT a supported image type! Upload cancelled! ";
                    $OKtoUpload = 0;
                }
                
                if($OKtoUpload == 0) { // if image failed any of the 3 tests 
                    echo " Image Was NOT uploaded! Redirecting...";
                } else { // $OKtoUpload is still 1, so the image passed all 3 tests: 1.) it doen't already exist in the user's folder, 2.) it isn't too big a file 3.) it is an image, as opposed to text or whatever else). SO: upload the image to the user's own images folder
                    // if the move_uploaded_file() method returns true, the UPLOAD WORKED !!
                    if(move_uploaded_file($_FILES['myPic']['tmp_name'], $fullPath)) {
                        echo ' File Uploaded Successfully!';
                    } else {
                        echo ' Attempt to Upload file failed! Sorry!';
                    }
                }
                
            } // end if
            
        } else { // searching DB for file got result, so the file name already exists in the images table for that user
            echo 'File already exists! Please try again! Redirecting...';
        } // end if-else
        
    } else { // the image name was blank (empty string), so the user did NOT browse to a file before clicking Upload button
        echo 'No file chosen! Please try again! Redirecting...';
    }

    // whatever the result, redirect in 5 sec back to profile.php
    header("Refresh:5; url=profile.php", true, 303);

?>




