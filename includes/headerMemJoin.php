<header>
    <nav>        
        <!-- burger btn to toggle nav link view -->
        <button class="btn btn-burger" id="burger-btn"><!-- Font Awesome responsive layout media query hamburger -->
            <i class="fa fa-bars"></i>
        </button>
        
        <!-- nav links -->
        <ul class="nav-ul" id="navUL">
            <li><a href="index.php">Home</a></li>
            <li><a href="memberJoin-Login.php">Join-Login</a></li>
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="blog2.php">Blog</a></li>
            <li><a href="search.php">Search</a></li>
        </ul>
        
        <?php 
            // output Welcome and Logout link. This var was concatenated in authenticate.php
            echo $welcome_msg; 
        ?>
        
    </nav>
    
</header>