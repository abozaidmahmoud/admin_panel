<?php

/*manage members page 
    
    you can add ,edit ,delete members.
  
*/

session_start();




// add user in DB

if(isset($_SESSION['usersession'])){
	$pagename='member';
    $userinfo;
 	include "init.php";
 	$action= isset($_GET['action']) ? $_GET['action']:'manage';//get request action 
 	//manage member page
 	if($action=='manage'){
            $query='';
            if(isset($_GET['page'])&& $_GET['page']==='pending'){
                $query="and regstatus=0";
            }
     ?>
 		 <div class="container text-center">
            <h2>Manage Member </h2>
            <div class="table-responsive">
                <table class="table table-bordered main-table">
                    <tr class="main-tr">
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registered Date</td>
                        <td>Control</td>            
                    </tr>
                    <?php //get data from db and put it in table

                       $stat=$con->prepare("select * from users where groubid!=1 $query");
                       $stat->execute();
                       $rows=$stat->fetchAll();

                     foreach($rows as $row){
                        echo "<tr>";
                        echo "<td>". $row['userid'] ."</td>";
                        echo "<td>". $row['username'] ."</td>";
                        echo "<td>". $row['email'] ."</td>";
                        echo "<td>". $row['fullname'] ."</td>";
                        echo "<td>". $row['date'] ."</td>";
                        echo "<td> "; ?>

                        <a href="member.php?action=edit&userid=<?php echo $row['userid']; ?> " class='btn btn-primary'>Edit</a>
                        <a href="member.php?action=delete&userid=<?php echo $row['userid']; ?> " class='btn btn-danger delebut'>Delete</a>
                        <?php

                            if($row['regstatus']==0){
                                echo "<a href='member.php?action=active&userid=$row[userid] 'class='btn btn-info'>"."<i class='fa fa-close'></i>  Active" . "</a>" ;
                            }
                         echo"</td>";
                        echo"</tr>";
                        }
                    ?>
                </table>
            </div>        
            <a href="member.php?action=add" class="btn btn-primary" > <i class="fa fa-plus"></i>Add New Member </a>
         </div>		
 	<?php }

 	  //start add new user
 elseif($action=='add') { ?>
        <!-- start user add from -->
    	<h3 class="text-center h3edit" >Add New Member</h3>
    	<div class="container userform useraddform">
    		<form  action="member.php?action=insert" method="POST">
    			  
    			  <div class="form-group">
    				    <label class="flable" >username</label>
    				    <div class="coninput">
    				    	<input type="text" class="form-control col-sm-8" name="username" autocomplete="off" required >
    					</div>
    			  </div>
    			   <div class="form-group">
    				    <label >Password</label>
    				    <div class="coninput">
    				   		 <input type="password" class="form-control password" name="password" >
    				   		 <i class="eye fa fa-eye fa-lg" required></i>
    					</div>
    			  </div>
    			   <div class="form-group">
    				    <label >email</label>
    				    <div class="coninput">
    				    	<input type="email" class="form-control" name="email" required>
    					</div>
    			  </div>
    			   <div class="form-group">
    				    <label >fullname</label>
    				    <div class="coninput">
    				    <input type="text" class="form-control" name="fullname"  required>
    					</div>
    			  </div>
    			  <button type="submit" class="btn btn-success btn-lg"> Add New Member </button>
    			
    		</form>	
    	</div>     <!-- end user add from -->
        <?php }
// end add new user


//start delete user
    
elseif($action=='delete'){
    echo "<div class='container text-center '>";
        echo"<h2>Delete User </h2>";
        if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
            $statdelete=$con->prepare("delete from users where userid=?");
            $statdelete->execute(array($_GET['userid']));
            if($statdelete->rowCount()>0){
                    $mesg ="<div class='alert alert-success'>".( $statdelete->rowCount()." row deleted"  )."</div>";
                    redirect_to_home($mesg,"back",5);
            }
            else{
                    $mesg= "<div class='alert alert-success'>"."Userid Not Exist"."</div>";
                    redirect_to_home($mesg);
            }

        }
        else{
                    $mesg="<div class='alert alert-danger'> Error In Userid Format </div>";
                    redirect_to_home($mesg);
            }
   echo"</div>";

    }//end action delete
