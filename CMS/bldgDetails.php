<?php	
	require_once("../conn/connApts.php");
    include 'CMSauthenticate.php';
    include "../includes/CMS.php";
	// get variable from
	$bldgID = $_GET['IDbldg'];

	$query = "SELECT * FROM image, buildings WHERE IDbldg = '$bldgID'";
	$result = mysqli_query($conn, $query);

    $imageQuery = "SELECT * FROM buildings, image WHERE buildings.IDbldg = image.foreignID AND IDbldg = '$bldgID' AND catID = 2;";
    $imageResult = mysqli_query($conn, $imageQuery);
	// Store the row retrieved from the database
	$row = mysqli_fetch_array($result);

	$title = $row['bldgName'] . ' Details'; 
    include '../includes/head2.php'; 
    include 'CMSheader.php';
?>
	
<!-- 4 row 3 column table 
	NAME 	NAME 	NAME
	IMG 	FLOORS 	YEARBUILT
	IMG 	DESC 	DESC
	ADDRESS	PHONE	EMAIL
-->
	<form method="post" action="CMS/bldgDetailsProc.php" style="margin:0">
		<main>
		<!-- include hidden IDbldg for processor to know which record to update-->
		<input type="hidden" name="IDbldg" value="<?php echo $row['IDbldg']; ?>">
		<table style="border-spacing:10px">
			<tr>
				<td colspan="3">
					<h1>
						<input type="text" name="bldgName" style="width:200px;" placeholder="Building" value="<?php echo $row['bldgName']?>">
						Details
					</h1>
				</td>
			</tr>

			<tr>
				<td colspan="3">
					<input type="checkbox" name="doorman" id="doorman" class="cbW"<?php if($row['isDoorman'] == 1) echo 'checked'; ?>>
					<label for="doorman">Doorman</label>
					
					<input type="checkbox" name="pets" id="pets" class="cbW"<?php if($row['isPets'] == 1) echo 'checked'; ?>>
					<label for="pets">Pet-friendly</label>
					
					<input type="checkbox" name="parking" id="parking" class="cbW"<?php if($row['isParking'] == 1) echo 'checked'; ?>>
					<label for="parking">Parking</label>
					
					<input type="checkbox" name="gym" id="gym" class="cbW"<?php if($row['isGym'] == 1) echo 'checked'; ?>>
					<label for="gym">Gym</label>
					
				</td>
			</tr>

			<tr>
				<td rowspan="3">
					<img width="200px" id="mainPic" src="../images/propPics/<?php echo $row['imgName'] == '' ? "SohoLoftsApt2.jpg": $row['imgName']; ?>">

					<div class="thumbs" style="background-color:transparent; overflow-x:scroll; max-height:100px; white-space:nowrap; width:16.5vw; margin-top:4px">
					<?php 
                        while($imageRow = mysqli_fetch_array($imageResult)){
                            echo '<img style="margin-right:4px" onclick="switchImage()" width="70px" src="../images/propPics/' . $imageRow['imgName'] . '" id="' . $imageRow['imgName'] . '">';
                        } 
					?>
                    </div>
				</td>
				<td>
					Floors:
					<input type="number" name="floors" id="floors"
							   style="width:50px;"
							   value="<?= $row['floors'];?>">
				</td>
				<td>
					Year Built: 
					<input type="number" name="yearBuilt" id="yearBuilt"
							   style="width:100px;"
							   value="<?= $row['yearBuilt'];?>">
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<textarea name="bldgDesc" cols="60" rows="5" placeholder="Building Description" style="font-size:1rem; padding:5px"><?= $row['bldgDesc'];?></textarea>
				</td>
			</tr>

			<tr>
				<td>
					Address:
					<input type="text" name="address" id="address"
						  value="<?= $row['address'];?>">
				</td>
				<td>
					Phone:
					<input type="tel" name="phone" id="phone" style="width:150px" value="<?= $row['phone'];?>">
				</td>
			</tr>
            <tr>
                <td colspan="3">
					Email: <input type="email" name="email" id="email" style="width:90%" value="<?= $row['email'];?>">
                </td>
            </tr>
            
			<tr>
				<td colspan="3" align="center">
					<button class="backBtn" style="padding:5px; font-size:1rem; background-color:#e4d9c7; box-shadow:1px 1px 1px #000; font-weight:bold; text-transform:uppercase; letter-spacing:2px; width:100%">Save Changes</button>
				</td>
			</tr>
		</table>
		</main>
	</form>

	<aside>
        <h2>Upload Image</h2>
        <form method="post" action="upload-proc.php" enctype="multipart/form-data">
            <p><input style="padding:0px" type="file" name="myPic" id="myPic"></p>
            <p><input type="checkbox" name="isMainPic" id="isMainPic">
                <label for="isMainPic">My Main Profile Pic</label>
            </p>
            <p><input style="background-color:#fff; padding:5px; width:51%; text-align:center" type="submit" name="submit-pic" id="submit-pic" value="Upload"></p>
        </form>
        
		<button type="button" class="back" onclick="goBack()" style="position:relative; top:15.75rem; padding:5px; font-size:1rem; background-color:#e4d9c7; box-shadow:1px 1px 1px #000; font-weight:bold; letter-spacing:2px">&lt;&lt;&nbsp; Previous Page</button>
	</aside>

	<script>       
		function goBack() {
			window.history.back();
		}

		function switchImage() {
			let mainPic = document.getElementById('mainPic');
			let mainPicSrc = mainPic.src;
			let smallSrc = event.target.src;
			mainPic.src = smallSrc;
			event.target.src = mainPicSrc;
		}  
		
	</script>

	<?php include '../includes/footer.php'; ?>