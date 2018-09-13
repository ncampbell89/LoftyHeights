<!-- this comes right after opening of <div id="container"> --><header>
<!-- this file gets included into template.php -->
    <nav>
        
        <!-- search form w mag glass submit btn -->
<!--
        <form method="get" action="search-proc.php">
            <input type="search" name="search" id="search" placeholder="Search">
            <button class="btn"> Font Awesome search magnifying glass icon 
                <i class="fa fa-search"></i>
            </button>
        </form>
-->
        
        <!-- burger btn to toggle nav link view -->
        <button class="btn btn-burger" id="burger-btn"><!-- Font Awesome responsive layout media query hamburger -->
            <i class="fa fa-bars"></i>
        </button>
        
        <!-- nav links -->
        <ul class="nav-ul" id="navUL" name="navUL">
            <li><h1 style="font-family: 'Cinzel', serif; letter-spacing:2px; padding-left:10px; margin:0; color:#000">LH</h1></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="memberJoin-Login.php">Join-Login</a></li>
            <li><a name="profile" href="profile.php">My Profile</a></li>
			
			<li>
				<a id="blog" href="blog.php">Blog</a>
				<a id="blogCMS" style="display:none" href="blogCMS.php">Blog</a>
			</li>
			
            <li><a href="search.php">Search</a></li>
			
			<li>
				<select name="admin" id="admin" style="display:none; font-size:1rem; font-family: 'PT Sans', sans-serif" onchange="goToCMS()">
					<option value="-1">-Admin Tools-</option>
					<option value="add">Add Apt, Bldg, and/or Neighborhood</option>
					<option value="apt">Edit Apartment Details</option>
					<option value="bldg">Edit Building Details</option>
				</select>
			</li>
            <script>
                
                let val = event.target.value;
                if(val == 'add') {
                    document.querySelector(`[value^='add']`).setAttribute('selected', true);
                } else if(val == 'apt') {
                    document.querySelector(`[value^='apt']`).setAttribute('selected', true);
                } else if(val == 'bldg') {
                    document.querySelector(`[value^='bldg']`).setAttribute('selected', true);
                }
                
            </script>
        </ul>
			
<!--			<button style="background-color: #DFD; padding: 5px">GO</button>-->

        
        <?php 
            // output Welcome and Logout link. This var was concatenated in authenticate.php
            echo $welcome_msg;
        ?>
        
    </nav>
    
</header>