//end delete user

    //start insert new member
elseif ($action=='insert') {
        echo "<div class='container'>";
        	if($_SERVER['REQUEST_METHOD']=='POST'){
            		echo "<h1 class='text-center' style='color:#e74c3c;'>Insert New Member</h1>";
            		$username=$_POST['username'];
            		$password=$_POST['password'];
            		$email=$_POST['email'];
            		$fullname=$_POST['fullname'];
            		$hashpass=sha1($_POST['password']);
            		$formerrors=array();
            		if(empty($username)){
            			$formerrors[]="username cannot be empty";
            		}
            		if(empty($password)){
            			$formerrors[]="password cannot be empty";
            		}
          
          			if(empty($email)){
            			$formerrors[]="email cannot be empty";
            		}
          
          			if(empty($fullname)){
            			$formerrors[]="fullname cannot be empty";
            		}
                     
                    foreach($formerrors as $error){
                    	echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                    if(empty($formerrors)){
                            //check if user exist in DB
                            $chk=check('username','users',$_POST['username'],'');
                            if($chk !=1){ //user not exist in DB
                                $insertstat=$con->prepare("insert into users (username,password,email,fullname,regstatus,date)

                                                         values(:zname,:zpass,:zemail,:zfullname,1,now() ) ");
                                $insertstat->execute(array(
                                    'zname'=>$username,
                                    'zpass'=>$hashpass,
                                    'zemail'=>$email,
                                    'zfullname'=>$fullname
                                ));
                                     //redirect to previous page
                                $mesg= "<div class='alert alert-success'>".$insertstat->rowCount()." row Inserted" ."</div>";
                                redirect_to_home($mesg,'back',4);
                        }
                            else{// user exist in DB
                                    $mesg="<div class='alert alert-danger'>username is exists</div>";
                                    redirect_to_home($mesg,'back');
                                }
                }
        	}

       	    else{ //redirect to home page
       		     $mesg="<div class='alert alert-danger '> sorry you cannot browse this page directly </div>";
                 redirect_to_home($mesg,'back',5);
             	}
       	echo "</div>";
   }
//end insert new member
    
 	//edit user profile
 elseif($action=='edit'){ 
     		if(isset($_GET['userid'])&& is_numeric($_GET['userid'])){
     			//select all row equal userid
         			$queryselect=$con->prepare("select * from users where userid=? ");
         			$queryexc=$queryselect->execute(array($_GET['userid']));
         			$userinfo= $queryselect->fetch();
         			$row=$queryselect->rowCount();
         			if($row>0){?>

            	 			<h3 class="text-center h3edit" >Edit Admin Info</h3>
            				<div class="container userform">
            		  		<form  action="member.php?action=update" method="POST">
            			  
                    			  <div class="form-group">
                        			    <label class="flable" >username</label>
                        			    <div class="coninput">
                        			         <input type="text" class="form-control col-sm-8" name="username" value="<?php echo $userinfo['username'] ?>"   autocomplete="off" required='required' >
                        				</div>
                    			  </div>
                    			  <input type="hidden" name="userid" value="<?php echo $userinfo['userid'] ?>">
                    			  <div class="form-group">
                        			    <label >Password</label>
                        			    <input type="hidden"  name="oldpassword" value="<?php echo $userinfo['password'] ?>" >
                        			    <input type="password" class="form-control" name="newpassword" placeholder="old value is inserted by default" >
                    			  </div>
                    			   <div class="form-group">
                        			    <label >email</label>
                        			    <div class="coninput">
                        			         <input type="email" class="form-control" name="email" value="<?php echo $userinfo['email'] ?>"  required='required'>
                        				</div>
                    			  </div>
                    			   <div class="form-group">
                        			    <label >fullname</label>
                        			    <div class="coninput">
                        			         <input type="text" class="form-control" name="fullname" value="<?php echo $userinfo['fullname'] ?>"  required='required'>
                        				</div>
                    			  </div>
                    			  <button type="submit" class="btn btn-success btn-lg"> Update </button>
            			
            		</form>	
            	</div> 
          <!--end form admin edit--> 	
         			<?php } //end of num of selected row>0

         			else{
         				   $mesg= "<div class='alert alert-danger'> userid not exists</div>";
                           redirect_to_home($mesg);
         			    }

     		}//end of userid is number and exists
     		else{
     			    $mesg= "<div class='alert alert-danger'>Invalid Userid Format</div>";
                    redirect_to_home($mesg);
     		    }
 		
 		}


 		//satrt action update
 elseif($action=="update"){
     			//check if enter update page throw update form or directly
     		echo "<div class='container'>";//print alert for form error
     			if($_SERVER['REQUEST_METHOD']=='POST'){
             			echo "<h2 class='text-center' style='color:#e74c3c;' >Update Member</h2>";
             			$userid=$_POST['userid'];
             			$username=$_POST['username'];
             			$email=$_POST['email'];
             			$fullname=$_POST['fullname'];
             			//password trick is empty put old password else put newpassword
             			$pass='';
             			if(empty ($_POST['newpassword'])){
             				        $pass=$_POST['oldpassword'];
             		    }
             			else{
             				        $pass=sha1( $_POST['newpassword']); 
             			}
                       

                        // start form edit validation
                        
                        $formerrors=array(); //empty array for store errors
                        if(empty($_POST['username'])){
                        	$formerrors[]=  "username cannot be empty";  
                        }
                        if(empty($_POST['email'])){
                        	$formerrors[]="email cannot be empty";
                        }
                        if(empty($_POST['fullname'])){
                        	$formerrors[]="fullname cannot be empty";
                        }

                        foreach($formerrors as $error){ 
                            echo "<div class='alert alert-danger'>"  .$error.   "</div>";
                        }
                       
                        // end form edit validation
                              
                        //if there is no error in form edit update the user
                        if(empty($formerrors)){
                 			$statupdate=$con->prepare("update users set username=?,email=?,fullname=?,password=? where userid=?");
                 			$statupdate->execute(array($username,$email,$fullname,$pass,$userid));
                 			$mesg= "<div class='alert alert-success'>" .($statupdate->rowCount()." row affected") ."</div>" ;
                            redirect_to_home($mesg,'back',5);
                       }//end if we update from useing edit   
              }
                        else{
               	                $mesg= "<div class='alert alert-danger text-center' style='margin-top:35px;font-weight:bold'>" . "Forbidden Access Directly" ."</div>";
                                redirect_to_home($mesg);
                            }

    		echo "</div>";		
 		
 		}//end action update

//start active registeration users
elseif($action=='active'){
 
     echo"<h2>Active User </h2>";
        if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
            $statactive=$con->prepare("update users set regstatus=1 where userid=? ");
            $statactive->execute(array($_GET['userid']));
            if($statactive->rowCount()>0){
                    $mesg ="<div class='alert alert-success'>".( $statactive->rowCount()." row actived"  )."</div>";
                    redirect_to_home($mesg,"back");
            }
            else{
                    $mesg= "<div class='alert alert-success'>"."Userid Not Exist"."</div>";
                    redirect_to_home($mesg);
            }

        }
        else{
                    $mesg="<div class='alert alert-danger'> Error In Userid Format </div>";
                    redirect_to_home($mesg);
            }
   echo"</div>";

}

//end active registeration users

include $tmp."footer.php"; 
}//end of if usersession statement
 





