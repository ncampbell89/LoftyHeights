<?php
    include 'CMSauthenticate.php';
    include "../includes/CMS.php";
	$title = 'Add Apt-Bldg-Hood CMS';
?>

<?php 
	include '../includes/head3.php'; 
    include 'CMSheader.php';
?>

<link rel="stylesheet" href="../css/styles.css">

<main style="min-height:38rem"> 
  <!-- 2 Absolute Position Divs: Add-an-Apt and Add-a-Bldg -->
  <div id="apt"><?php include '../includes/add-apt-ajax.php'; ?></div>
  
  <div id="bldg"><?php include '../includes/add-bldg-ajax.php'; ?></div>
    
  <div id="hood"><?php include '../includes/add-hood-ajax.php'; ?></div>
    
  <!-- apt and bldg divs each need little tabs at top -->
  <div id="apt-tab" onclick="swapZindex()">apartment</div>
  <div id="bldg-tab" onclick="swapZindex()">building</div>
  <div id="hood-tab" onclick="swapZindex()">neighborhood</div>	
</main>

<aside>
    <h3 style="line-height: 24px">Add an apartment, building and/or neighborhood that is now available for our friendly community!</h3>
</aside>

<?php include '../includes/footer.php'; ?>

<script>    
	// grab the two big divs
	const apt = document.getElementById('apt');
	const bldg = document.getElementById('bldg');
	const hood = document.getElementById('hood');

	function swapZindex() {
	  // HINT: event.target is the div that was clicked
	  // when a little div tab is clicked, you want the big div of matching color to go to the top of the stack
	  if(event.target.id == 'apt-tab') {
		 apt.style.zIndex = '2'; // put apt div on top
		 bldg.style.zIndex = '1';
		 hood.style.zIndex = '0';
	  } else if(event.target.id == 'bldg-tab') { // if the bldg-tab was clicked
		 bldg.style.zIndex = '2'; // put bldg div on top
		 apt.style.zIndex = '1';
		 hood.style.zIndex = '0';
	  } else { // it must be the hood tab that was clicked
		 bldg.style.zIndex = '2'; // put bldg div on top
		 apt.style.zIndex = '1';
		 hood.style.zIndex = '3';
	  }       
	} // function swapZindex()

</script>
    
