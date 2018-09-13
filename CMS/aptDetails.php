<?php 
require_once("../conn/connApts.php");
include 'CMSauthenticate.php';
$IDapt = $_GET['IDapt'];

$query = "SELECT * FROM apartments, buildings, image WHERE apartments.bldgID = buildings.IDbldg AND IDapt = '$IDapt';";

$imageQuery = "SELECT * FROM apartments, image WHERE apartments.IDapt = image.foreignID AND IDapt = '$IDapt' AND catID = 1;";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

$imageResult = mysqli_query($conn, $imageQuery);

//$row_cnt = $imageResult->num_rows;
//echo mysqli_error($conn);

	$title = "Apartment " . $row['apt'] . " Details"; 
    include '../includes/head2.php'; 
    include 'CMSheader.php';
    include "../includes/CMS.php";
?>



  <form method="post" action="aptDetailsProc.php">
	  <main>  
      <!-- include a hidden IDapt so that processor knows which record to update in the database -->
      <input type="hidden" name="IDapt" value="<?php echo $row['IDapt']; ?>"> 
    	<table>  
			<tr>
				<td colspan="3">
					<h1>Apartment <input type="text" name="apt" style="width:50px; font-weight:bold" value="<?php echo $row['apt']; ?>"> Details
					</h1>
					Listing Title:<br/>
					<textarea name="aptTitle" cols="80" rows="2" style="font-size:1rem;padding:5px"><?php echo $row['aptTitle']; ?></textarea>
				</td>
			</tr>

			<tr>
				<td rowspan="3">
					<img width="200px" id="mainPic" src="../images/propPics/<?php echo $imageRow['imgName'] == '' ? "SohoLoftsApt2.jpg": $imageRow['imgName']; ?>">
                    
                    <div class="thumbs" style="background-color:transparent; overflow-x:scroll; max-height:100px; white-space:nowrap; width:16.5vw">
					<?php 
                        while($imageRow = mysqli_fetch_array($imageResult)){
                            echo '<img style="margin-right:4px" onclick="switchImage()" width="70px" src="../images/propPics/' . $imageRow['imgName'] . '" id="' . $imageRow['imgName'] . '">';
                        } 
					?>
                    </div>
				</td>
				<td colspan="3">
					Sq Ft: <input type="number" name="sqft" style="width:100px" value="<?php echo $row['sqft']; ?>">
					&nbsp;&nbsp; 
					Floor: <input type="number" name="floor" style="width:100px" value="<?php echo $row['floor']; ?>">
					&nbsp;&nbsp;
					Rent: $ <input type="number" name="rent" style="width:100px" value="<?php echo $row['rent']; ?>">
				</td>
			</tr>

			<tr>
				<td colspan="2">
				<!-- radio buttons set to Available or Occupied; isAvail = 1 = Available; isAvail = 0 = Occupied -->
					<input type="radio" name="isAvail" id="available" style="width:30px" value="1" <?= $row['isAvail'] == 1 ? 'checked' : '' ?>>
					<label for="available">Available</label>
					 &nbsp;  &nbsp;  &nbsp; 
					<input type="radio" name="isAvail" id="occupied" style="width:30px" value="0" <?php if($row['isAvail'] == 0) { echo 'checked'; }; ?>>
					<label for="occupied">Occupied</label>
					<br/><br/>
					<textarea name="aptDesc" placeholder="Apartment Description" cols="60" rows="5" style="font-size:1rem;padding:5px"><?php echo $row['aptDesc']; ?></textarea>
				</td>
			</tr>

			<tr>
				<td style="font-size:1.3rem">
					Bedrooms: &nbsp; 
					<select name="bdrms" style="font-size:1.1rem">
						 <option value="0" <?php if($row['bdrms'] == 0) echo 'selected'; ?>> Studio</option>
						 <option value="1" <?php if($row['bdrms'] == 1) echo 'selected'; ?> >1 Bedroom</option>
						 <option value="2" <?php if($row['bdrms'] == 2) echo 'selected'; ?> >2 Bedrooms</option>
						 <option value="3" <?php if($row['bdrms'] == 3) echo 'selected'; ?> >3 Bedrooms</option>
					</select>
				</td>
				<td style="font-size:1.3rem">
					Baths: &nbsp; 
					<select name="baths" style="font-size:1.1rem">
						 <option value="1" <?php if($row['baths'] == 1) echo 'selected'; ?> > 1 Bath</option>
						 <option value="1.5" <?php if($row['baths'] == 1.5) echo 'selected'; ?> >1 1/2 Baths</option>
						 <option value="2" <?php if($row['baths'] == 2) echo 'selected'; ?> >2 Baths</option>
						 <option value="2.5" <?php if($row['baths'] == 2.5) echo 'selected'; ?> >2 1/2 Baths</option>
					</select>
				</td>
			</tr>

			<tr>
				<!-- If a button inside a form does NOT have a type="button" attribute, it will submit the form when clicked. OR use <input type="submit" .. -->
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
        
		<button type="button" class="back" onclick="goBack()" style="position:relative; top:16rem; padding:5px; font-size:1rem; background-color:#e4d9c7; box-shadow:1px 1px 1px #000; font-weight:bold; letter-spacing:2px">&lt;&lt;&nbsp; Previous Page</button>
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