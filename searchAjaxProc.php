<?php 
/* 
Search ajax proc does the same exact search as the regular form (search.php). It also outputs the exact same table, but without the template HTML and without the search form.
*/
    require_once("conn/connApts.php");
    require('includes/searchProc.php');
    include('includes/searchResults.php');
?>