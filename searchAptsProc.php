<?php 

// 1.) there is no form to process, so skip the POST / GET vars part
$bdrms = $_GET['bdrms'];
$baths = $_GET['baths'];
$minRent = $_GET['minRent'];
$maxRent = $_GET['maxRent'];
$bldgID = $_GET['bldgID']; // from dynamic bldg menu (Any==-1)
$orderBy = $_GET['orderBy']; // how user wants to sort results
$ascDesc = $_GET['ascDesc']; // radio button choice "ASC" or "DESC"
$rowsPerPg = $_GET['rowsPerPg']; // num results to display per pg

// ##**##** NPFL CODE BLOCK 1 START ##**##** 

$currentPage = $_SERVER['PHP_SELF']; // this page processes itself

if(isset($_GET['pageNum'])) { // true on all but first results load
    $pageNum = $_GET['pageNum']; // etc. etc
} else { // there is no pageNum var in the querystring
    $pageNum = 0; // the first page is zero
}

// $pageNum * $rowsPerPg = 0 * 10 on first Page = 0
$startRow = $pageNum * $rowsPerPg;  // set the first record to display

// ##**##** NPFL CODE BLOCK 1 END  ##**##** 

// 2 + 3.) Connect to mysql, and select the database
require_once("conn/connApts.php");

// 4.) write out the CRUD "order" (query) -- what you want to do
$query = "SELECT * from apartments, buildings, neighborhoods
WHERE apartments.bldgID = buildings.IDbldg 
AND buildings.hoodID = neighborhoods.IDhood 
AND rent BETWEEN '$minRent' AND '$maxRent'";

// concat query if user chose a bldg from dynamic bldg menu
if($bldgID != -1) { // if user chose a bldg (not ANY)
    $query .= " AND bldgID='$bldgID'";
}

// concat query if user typed something into search box
if($_GET['search'] != "") { // true if user typed something
    $search = $_GET['search'];
    $query .= " AND (aptDesc LIKE '%$search%'
                     OR bldgDesc LIKE '%$search%'
                     OR hoodDesc LIKE '%$search%'
                     OR bldgName LIKE '%$search%'
                     OR aptTitle LIKE '%$search%'
                     OR address LIKE '%$search%')"; 
}

// concat query for bdrms and baths if menu choice is NOT "Any"
if($bdrms != -1) { // if bdrms menu choice not "Any"
    // filter for bdrms (concat query)
    // is it a plus-sign choice or not (1+, 2+) .. ??
    // if rounding off bdrms does NOT change value, then
    // bdrms is an integer already (NOT 1.1 or 2.1)
    if($bdrms == round($bdrms)) {
        $query .= " AND bdrms='$bdrms'";
    } else { // rounding off DID change the value, so
        // bdrms is NOT an integer, but rather 1.1 or 2.1
        // lose the point-1
        $bdrms = round($bdrms);
        $query .= " AND bdrms >='$bdrms'";
    } // end if-else 
} // end if

if($baths != -1) { // if baths menu choice not "Any"
    // filter for baths (concat query)
    // multiply baths by 10 to get rid of pesky decimals
    $baths10 = $baths * 10; // 1.5 becomes 15; 1.6 becomes 16
    // do we get a remainder when dividing by 5? If so, it is a plus-sign choice value (16, 21)
    if($baths10 % 5 == 0) { // if value is 15, 20, 25
        $query .= " AND baths = '$baths'";
    } else { // has remainder, hence plus-sign choice
        $baths -= 0.1; 
        $query .= " AND baths >= '$baths'";
    }
} 

// concat query for checkboxes -- "check" to see, one by one, if the checkboxes are actually checked
if(isset($_GET['doorman'])) { // is the doorman variable set. if so it came over from the form, meaning doorman was checked
    $query .= " AND isDoorman=1";
}

if(isset($_GET['pets'])) { 
    $query .= " AND isPets=1";
}

if(isset($_GET['parking'])) { 
    $query .= " AND isParking=1";
}

if(isset($_GET['gym'])) { 
    $query .= " AND isGym=1";
}

