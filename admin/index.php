 
 <?php 
session_start();
if(isset($_SESSION['usersession'])){
	header('location:dashbord.php');
}
 $navbar='';
$pagename='login';
 include 'init.php';
 

if($_SERVER['REQUEST_METHOD']=='POST'){
	$username=$_POST['user'];  
	$password=$_POST['password']; 
	$hashpass=sha1($password);
	 
	//check if user Exist in DB
	$stmt=$con->prepare("select userid, username ,password from users where username=? and password=? and groubid=1 limit 1 ");
	$stmt->execute(array($username,$hashpass));
	$row=$stmt->fetch();

	$count=$stmt->rowCount();
	
	//check if user exist in DB
	if($count>0){
		$_SESSION['usersession']=$username; //register session username
		$_SESSION['id']=$row['userid']; //register session userid
		header("location:dashbord.php");// redirect to dashbord page of admin
		print_r($row);
	}
}

include $tmp."footer.php";
?>

<!-- start admin login from -->
<form class="login" action="<?php echo($_SERVER['PHP_SELF']) ?> "  method="post">
	<h4 class="text-center">Admin Login</h4>
	<input class="form-control" type="text" name="user" placeholder="user name">
	<input class="form-control" type="password" name="password" placeholder=" password">
	<input class="btn btn-danger btn-block" type="submit" value="Login">

</form>

<!-- end admin login from -->






 
  




