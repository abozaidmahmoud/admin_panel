
<?php

$tmp='includes/template/'; // template dirctory
$lang='includes/languages/'; // language directory
$css='layout/css/'; // css dirctory   
$js='layout/js/'; //js directory
$func='includes/functions/' ;//function directory


//include important files
include"connect.php ";
include $lang.'english.php'; 
include $func."function.php";
include  $tmp.'header.php';



if(!isset($navbar)){
	include $tmp."navbar.php";
}

?>