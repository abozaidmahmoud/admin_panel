<?php
/*check if page has var pagename it print it in title of page 
else print default  */
function printpagename(){

	global $pagename;
	if(isset($pagename)){
		echo $pagename;
	}
	else{
		echo "default";
	}
}

/*redirect to home page if user enter page directly */

function redirect_to_home($mesg,$url=null,$sec=3){
	echo $mesg;
     $page='';
     if($url===null){
     	$url="index.php";
     	$page='Home Page';
     }
     else{
     	 if(isset($_SERVER['HTTP_REFERER'])){
     	 		$url=$_SERVER['HTTP_REFERER'];
     			$page='Previous Page';
     	 }
     	 else{
     	 	$url='index.php';
     	 	$page='Home Page';
     	 }
     
     }
     echo"<div class='alert alert-info'>You Will Be Redirect To $page After $sec seconds. </div>";
     header("refresh:$sec; url=$url");
}


/* check if user or and colums exists in db before insert it*/

function check($select,$table,$value,$query){
	global $con;
	$stat=$con->prepare("select $select from $table where $select=? $query");
	$stat->execute(array($value));
	$count=$stat->rowCount();
	return $count;
}

/*calculate number of rows in specific table and return it*/

function rowcount($items,$table,$query){
	global $con;
	$stat=$con->prepare("select count($items) from $table $query ");
	$stat->execute();	
	return $stat->fetchColumn();

}


/* get latest 5 users,items ,comments from and table */

function getlatest($selector,$table,$columnname,$limit=5){
	global $con;
	try{
   $stat=$con->prepare("select $selector from $table order by $columnname DESC LIMIT $limit ");
   $stat->execute();
   return $stat->fetchAll();
}
catch(PDOException $e){
	echo $e->getmessage();
}


}





