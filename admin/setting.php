<?php
session_start();
include "init.php";
include $tmp."footer.php";
?>



<div class="container">
	<button style="float: right;" class="btn btn-success" ><a href="page.php?action=add"> Add User</a></button>
	<button style="float: right;" class="btn btn-danger"><a href="member.php?action=delete"> Delete User</a></button>
	<button style="float: right;" class="btn btn-info"><a href="member.php?action=edit"> Update User</a></button>


</div>