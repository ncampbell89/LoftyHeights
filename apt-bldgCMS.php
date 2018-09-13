<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="utf-8">
    <title>Apt-Bldg CMS</title>
    <link href="css/apts.css" rel="stylesheet">
    
    <?php
        // load the IDbldg and bldgName from buildings table
        require_once("conn/connApts.php");
        $query = "SELECT IDbldg, bldgName FROM buildings 
                  ORDER BY bldgName ASC";
        $result = mysqli_query($conn, $query);
    ?>
    
</head>
    
<body>
    

  <div id="AP-apt">
      
    <div id="AP-apt-tab" onclick="swapForm()">
        APT
    </div>
        
     <table width="500px" border="0px" cellpadding="5px" align="center">
    
        <tr>
            <td colspan="2" align="center">
                <h2>Add-an-Apt CMS</h2>
                <h4>
                    <a href="CMS-searchApts.php">Click HERE to UPDATE an Existing Apartment</a>
                </h4>
            </td>
        </tr>
         
        <tr>
            <td>
                Bedrooms:  
                <select name="bdrms" id="bdrms" onchange="clearResponseText()">
                    <option value="-1">Please Choose</option>
                    <option value="0">Studio</option>
                    <option value="1">1 Bedroom</option>
                    <option value="2">2 Bedrooms</option>
                    <option value="3">3 Bedrooms</option>
                </select>
            </td>
            <td>
               Baths: 
                <select name="baths" id="baths"
                        onchange="clearResponseText()">
                    <option value="-1">Please Choose</option>
                    <option value="1">1 Bath</option>
                    <option value="1.5">1.5 Baths</option>
                    <option value="2">2 Baths</option>
                    <option value="2.5">2.5 Baths</option>
                </select>
            </td>
        </tr>
         
        <tr>
            <td>
                Availability: 
                <select name="isAvail" id="isAvail"
                        onchange="clearResponseText()">
                    <option value="-1">Please Choose</option>
                    <option value="0">Occupied</option>
                    <option value="1">Available</option>
                </select>
            </td>
            <td>
                Building: 
                <select name="bldgID" id="bldgID"
                        onchange="clearResponseText()">
                    <option value="-1">Please Choose</option>

                     <?php 
                        while($row = mysqli_fetch_array($result)) {
                            echo "<option value='${row['IDbldg']}'>${row['bldgName']}</option>";
                        }
                    ?>
    
                </select>
            </td>
        </tr>
         
        <tr>
            <td>
                Rent: 
                $ <input type="number" name="rent" id="rent" style="width:50px"> &nbsp; 
                Sqft: 
                <input type="number" name="sqft" id="sqft" style="width:50px">
            </td>
            <td>
                Floor:
                <input type="number" name="floor" id="floor" style="width:50px"> &nbsp; 
                Apt: 
                <input type="text" name="apt" id="apt" style="width:50px">
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <!-- <input type="submit" name="submit" id="submit" value="Submit"> -->
                <button onclick="addApt()">
                    ADD NEW APARTMENT
                </button> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                
                <!--<a href="selectApts.php">SHOW ALL APARTMENTS </a>-->
                
                <br/>
                <h3 id="resp"></h3>
            </td>
        </tr>
    
     </table>
       
    </div><!-- close AP-apt -->
    
    <div id="AP-bldg">
        
      <div id="AP-bldg-tab"
           onclick="swapForm()">
        BLDG
      </div>
        
     <table width="500px" border="0px" cellpadding="5px" align="center">
    
        <tr>
            <td colspan="2" align="center">
                <h2>Add-a-Building CMS</h2>
                <h4>
                    <a href="CMS-searchApts.php">Click HERE to UPDATE an Existing Building</a>
                </h4>
            </td>
        </tr>
         
        <tr> 
            <td>
                Building Name: &nbsp;   
                <input type="text" name="bldgName" id="bldgName" style="width:150px">
            </td>
            
            <td>
               Year Built: &nbsp;  
                <input type="number" name="yearBuilt" id="yearBuilt" style="width:50px">
            </td>
            
            <td>
                Floors: 
                 <input type="number" name="floors" id="floors" style="width:50px">
            </td>      
        </tr>
         
        <tr>
            <td>Address: &nbsp; 
               <textarea name="address" id="address" cols="40"
                         rows="2"></textarea>
            </td>

            <td>
                Phone: 
                <input type="text" name="phone" id="phone" style="width:100px">
            </td>
            
            <td>
                Email: 
                <input type="email" name="email" id="email" style="width:100px">
            </td>
            
         </tr>
   
         <tr>
             <td colspan="3">
                 Amenities: &nbsp; 
                <input type="checkbox" name="pets" id="pets" class="cb" value="1">
                <label for="pets">Pet-friendly</label> &nbsp; 
                 
                <input type="checkbox" name="doorman" id="doorman" class="cb" value="1">
                <label for="doorman">Doorman</label> &nbsp; 
                 
                <input type="checkbox" name="parking" id="parking" class="cb" value="1">
                <label for="parking">Parking</label> &nbsp; 
  
                <input type="checkbox" name="gym" id="gym" class="cb" value="1"> 
                <label for="gym">Fitness Center</label>
                 
            </td>
        </tr>

        <tr>
         
            <td colspan="3">
                Description: &nbsp; 
               <textarea name="bldgDesc" id="bldgDesc" cols="80"
                         rows="3"></textarea>
            </td>
         
        </tr>
         
         <tr>
            <td colspan="2" align="center">
                <!-- <input type="submit" name="submit" id="submit" value="Submit"> -->
                <button onclick="addBldg()">
                    ADD NEW BUILDING
                </button> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                
                <br/>
                <h3 id="resp-bldg"></h3>
            </td>
        </tr>
    
     </table>
       
    </div><!-- close AP-bldg -->
    
   <script src="js/apts.js"></script>
    
  </body>

</html>


