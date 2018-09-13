<table border="1" cellpadding="5" width="100%" style="background-color:rgba(239, 230, 216, 0.62); box-shadow: 2px 2px 2px #777">
    
        <!-- NPFL Recordset Pagination -->
        <tr>
            <td colspan="10">
                
            <!-- THIRD and FINAL NPFL CODE BLOCK contains HTML & PHP mix -->
			<!-- NPFL CODE BLOCK 3 of 3 START -->

                  <a href="search.php">New Search</a>

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

        <tr>
            <th>Apt</th>
            <th>Building</th>
            <th>Bedrooms</th>
            <th>Baths</th>
            <th>Rent</th>
            <th>Floor</th>
            <th>Sqft</th>
            <th>Status</th>
            <th>Neighborhood</th>
            <th>Amenities</th>
        </tr>
        
    <?php
    while($row = mysqli_fetch_array($result_apts)){ ?>
      <tr>
          <td>
              <?php 
                echo '<a href="http://localhost/LoftyHeights/CMS/aptDetails.php?choice=apt&IDapt=' . $row['IDapt'] . '">' . $row['apt']. '</a>';
              ?>
          </td>
          <td>
              <?php 
              echo '<a href="http://localhost/LoftyHeights/CMS/bldgDetails.php?choice=bldg&IDbldg=' . $row['bldgID'] . '">' . $row['bldgName'] . '</a>';
              ?>
          </td>
          <td><?php echo $row['bdrms'] == 0 ? 'Studio' : $row['bdrms']; ?></td>
          <td><?php echo $row['baths']; ?></td>
          <td>$<?php echo number_format($row['rent']); ?></td>
          <td><?php echo $row['floor']; ?></td>
          <td><?php echo number_format($row['sqft']); ?></td>
          <td><?php echo $row['isAvail'] == 0 ? 'Occupied' : 'Available'; ?></td>
          <td><?php echo $row['hoodName']; ?></td>
          <td>
              <?php if ($row['isPets']) echo 'Pets<br>'; ?>
              <?php if ($row['isGym']) echo 'Gym<br>'; ?>
              <?php if ($row['isDoorman']) echo 'Doorman<br>'; ?>
              <?php if ($row['isParking']) echo 'Parking<br>'; ?>
          </td>
      </tr>
        
    <?php } ?>
    
    </table>

    <style>
        table {
            border-collapse: collapse;
            background-color: #FFF;
        }
    </style>



