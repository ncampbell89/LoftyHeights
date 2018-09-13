<form onsubmit="return ajaxSaveHood()">
    
<h2>Add A Neighborhood</h2>

<p>Neighborhood: <input type="text" name="hoodName" id="hoodName" style="width:200px; padding:5px 10px; font-size:1rem" required></p>
    
<p>
    Borough: 
    <select name="borough" id="borough">
        <option value="-1" selected>Please Choose</option>
        <option value="Bronx">Bronx</option>
        <option value="Brooklyn">Brooklyn</option>
        <option value="Manhattan">Manhattan</option>
        <option value="Queens">Queens</option>
        <option value="Staten Island">Staten Island</option>
    </select>
</p>

<p>Subway: <input type="text" name="subway" id="subway" style="width:200px; padding:5px 10px; font-size:1rem" required>
</p>

<p>
    <textarea name="hoodDesc" id="hoodDesc" rows="3" cols="70" placeholder="Neighborhood Description" style="font-size:1rem; padding:5px" required></textarea>
</p>
<br/><br/>
<button style="width:220px; padding:5px 15px; font-weight:bold; font-size:1rem">SAVE NEIGHBORHOOD</button>

<h4 id="server-resp" style="color:#3b87c1">&nbsp;</h4>

</form>

<script>

// the text input fields and textarea
const hoodName = document.getElementById('hoodName')
const borough = document.getElementById('borough')
const subway = document.getElementById('subway')
const hoodDesc = document.getElementById('hoodDesc')

var newHoodID = 0 // for storing primary key ID of new hood
var serverResp = document.getElementById('server-resp')
    
// function runs when user clicks SAVE BLDG btn
function ajaxSaveHood() {
    
  if(borough.value == -1) {
        serverResp.innerHTML = "Please Choose a Borough";
	    return false;
  } else {

    // 1.) concat querystring of variables appended to URL
    let url = "../CMS/add-hood-proc.php?"
    url += "hoodName=" + hoodName.value
    url += "&borough=" + borough.value
    url += "&subway=" + subway.value
    url += "&hoodDesc=" + hoodDesc.value
    
    // 3.) Make an AJAX call, sending vars to named url
    let xhr = new XMLHttpRequest()
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
           newHoodID = xhr.responseText; // the primary key id of new hood
            if(newHoodID != -1) { // if the INSERT INTO query worked
                serverResp.innerHTML = "Congrats! New Neighborhood Saved Successfully"
                setTimeout(clearAllHood, 5000) // in 5 sec, call clearAll
				updateHoodMenu()
            } else { // it IS -1, so INSERT INTO failed
                serverResp.innerHTML = "Sorry! Could not save new neighborhood!"
            }
        }
    }
    xhr.open("GET", url, true)
    xhr.send()
    
    return false // stop form action from reloading page by default
      
  } // end if-else
          
} // function ajaxSaveHood()
    
function clearAllHood() {
    
    // the setTimeout() method takes 2 args: a function to run and how many miliseconds to delay before running it
        
        // clear all text input fields
        hoodName.value = ""
        borough.value = ""
        subway.value = ""
        hoodDesc.value = ""
    
        // clear the server response text
        serverResp.innerHTML = "&nbsp;"
    
} // end clearAll() function
	
function updateHoodMenu() {   
    // get the building menu (select element)
    const hoodMenu = document.getElementById('hoodID')
    
    // add the new building as default first option
    let newOption = '<option value="' + newHoodID + '">' + hoodName.value + '</option>'
    
    hoodMenu.innerHTML =  newOption + hoodMenu.innerHTML
    
} // function updateHoodMenu()
    
</script>

