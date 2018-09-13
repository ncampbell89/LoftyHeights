<?php
    require_once("../conn/connApts.php");
    // query buildings table for all IDbldg and bldgName
    // use these in a while loop to make building menu
    $query_bldgs = "SELECT IDbldg, bldgName 
    FROM buildings ORDER BY bldgName";

    $result_bldgs = mysqli_query($conn, $query_bldgs);
?>

<form onsubmit="return ajaxSaveApt()">

    <h2>Add An Apartment</h2>
    
     <p>
      <textarea name="aptTitle" id="aptTitle" rows="1" cols="70" placeholder="Apartment Listing Title" style="font-size:1rem; padding:5px" required></textarea>
    </p>

    <p>
        Bedrooms:  
        <select name="bdrms" id="bdrms">
            <option value="-1">Please Choose</option>
            <option value="0">Studio</option>
            <option value="1">1 Bedroom</option>
            <option value="2">2 Bedrooms</option>
            <option value="3">3 Bedrooms</option>
        </select>
        &nbsp;  &nbsp; 
       Baths: 
        <select name="baths" id="baths">
            <option value="-1">Please Choose</option>
            <option value="1">1 Bath</option>
            <option value="1.5">1.5 Baths</option>
            <option value="2">2 Baths</option>
            <option value="2.5">2.5 Baths</option>
        </select>
    </p>

    <p>
        Status: 
        <select name="isAvail" id="isAvail">
            <option value="-1">Please Choose</option>
            <option value="0">Occupied</option>
            <option value="1">Available</option>
        </select>
        
         &nbsp;  &nbsp;  Building: 
        <select name="bldgID" id="bldgID">

          <option value="-1">Please Choose</option>

          <?php
             while($row_bldgs=mysqli_fetch_array($result_bldgs)) {
                // while loop to output all bldgs 
                echo '<option value="' . $row_bldgs['IDbldg'] . '">' . $row_bldgs['bldgName'] . '</option>';
             }
          ?>

        </select>
    </p>

    <p>
        Rent: 
        $ <input type="number" name="rent" id="rent" style="width:60px" required>&nbsp; 
        Sqft: 
        <input type="number" name="sqft" id="sqft" style="width:60px" required>
        Floor:
        <input type="number" name="floor" id="floor" style="width:40px" required>&nbsp; 
        Apt: 
        <input type="text" name="aptUnit" id="aptUnit" style="width:50px" required>
    </p>
    
    <p>
      <textarea name="aptDesc" id="aptDesc" rows="3" cols="70" placeholder="Apartment Description" style="font-size:1rem; padding:5px" required></textarea>
    </p>

    <br/><br/>        
        <button style="width:200px; padding:5px; font-weight:bold; font-size:1rem">SAVE APARTMENT</button>
	
	<h4 style="color:#3b87c1" id="server-says"></h4>
    
</form>

<script>
    
    // the select menus and text input fields
    const bdrms = document.getElementById('bdrms')
    const baths = document.getElementById('baths')
    const bldgID = document.getElementById('bldgID')
    const isAvail = document.getElementById('isAvail')
    const sqft = document.getElementById('sqft')
    const rent = document.getElementById('rent')
    const floor = document.getElementById('floor')
    const aptUnit = document.getElementById('aptUnit')
    // the textarea elements
    const aptTitle = document.getElementById('aptTitle')
    const aptDesc = document.getElementById('aptDesc')
    
    var newAptID = 0 // for storing the id of the new apt
    var serverSays = document.getElementById('server-says')

    function ajaxSaveApt() {
        
      // did use choose from ALL four select menus..?
      if(bldgID.value == -1 || bdrms.value == -1 || baths.value == -1 || isAvail.value == -1) {
         serverSays.innerHTML = "Please Choose from ALL 4 Menus"
      } else {
        // 2.) concat querystring of variables appended to URL
        let url = "../add-apt-proc.php?"
        url += "bdrms=" + bdrms.value
        url += "&floor=" + floor.value
        url += "&baths=" + baths.value
        url += "&aptUnit=" + aptUnit.value
        url += "&isAvail=" + isAvail.value
        url += "&rent=" + rent.value
        url += "&sqft=" + sqft.value
        url += "&bldgID=" + bldgID.value
        url += "&aptTitle=" + aptTitle.value
        url += "&aptDesc=" + aptDesc.value
       
        // 3.) Make an AJAX call, sending vars to named url
        let xhr = new XMLHttpRequest()
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
               newAptID = xhr.responseText; // the primary key id of new bldg
                if(newAptID != -1) { // if the INSERT INTO query worked
                    serverSays.innerHTML = "New Apartment Saved! Its ID number is: " + newAptID
                    setTimeout(clearAllApts, 5000) // in 5 sec, call clearAll
                } else { // it IS -1, so INSERT INTO failed
                    serverSays.innerHTML = "Sorry! Could not save new apartment!"
                }
            }
        }
        xhr.open("GET", url, true)
        xhr.send()
         
      } // end if-else
        
      return false

    } // function ajaxSaveBldg()

    function clearAllApts() {

        // the setTimeout() method takes 2 args: a function to run and how many miliseconds to delay before running it

            // clear all text input fields
            rent.value = ""
            sqft.value = ""
            floor.value = ""
            aptUnit.value = ""
            // reset the select menus to Please Choose at index 0
            bdrms.selectedIndex = 0;
            baths.selectedIndex = 0;
            isAvail.selectedIndex = 0;
            bldgID.selectedIndex = 0;
            // clear the message
            serverSays.innerHTML = "&nbsp;"

    } // end clearAllApts() function

</script>

     