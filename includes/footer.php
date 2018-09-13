<footer>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="member-Join-Login.php">Join-Login</a></li>
            <li>
				<a id="blog" href="blog.php">Blog</a>
				<a id="blogCMS" style="display:none" href="blogCMS.php">Blog</a>
			</li>
            <li><a href="privacy.php">Privacy&nbsp;Policy</a></li>
        </ul>
    </nav>
</footer>

</div><!-- close container -->

<script src="js/scripts.js"></script>

<script>
	if(<?= $IDmbr; ?> < 4) {
		const admin = document.getElementById("admin");
		admin.style.display = "block";
	}
	
	if(<?= $IDmbr; ?> > 0) {
		const blog = document.getElementById("blog");
		const blogCMS = document.getElementById("blogCMS");
		blogCMS.style.display = "block";
		blog.style.display = "none";
	}
	
    function goToCMS() {
//        alert(event.target.value);
        let val = event.target.value;
        let myUrl = ""
        if(val == 'add') {
            myUrl = "http://localhost/LoftyHeights/CMS/add-apt-bldg-hood.php";
        } else if(val == 'apt') {
           myUrl = "http://localhost/LoftyHeights/CMS/aptDetails.php";           
        } else if(val == 'bldg') {
            myUrl = "http://localhost/LoftyHeights/CMS/bldgDetails.php";           
        }
        window.location = myUrl + "?choice=" + val
    }
</script>
    
</body>
    
</html>