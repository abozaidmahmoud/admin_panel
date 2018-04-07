<?php
	session_start();
	if(isset($_SESSION['usersession'])){
		$pagename='item';
		include "init.php";
		$action=isset($_GET['action']) ? $_GET['action']:'manage';
		//start manage
		if($action=='manage'){ ?>
	
 		 <div class="container text-center">
            <h2>Manage Items </h2>
            <div class="table-responsive">
                <table class="table table-bordered main-table">
                    <tr class="main-tr">
                        <td># Item-Id</td>
                        <td>Item Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Date</td>
                        <td>Cateogery</td>
                        <td>Username</td>
                        <td>Controll</td>     
                    </tr>
                    <?php //get data from db and put it in table

                       $stat=$con->prepare("select items.*,
                       							   cateogerys.name as cateogery_name,
                       							   users.username from items 
                       							   inner join cateogerys on
                       							   cateogerys.cateogeryid=items.cateogery_id
                       							   inner join users on
                       							   users.userid=items.member_id
                       					  ");
                       $stat->execute();
                       $items=$stat->fetchAll();
                     foreach($items as $item){
                        echo "<tr>";
                        echo "<td>". $item['item_id'] ."</td>";
                        echo "<td>". $item['name'] ."</td>";
                        echo "<td>". $item['description'] ."</td>";
                        echo "<td>". $item['price'] ."</td>";
                        echo "<td>". $item['date'] ."</td>";
                         echo "<td>". $item['cateogery_name']."</td>";
                          echo "<td>". $item['username'] ."</td>";
                         ?>
                         <td>
                        <a href="item.php?action=edit&itemid=<?php echo $item['item_id']; ?> " class='btn btn-primary edititem'>Edit</a>
                        <a href="item.php?action=delete&itemid=<?php echo $item['item_id']; ?> " class='btn btn-danger delebut'>Delete</a>
                        <?php
                        	if($item['approve']==0){
                        		echo "<a href='item.php?action=approve&itemid=".$item['item_id'] ."' >";
                        		echo"<span class='btn btn-info'>"."<i class='fa fa-check'></i>"."Approve"  ."</span>";
                        		echo"</a>";
                        	}
                         echo"</td>";
                        echo"</tr>";
                        }
                    ?>
                </table>
            </div>        
            <a href="item.php?action=add" class="btn btn-primary" > <i class="fa fa-plus"></i>Add New Item </a>
         </div>		
 	<?php }//end manage

		elseif($action=='add'){ ?>

			<h2 class="text-center">Add New Item</h2>
			<div class="container additem">
				<form class="add-item" action="?action=insert" method="POST">
					<div class="form-group">
						<label class="col-sm-2">Name</label>
						<div class="col-sm-10 coninput">
							<input class="form-control" type="text" name="name" placeholder="enter item name"    autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Description</label>
						<div class="col-sm-10 coninput">
							<input class="form-control" type="text" name="description" placeholder="enter item description" autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Price</label>
						<div class="col-sm-10 coninput">
							<input class="form-control" type="text" name="price" placeholder="enter price of item" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Made In</label>
						<div class="col-sm-10 coninput">
							<input class="form-control" type="text" name="country" placeholder="enter country mading" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Status</label>
						<div class="col-sm-10 coninput">
							<select class="" name="status" required>
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Used</option>
								<option value="4">Old</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Member</label>
						<div class="col-sm-10 coninput">
							<select class="" name="member" required>
								<option value="0">...</option>
								<?php 
									$stat=$con->prepare("select * from users");
									$stat->execute();
									$users=$stat->fetchAll();
									foreach($users as $user){
										echo"<option value=' ".$user['userid'] ."'> ".$user['username']." </option>";
									}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2">Cateogery</label>
						<div class="col-sm-10 coninput">
							<select class="" name="cateogery" required>
								<option value="0">...</option>
								<?php 
									$stat=$con->prepare("select * from cateogerys");
									$stat->execute();
									$cates=$stat->fetchAll();
									foreach($cates as $cate){
										echo"<option value=' ".$cate['cateogeryid'] ."'> ".$cate['name']." </option>";
									}
								?>
							</select>
						</div>
					</div>	
					<button class="btn btn-primary col-sm-1 col-sm-offset-4 btn_additem">Add Item</button>
				</form>
			</div>
			
		<?php }

		//start edit
		elseif($action=='edit'){ 
			echo"<div class='container '>";
				if(isset($_GET['itemid'])&&is_numeric($_GET['itemid'])){
				try{
					$stat=$con->prepare("select * from items where item_id=?");
					$stat->execute(array($_GET['itemid']));
					$row=$stat->fetch();
					$count=$stat->rowCount();
				}
				catch(PDOException $e){
								echo $e->getmessage();
					}
					if($count>0){
			?>	
			<h2 class="text-center">Edit Item</h2>
			<div class="container additem">
				<form class="edit-item" action="item.php?action=update" method="POST">
					<div class="form-group">
						<label class="col-sm-2">Name</label>
						<div class="col-sm-10 coninput">
							<input class="form-control" type="text" name="name" value="<?php echo $row['name'] ?> " required>
							<input type="hidden" name="item_id" value="<?php echo $_GET['itemid'] ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Description</label>
						<div class="col-sm-10 coninput">
							<input class="form-control" type="text" name="description" value="<?php echo $row['description'] ?> ">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Price</label>
						<div class="col-sm-10 coninput">
							<input class="form-control" type="text" name="price" value="<?php echo $row['price'] ?> " required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Made In</label>
						<div class="col-sm-10 coninput">
							<input class="form-control" type="text" name="country" value="<?php echo $row['country_made'] ?> ">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Status</label>
						<div class="col-sm-10 coninput">
							<select class="" name="status" required>
								<option value="0" >...</option>
								<option value="1" <?php if($row['status']==1) {echo 'selected'; } ?> >New</option>
								<option value="2" <?php if($row['status']==2) {echo 'selected'; } ?>>Like New</option>
								<option value="3" <?php if($row['status']==3) {echo 'selected'; } ?>>Used</option>
								<option value="4" <?php if($row['status']==4) {echo 'selected'; } ?>>Old</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2">Member</label>
						<div class="col-sm-10 coninput">
							<select class="" name="member" required>				
								<?php 
									$stat=$con->prepare("select * from users");
									$stat->execute();
									$users=$stat->fetchAll();
									foreach($users as $user){ 
										echo "<option value='". $user['userid']."'";
											if($user['userid']==$row['member_id']){echo 'selected';}
										echo ">".$user['username']."</option>";
									 }
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2">Cateogery</label>
						<div class="col-sm-10 coninput">
							<select class="" name="cateogery" required>
								<?php 
									$stat=$con->prepare("select * from cateogerys");
									$stat->execute();
									$cates=$stat->fetchAll();
									foreach($cates as $cate){
										echo "<option value='".$cate['cateogeryid'] ."' ";
										if($row['cateogery_id']==$cate['cateogeryid']){echo 'selected';}
										echo">".$cate['name']."</option>";	

									}
								?>
							</select>
						</div>
					</div>	
					<button class="btn btn-primary col-sm-1 col-sm-offset-4 btn_additem">Update Item</button>
				</form>
			</div>
		<?php }
			else{
				$mesg="<div class='alert alert-danger'>"."Item_ID Not Exists"."</div>";
				redirect_to_home($mesg);
			}
			
			}//end check item_id is_numeric
		else{
				$mesg="<div class='alert alert-danger'>"."error in Item_ID "."</div>";	
				redirect_to_home($mesg);
			}
		echo"</div>";	
		}//end edit

		//start update
		elseif($action=='update'){
			echo"<div class='container text-center'>";
				if($_SERVER['REQUEST_METHOD']=='POST'){
					echo"<h2>"."Update Item"."<h2>";
					//get values from form
					$name=$_POST['name'];
					$description=$_POST['description'];
					$price=$_POST['price'];
					$country=$_POST['country'];
					$status=$_POST['status'];
					$username=$_POST['member'];
					$cateogery=$_POST['cateogery'];
					$itemid=$_POST['item_id'];

					$errorform=array();
					if(empty($name)){
						$errorform[]="item name cannnot be empty";
					}
					if(empty($price)){
						$errorform[]="item price cannnot be empty";
					}
					if($status==0){
						$errorform[]="you must choose the status";
					}
					if(empty($country)){
						$errorform[]="you must choose the country_made";
					}
					if($username==0){
						$errorform[]="you must choose the member";
					}
					if($cateogery==0){
						$errorform[]="you must choose the cateogery";
					}
					
					foreach($errorform as $error){
						$mesg="<div class='alert alert-danger'>".$error ."</div>";
						redirect_to_home($mesg,'back');
					}

					if(empty($errorform)){
					$statupdate=$con->prepare("update items 
						set name=:zname,description=:zdescription,
						price=:zprice,country_made=:zcountry,status=:zstatus,
						member_id=:zmember,cateogery_id=:zcateogery
						where item_id=:zid
						");

					$statupdate->execute(array(
						'zname'=>$name,
						'zdescription'=>$description,
						'zprice'=>$price,
						'zcountry'=>$country,
						'zstatus'=>$status,
						'zmember'=>$username,
						'zcateogery'=>$cateogery,
						'zid'=>$itemid
					));

					$mesg="<div class='alert alert-success'>".$statupdate->rowCount()." row Updated</div>";
					redirect_to_home($mesg,'back');
				}
				}//end request method
			echo"</div>";	
		}//end update

		//start insert
		elseif($action=='insert'){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				echo"<div class='container'>";
				echo"<h2 class='text-center'>insert page </h2>";
				$name=$_POST['name'];
				$description=$_POST['description'];
				$price=$_POST['price'];
				$country=$_POST['country'];
				$status=$_POST['status'];
				$member=$_POST['member'];
				$cateogery=$_POST['cateogery'];				
				$errorform=array();
				if(empty($name)){
					$errorform[]="item name cannnot be empty";
				}
				if(empty($price)){
					$errorform[]="item price cannnot be empty";
				}
				if($status==0){
					$errorform[]="you must choose the status";
				}
				if($member==0){
					$errorform[]="you must choose the member";
				}
				if($cateogery==0){
					$errorform[]="you must choose the cateogery";
				}
				
				foreach($errorform as $error){
					echo"<div class='alert alert-danger'>".$error ."</div>";
				}
				if(empty($errorform)){
				try{
				$statinsert=$con->prepare("insert into items (name,description,price,country_made,status,date,member_id,cateogery_id,approve) value(?,?,?,?,?,now(),?,?,?)");
				$statinsert->execute(array($name,$description,$price,$country,$status,$member,$cateogery,1));
				$count=$statinsert->rowCount();
				$mesg="<div class='alert alert-success'>". $count." row inserted"."</div>";
				 redirect_to_home($mesg,'back');
				
			}//end try
			catch(PDOException $e){
				echo $e->getmessage();
			}
			}
			else{
				 redirect_to_home('','back');
			}	
			
			}
			else{
				$mesg="<div class='alert alert-danger'>"."you cannnot browse this page directly"."</div>";
				 redirect_to_home($mesg);
			}
			echo"</div>";
		}//end insert

		// start delete
	elseif($action=='delete'){
     echo"<div class='container'>";
     echo"<h2 class='text-center'>Delete Item</h2>";
        if(isset($_GET['itemid'])&&is_numeric($_GET['itemid'])){
            $itemid=$_GET['itemid'];
            $check=check("item_id","items",$itemid,'');
            if($check!=1){
                $mesg="<div class='alert alert-danger'>"."Sorry this ID Not Exists </div>";
                 redirect_to_home($mesg);
                 exit();

            }
            $statdelete=$con->prepare("delete from items where item_id=?");
            $statdelete->execute(array($itemid));
            $count=$statdelete->rowCount();
            $mesg="<div class='alert alert-success'>".$count." Row Deleted </div>";
            redirect_to_home($mesg,'BACK');
           

        }
        else{
             $mesg="<div class='alert alert-danger'>"."Sorry You Cannot Browse This Page Directly</div>";
            redirect_to_home($mesg);
        }
		

    echo"</div>";
	}//end delete

		//start approve
		elseif($action=='approve'){
			echo"<div class='container'>";
			echo"<h2 class='text-center'>"."Approve Item </h2>";
					if(isset($_GET['itemid'])&&is_numeric($_GET['itemid'])){
						$itemid=$_GET['itemid'];
						try{
						$stat=$con->prepare("update items set approve=? where item_id=? ");
						$stat->execute(array('1',$itemid));
						$count=$stat->rowCount();
						if($count>0){
							$mesg="<div class='alert alert-success'>".$count." Row Approved</div>";
							redirect_to_home($mesg,'back');
						}
						else{
							$mesg="<div class='alert alert-danger'>"."ID Not Exists IN DB</div>";
							redirect_to_home($mesg);
						}
						}
						catch(PDOException $e){
						echo $e->getmessage();
						}
					}
					else{
						$mesg="<div class='alert alert-danger'>"." Error IN Item ID Format </div>";
						redirect_to_home($mesg);
					}
		   echo"</div>";
		}//end approve


		else{
			header("location:item.php");
		}

	include $tmp."footer.php";
	}

	else{
		header("location:index.php");
	}