<?php

$action='';
session_start(); 
include 'init.php';

$action= isset($_GET['action']) ? $_GET['action']:'manage';


if($action == 'manage'){
	echo "you are in manage page";
	
	
}

// start add user in DB
elseif($action=='add'){ ?>
    <!-- start user add form  -->
     <div class="container conaddform">
     	<form class="text-center adduser" action="?action=insert"  method="POST">
     		<div class="form-groub">
     			<label>UserId</label>
     			<input class="form-control col-sm-12 col-md-8" type="text" name="userid">
     		</div>
     		<div class="form-groub">
     			<label>UserName</label>
     			<input class="form-control" type="text" name="username">
     		</div>
     		<div class="form-groub">
     			<label>Password</label>
     			<input class="form-control" type="Password" name="password">
     		</div>
     		<div class="form-groub">
     			<label>Email</label>
     			<input class="form-control" type="email" name="email">
     		</div>
     		<div class="form-groub">
     			<label>FullName</label>
     			<input class="form-control" type="text" name="fullName">
     		</div>
     		<div class="form-groub">
     			<label>GroubId</label>
     			<input class="form-control" type="text" name="groubid">
     		</div>
     		<div class="form-groub">
     			<label>TrustSeller</label>
     			<input class="form-control" type="text" name="trustseller">
     		</div>
     		<div class="form-groub">
     			<label>RegStatus</label>
     			<input class="form-control" type="text" name="regstatus">
     		</div>
     		<input class="btn btn-success btn-lg" type="submit" value="Add User">
     	</form>
     </div>

    <!-- end user add form  --> 
<?php }//end elseif for user add form

//insert new user in DB
  elseif($action='insert'){
     if($_SERVER['REQUEST_METHOD']=='POST'){
          $que=$con->prepare("select * from users");
          $que->execute();
          $fetch=$que->fetch();
          if($_POST['username'] != $fetch['username']){
          try{
          $insertstat=$con->prepare("insert into users values(?,?,?,?,?,?,?,?)");
          $insertstat->execute(array($_POST['userid'],$_POST['username'],sha1($_POST['password']),$_POST['email'],$_POST['fullName'],$_POST['groubid'],$_POST['trustseller'],$_POST['regstatus'],));
          echo $insertstat->rowCount();
     }
     catch(PDOException $e){
          echo $e->getmessage();
     }
     }
     else{
          echo "username exists";
     }
     }
     else{
          echo "denied access for this page";
     }
  }


else{
	echo "error page ";
}

include $tmp."footer.php";