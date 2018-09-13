<header>
    <nav> 
        <!-- burger btn to toggle nav link view -->
        <button class="btn btn-burger" id="burger-btn">
            <i class="fa fa-bars"></i>
        </button>
        
        <!-- nav links -->
        <ul class="nav-ul" id="navUL" name="navUL">
            <li>
                <h1 style="font-family: 'Cinzel', serif; letter-spacing:2px; padding-left:10px; color:#000; text-transform:uppercase; margin:0">Welcome to Lofty Heights</h1>
            </li>
            
            <ul id="links" name="links" style="position:relative; left:59%">
                <li><a href="memberJoin-Login.php">Join-Login</a></li>
                <li><a name="profile" href="profile.php">My Profile</a></li>

                <li>
                    <a id="blog" href="blog.php">Blog</a>
                    <a id="blogCMS" style="display:none" href="blogCMS.php">Blog</a>
                </li>

                <li><a href="search.php">Search</a></li>
            </ul>
        </ul>
			
<!--			<button style="background-color: #DFD; padding: 5px">GO</button>-->

        
        <?php 
            // output Welcome and Logout link. This var was concatenated in authenticate.php
            echo $welcome_msg;
        ?>
        
    </nav>
    
</header>
