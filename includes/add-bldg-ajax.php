<?php
    require_once("../conn/connApts.php");
    // query the neighborhoods table so we can make the hood menu
    $query_hoods = "SELECT IDhood, hoodName 
    FROM neighborhoods ORDER BY hoodName";

    $result_hoods = mysqli_query($conn, $query_hoods);
?>
<!-- form tag enforces required attribute and still calls ajax function -->
<form onsubmit="return ajaxSaveBldg()">
    
<h2>Add A Building</h2>

<p>Building: <input type="text" name="bldgName" id="bldgName" style="width:200px; padding:5px 10px; font-size:1rem" required>
    
 &nbsp; &nbsp; 
    
Year Built: <input type="number" name="yearBuilt" id="yearBuilt"  style="width:50px; padding:5px 10px; font-size:1rem" required></p>

<p>Floors: <input type="number" name="floors" id="floors" style="width:50px; padding:5px 10px; font-size:1rem" required> 
   &nbsp; &nbsp; Neighborhood: 
    <select name="hoodID" id="hoodID" 
            style="font-size:1rem; padding:5px">
        <option value="-1">Please Choose</option>
<?php
    while($row_hoods=mysqli_fetch_array($result_hoods)) {
        echo '<option value="' . $row_hoods['IDhood'] . '">' . $row_hoods['hoodName'] . '</option>';
    }
?>
    </select>
</p>

<p>Address: <input type="text" name="address" id="address" style="width:375px; padding:5px 10px; font-size:1rem" required></p>

<p>Phone: <input type="text" name="phone" id="phone" style="width:150px; padding:5px 10px; font-size:1rem" required>

&nbsp; Email: <input type="email" name="email" id="email" style="width:230px; padding:5px 10px; font-size:1rem" required></p>

<p>
    <textarea name="bldgDesc" id="bldgDesc" rows="3" cols="70" placeholder="Building Description" style="font-size:1rem; padding:5px" required></textarea>
</p>

<input type="checkbox" name="doorman" id="doorman" value="1" style="width:30px">
<label for="doorman">Doorman</label>

<input type="checkbox" name="pets" id="pets" value="1" style="width:30px">
<label for="pets">Pet-Friendly</label>

<input type="checkbox" name="elevator" id="elevator" value="1" style="width:30px">
<label for="elevator">Elevator</label>

<br/><br/>

<input type="checkbox" name="parking" id="parking" value="1" style="width:30px">
<label for="parking">Parking</label>

<input type="checkbox" name="gym" id="gym" value="1" style="width:30px">
<label for="gym">Fitness Center</label>

<input type="checkbox" name="laundry" id="laundry" value="1" style="width:30px">
<label for="laundry">Laundry Room</label>

<br/><br/>

<button style="width:200px; padding:5px; font-weight:bold; font-size:1rem">SAVE BUILDING</button>

<h4 id="server-sez" style="color:#3b87c1">&nbsp;</h4>

</form>

<script>

// the text input fields
const bldgName = document.getElementById('bldgName')
const floors = document.getElementById('floors')
const yearBuilt = document.getElementById('yearBuilt')
const address = document.getElementById('address')
const email = document.getElementById('email')
const phone = document.getElementById('phone')
// the checkboxes
const doormanCB = document.getElementById('doorman')
const petsCB = document.getElementById('pets')
const gymCB = document.getElementById('gym')
const parkingCB = document.getElementById('parking')
const elevatorCB = document.getElementById('elevator')
const laundryCB = document.getElementById('laundry')
// hood menu
const hoodID = document.getElementById('hoodID')
// textarea bldg desc
const bldgDesc = document.getElementById('bldgDesc')

var newBldgID = 0 // for storing the primary key ID of new bldg
var serverSez = document.getElementById('server-sez')
    
// function runs when user clicks SAVE BLDG btn
function ajaxSaveBldg() {
    
  if(hoodID.value == -1) { // if no hood chosen
      serverSez.innerHTML = "Please Choose a Neighborhood!"
  } else { // hood chosen, so do the AJAX
    // get the checkbox values: alternative to 
    // if-else: ternary expression:
    const doorman = doormanCB.checked ? 1 : 0
    const pets = petsCB.checked ? 1 : 0
    const gym = gymCB.checked ? 1 : 0
    const parking = parkingCB.checked ? 1 : 0
    const elevator = elevatorCB.checked ? 1 : 0
    const laundry = laundryCB.checked ? 1 : 0

    // 2.) concat querystring of variables appended to URL
    let url = "../CMS/add-bldg-proc.php?"
    url += "bldgName=" + bldgName.value
    url += "&floors=" + floors.value
    url += "&yearBuilt=" + yearBuilt.value
    url += "&address=" + address.value
    url += "&email=" + email.value
    url += "&phone=" + phone.value
    url += "&hoodID=" + hoodID.value
    url += "&bldgDesc=" + bldgDesc.value
    // now for the checkboxes, whose values are either 1 or 0
    url += "&doorman=" + doorman
    url += "&pets=" + pets
    url += "&gym=" + gym
    url += "&elevator=" + elevator
    url += "&parking=" + parking
    url += "&laundry=" + laundry    

    // 3.) Make an AJAX call, sending vars to named url
    let xhr = new XMLHttpRequest()
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
           newBldgID = xhr.responseText; // the primary key id of new bldg
            if(newBldgID != -1) { // if the INSERT INTO query worked
                serverSez.innerHTML = "Congrats! New Building Saved Successfully"
                setTimeout(clearAllBldg, 5000) // in 5 sec, call clearAll
                updateBldgMenu() // add new bldg to select menu as the default (pre-selected) option
            } else { // it IS -1, so INSERT INTO failed
                serverSez.innerHTML = "Sorry! Could not save new building!"
            }
        }
    }
    xhr.open("GET", url, true)
    xhr.send()
      
    return false // stop the process
      
  } // end if-else

} // function ajaxSaveBldg()

function clearAllBldg() {
    // the setTimeout() method takes 2 args: a function to run and how many miliseconds to delay before running it

        // clear all text input fields
        bldgName.value = ""
        floors.value = ""
        yearBuilt.value = ""
        address.value = ""
        phone.value = ""
        email.value = ""
        // uncheck all checkboxes
        doormanCB.checked = false
        petsCB.checked = false
        gymCB.checked = false
        parkingCB.checked = false
        elevatorCB.checked = false
        laundryCB.checked = false
        // reset the hood menu
        hoodID.selectedIndex = 0
        // empty the text area
        bldgDesc.value = ""

        // clear the server response text
        serverSez.innerHTML = "&nbsp;"
    
} // end clearAllBldg() function
    
// once a new bldg has been saved, we immediately update the building menu in the Add-an-APT CMS:
function updateBldgMenu() {
    
    // get the building menu (select element)
    const bldgMenu = document.getElementById('bldgID')
    
    // add the new building as default first option
    let newOption = '<option value="' + newBldgID + '">' + bldgName.value + '</option>'
    
    bldgMenu.innerHTML =  newOption + bldgMenu.innerHTML
    
} // function updateBldgMenu()

</script>

