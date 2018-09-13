 <?php
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