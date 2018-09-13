 <table width="500px" border="0px" cellpadding="5px" align="center">

    <tr>
        <td colspan="2" align="center">
            <h2>Add-an-Apt CMS</h2>
        </td>
    </tr>

    <tr>
        <td>
            Bedrooms:  
            <select name="bdrms" id="bdrms">
                <option value="-1">Please Choose</option>
                <option value="0">Studio</option>
                <option value="1">1 Bedroom</option>
                <option value="2">2 Bedrooms</option>
                <option value="3">3 Bedrooms</option>
            </select>
        </td>
        <td>
           Baths: 
            <select name="baths" id="baths">
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
            <select name="bldgID" id="bldgID">
                <option value="-1">Please Choose</option>
                 
                <!-- PHP while loop to output buildings as options -->
                
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

            <button onclick="addApt()">
                ADD NEW APARTMENT
            </button> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 

        </td>
    </tr>

 </table>