$query .= " ORDER BY $orderBy $ascDesc"; // this line MUST be LAST !

// Order by *columnName* *ASC/DESC* <-- Sort based on a column

// 5.) execute the order: read records from apartments table

// 6.) specify range of results: from start num, show X rows per pg

//***!!! NPFL code block 2 of 3 START  !!! **** //

// $query .= " LIMIT $startRow, $rowsPerPg";
// alternative syntax using the sprintf() method
// %d takes a number variable and %s takes a string
$query_limit = sprintf("%s LIMIT %d, %d", $query, $startRow, $rowsPerPg);

$result = mysqli_query($conn, $query_limit);  // the result will be an array of arrays (or, a multi-dimensional array)

 if(isset($_GET['totalRows'])) { // true only if not on first page
      $totalRows = $_GET['totalRows'];
    } else {
      $all = mysqli_query($conn, $query);
      $totalRows = mysqli_num_rows($all);
    }
    //for 17 records with 5 per page, we need 4 total pages: 
    // ceil = round up, so ceil(17/5) = 4 - 1 = 3, but first page is zero, so totalPages=3 is really 4
    $totalPages = ceil($totalRows/$rowsPerPg)-1;  

    $queryString = "";
    if (!empty($_SERVER['QUERY_STRING'])) { // if URL has vars
      // explode querystring into $params array using & as delimiter
      $params = explode("&", $_SERVER['QUERY_STRING']);
      $newParams = array(); // make a new empty array
      // loop through the array made (exploded) from querystring vars
      foreach ($params as $param) {  
          // stristr() method finds first occurance of substring
          // if the array element string is not pageNum or totalRows
          // so the if statement code is running only on the form variables 
        if (stristr($param, "pageNum") == false && 
            stristr($param, "totalRows") == false) {
            // add that element to the new array
           array_push($newParams, $param); // these are the form variables
        }
      }
      if (count($newParams) != 0) { // if at least one item got added to array, then there must have been a querystring
          // reassemble the queryt
        $queryString = "&" . htmlentities(implode("&", $newParams));
      }
    }
    $queryString = sprintf("&totalRows=%d%s", $totalRows, $queryString);
    //***!!! NPFL code block 2 of 3 END  !!! **** //

?>

<!DOCTYPE html>

<html lang="en-us">
    
<head>
    
    <meta charset="utf-8">
    
    <title>Member Join Processor</title>
    <link href="css/apts.css" rel="stylesheet">

</head>

