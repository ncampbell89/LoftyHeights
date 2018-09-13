<?php

require_once('conn/connApts.php');

// ##**##** NPFL CODE BLOCK 1 START ##**##**
    $rowsPerPg = 10; // num results to display per pg

    $currentPage = $_SERVER['PHP_SELF']; // this page processes itself

    if(isset($_GET['pageNum'])) { // true on all but first results load
        $pageNum = $_GET['pageNum']; // etc. etc
    } else { // there is no pageNum var in the querystring
        $pageNum = 0; // the first page is zero
    }

    // $pageNum * $rowsPerPg = 0 * 10 on first Page = 0
    $startRow = $pageNum * $rowsPerPg;  // set the first record to display

    // ##**##** NPFL CODE BLOCK 1 END  ##**##** 

    $query_apts = "SELECT * from apartments, buildings, neighborhoods WHERE
    apartments.bldgID = buildings.IDbldg AND
    buildings.hoodID = neighborhoods.IDhood";

    $orderBy = 'rent';
    $ascDesc = 'ASC'; 

    // if the search form was submitted, filter the results
    if (isset($_GET['bldgID'])) {
        // if there is a value for building, even "Any", it means the form was submitted.
        // 1.) there is no form to process, so skip the POST / GET vars part
        $bdrms = $_GET['bdrms'];
        $baths = $_GET['baths'];
        $minRent = $_GET['minRent'];
        $maxRent = $_GET['maxRent'];
        $bldgID = $_GET['bldgID']; // from dynamic bldg menu (Any==-1)
        $orderBy = $_GET['orderBy']; // how user wants to sort results
        $ascDesc = $_GET['ascDesc']; // radio button choice "ASC" or "DESC"
        $rowsPerPg = $_GET['rowsPerPg']; // num results to display per pg

        $query_apts .= " AND rent BETWEEN '$minRent' AND '$maxRent'";
        
        // concat query if user chose a bldg from dynamic bldg menu
        if($bldgID != -1) { // if user chose a bldg (not ANY)
            $query_apts .= " AND bldgID='$bldgID'";
        }
        
        // concat query if user typed something into search box
        if($_GET['search'] != "") { // true if user typed something
            $search = $_GET['search'];
            $query_apts .= " AND (aptDesc LIKE '%$search%'
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
                $query_apts .= " AND bdrms='$bdrms'";
            } else { // rounding off DID change the value, so
                // bdrms is NOT an integer, but rather 1.1 or 2.1
                // lose the point-1
                $bdrms = round($bdrms);
                $query_apts .= " AND bdrms >='$bdrms'";
            } // end if-else 
        } // end if
        
        if($baths != -1) { // if baths menu choice not "Any"
            // filter for baths (concat query)
            // multiply baths by 10 to get rid of pesky decimals
            $baths10 = $baths * 10; // 1.5 becomes 15; 1.6 becomes 16
            // do we get a remainder when dividing by 5? If so, it is a plus-sign choice value (16, 21)
            if($baths10 % 5 == 0) { // if value is 15, 20, 25
                $query_apts .= " AND baths = '$baths'";
            } else { // has remainder, hence plus-sign choice
                $baths -= 0.1; 
                $query_apts .= " AND baths >= '$baths'";
            }
        } 

        // concat query for checkboxes -- "check" to see, one by one, if the checkboxes are actually checked
        if(isset($_GET['doorman'])) { // is the doorman variable set. if so it came over from the form, meaning doorman was checked
            $query_apts .= " AND isDoorman=1";
        }

        if(isset($_GET['pets'])) { 
            $query_apts .= " AND isPets=1";
        }

        if(isset($_GET['parking'])) { 
            $query_apts .= " AND isParking=1";
        }

        if(isset($_GET['gym'])) { 
            $query_apts .= " AND isGym=1";
        }
        
        if(isset($_GET['available'])) {
            $query_apts .= " AND isAvail=1";
        }

    } // end if form submitted

    $query_apts .= " ORDER BY $orderBy $ascDesc"; // this line MUST be LAST !


    //***!!! NPFL code block 2 of 3 START  !!! **** //

    // $query .= " LIMIT $startRow, $rowsPerPg";
    // alternative syntax using the sprintf() method
    // %d takes a number variable and %s takes a string
    $query_limit = sprintf("%s LIMIT %d, %d", $query_apts, $startRow, $rowsPerPg);

    $result_apts = mysqli_query($conn, $query_limit);  // the result will be an array of arrays (or, a multi-dimensional array)

    if(isset($_GET['totalRows'])) { // true only if not on first page
        $totalRows = $_GET['totalRows'];
    } else {
      $all = mysqli_query($conn, $query_apts);
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