<body>
    
    <table width="800" border="1" cellpadding="5">
    
        <tr>
            <td colspan="14" align="center">
                <h1 align="center">Lofty Heights Apartments</h1>
                <h2>
                    <?php echo mysqli_num_rows($result); ?>
                    Results Found
                </h2>
            </td>
        </tr>
        
        <!-- NPFL Recordset Pagination -->
        <tr>
            <td colspan="14">
                
                         <!-- THIRD and FINAL NPFL CODE BLOCK contains HTML & PHP mix -->
			<!-- NPFL CODE BLOCK 3 of 3 START -->

                  <a href="searchApts.php">New Search</a>

                  &nbsp; &nbsp; &nbsp; &nbsp; | 
                  &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp;
                      
            <!-- show the results range: "Results X-Z of Z" -->
            <!-- X = $startRow + 1 (+1 cuz $startRow is by index, starting w 0) -->
            <strong>Results <?php echo ($startRow + 1); ?> - 
            <!-- min() returns smaller of 2 values, which is either the last item
              in the current result range or the last result: 
                $startRow + $rowsPerPg = current range: 11-20 ($rowsPerPg = )
                Results 11-20 of 24 or Results 21-24 of 24 -->
                    <?php echo min($startRow + $rowsPerPg, $totalRows); ?> 
                    of <?php echo $totalRows; ?></strong>  
                  
                  &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; 
            
            <!-- The Next link carries all the POST vars, turning them into GET  -->
                <?php // Show if not last page
                      if($pageNum < $totalPages) { ?>
                        <a href="<?php printf("%s?pageNum=%d%s", $currentPage, min($totalPages, $pageNum + 1), $queryString); ?>">Next</a> &nbsp; | &nbsp; 
               <?php } // Show if not last page ?>
          
                   <?php 
                          if($pageNum > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum=%d%s", $currentPage, max(0, $pageNum - 1), $queryString); ?>">Previous</a> &nbsp;&nbsp;| &nbsp;&nbsp;
                <?php } // Show if not first page ?>
          
                   <?php
                  if($pageNum > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum=%d%s", $currentPage, 0, $queryString); ?>">First &nbsp;&nbsp;| &nbsp;&nbsp;</a>
               <?php } // Show if not first page ?>
          
                  <!-- The Last link carries all the POST vars, turning them into GET  -->
                    <?php
                   if($pageNum < $totalPages) { // Show if not last page ?>
                             <a href="<?php printf("%s?pageNum=%d%s", $currentPage, $totalPages, $queryString); ?>">Last</a>
                     <?php } // Show if not last page ?>    

			 <!-- ######  END NPFL CODE BLOCK 3 OF 3 -- DONE!! ########   -->
                
            </td>
        </tr>
        
        <?php 
            if(mysqli_num_rows($result) == 0) { // no results, so no header row
                echo '<tr><td colspan="14"><h3 align="center">
                                Sorry! No results found! <br/>
                                <button style="font-size:1rem; margin:10px; padding:5px" onclick="window.history.back()">
                                    Search Again</button><br/>
                                    Redirecting...</h3></td></tr>';
                
                // if user does not click the Search Again button, 
                // redirect to search page after 10 seconds
                header("Refresh:10; url=searchApts.php", true, 303);
                
            } else { // we got at least 1 result, so output header row
                echo '<tr><th>ID</th>
                        <th>Apt</th>
                        <th>Building</th>
                        <th>Bedrooms</th>
                        <th>Baths</th>
                        <th>Rent</th>
                        <th>Floor</th>
                        <th>Sqft</th>
                        <th>Status</th>
                        <th>Neighborhood</th>
                        <th>Doorman</th>
                        <th>Pets</th>
                        <th>Gym</th>
                        <th>Parking</th></tr>';   
            } // end if-else
        ?>
        
        <?php
        while($row = mysqli_fetch_array($result_apts)) { ?>
          
          <tr>
              <td><?php echo $row['IDapt']; ?></td>
              <td>
                  <?php 
                      echo '<a href="aptDetails.php?IDapt=' 
                          . $row['IDapt'] . '">' 
                          . $row['apt'] . '</a>';
                  ?>
              </td>
              
              <td>
              
            <?php 
              echo '<a href="bldgDetails.php?bldgID=' 
                  . $row['bldgID'] . '">' 
                  . $row['bldgName'] . '</a>';
            ?>
              
              </td>
              
              <td><?php echo $row['bdrms'] == 0 ? 'Studio' : $row['bdrms']; ?>
              
              </td>
              <td><?php echo $row['baths']; ?></td>
              <td>$<?php echo number_format($row['rent']); ?></td>
              <td><?php echo $row['floor']; ?></td>
              <td><?php echo number_format($row['sqft']); ?></td>
              <td>
                <?php 
                    if($row['isAvail'] == 0) {
                      echo "Occupied";
                    } else { // value is 1
                      echo "Available";
                    }                
                ?>
              
              </td>
              <td><?php echo $row['hoodName']; ?></td>
              <td>
                  
                <?php 
              
                    if($row['isDoorman'] == 0) {
                      echo 'No'; 
                    } else {
                      echo 'Yes';
                    }
              
                ?>
              
              </td>
              
              <td><?php echo $row['isPets'] == 0 ? 'No':'Yes'; ?></td>
              
              <td><?php echo $row['isGym'] == 0 ? 'No':'Yes'; ?></td>
              
              <td><?php echo $row['isParking'] == 0 ? 'No':'Yes'; ?></td>
              
          </tr>
        
        <?php } ?>
    
    </table>
    
</body>
   
</html>