<?php

session_start();

if(isset($_SESSION['usersession'])){

	$pagename='Cateogery';
	include"init.php";
	$action=isset($_GET['action'])?$_GET['action']:'manage';
//start manage
	if($action=='manage'){
		echo"<div class='container '>";
			echo"<h2 class='text-center'> Manage Cateogery</h2>";
			$ordering='asc';
			$sort_array=array('asc','desc');
			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
				$ordering=$_GET['sort'];
			}

			$stat=$con->prepare("select * from cateogerys order by ordering $ordering");
			$stat->execute();
			$rows=$stat->fetchAll(); ?>
			<div class="panel panel-default">
				<div class="cateogery-head panel-heading ">
					<i class="fa fa-edit"></i>Manage Cateogeries	
					<div class="option pull-right">
						<span style="color:#00b894"><i class="fa fa-sort"></i>Ordering:</span>[
						<a href="?sort=asc" class=" <?php if($ordering=='asc'){echo 'active'; } ?> ">ASC</a>|
						<a href="?sort=desc" class=" <?php if($ordering=='desc'){echo 'active'; } ?> ">DESC</a>]
                        <span style="color:#00b894"><i class="fa fa-eye"></i> View:</span>[
                        <span class="active" data-view='view'>Full</span>|
                        <span >Classic</span>]
					</div>	
				</div>
				<div class="panel-body cateogery">
					<?php 
						foreach($rows as $row){
							echo"<div class='cateog'>";
								
									echo"<div class='hidden-button'>";
										echo"<a href=?action=edit&cateogeryid=".$row['cateogeryid']." class='btn btn-primary'>" ."<i class='fa fa-edit'></i>"."Edit"."</a>";
										
										echo"<a href=?action=delete&cateogeryid=".$row['cateogeryid']." class='btn btn-danger delebut'>" ."<i class='fa fa-edit'></i>"."Delete"."</a>";

									
								echo"</div>";
								echo "<h2>".$row['name']."</h2>";
                                echo"<div class='full-view'>";
    								if($row['description']==''){echo"<p>"."this cateogery has no description"."</p>";}
    								else{echo "<p>".$row['description']."</p>";}
    								if($row['visiability']==1){ echo "<span class='catspan visible'>"."Hidden" ."</span>"  ;}
    								if($row['allow_comment']==1){ echo"<span class='catspan comment'>"."Comment Disabled"."</span>" ;}
    								if($row['allow_ads']==1){ echo "<span class='catspan ads'>"."Ads Disabled" ."</span>"  ;}
                                echo"</div>";

							echo"</div>";
						}

					?>
				</div>

			</div>
            <a href='cateogery.php?action=add' class='btn btn-primary btn_addcateogery'>Add New Cateogery</a>
		</div>

<?php	}//end manage

// start add cateogery
	elseif($action=='add'){ ?>
		<h3 class="text-center " >Add New Cateogery</h3>
    	<div class="container addcatogery ">
    		<form  action="cateogery.php?action=insert" class="" method="POST">
    			  
    			  <div class="form-group ">
    				    <label class="col-sm-2 control-label" >Name</label>
    				
    				    <div class=" col-sm-10 coninput">
    				    	<input type="text" class="form-control " name="name" autocomplete="off" required placeholder="name of cateogery" >
    					</div>
    			  </div>
    			   <div class="form-group">
    				    <label class="col-sm-2 control-label">Description</label>
    				    <div class="coninput col-sm-10">
    				   		 <input type="text" class="form-control " name="description" placeholder="descripe of cateogery">
    					</div>
    			  </div>
    			   <div class="form-group">
    				    <label class="col-sm-2">Ordering</label>
    				    <div class="coninput col-sm-10">
    				    	<input type="text" class="form-control" name="ordering" placeholder="number to arrange the cateogery" >
    					</div>
    			  </div>
    			   <div class="form-group">
    				    <label class="col-sm-2">Visible</label>
    				    <div class="form-group col-sm-10">
    				    	<input id="vis_yes" type="radio" name="visible" value=0 checked="">
    				    	<label for="vis_yes">Yes</label>
    				    </div>
    				    <div class="form-group col-sm-10 col-sm-offset-2 ">
    				    	<input id="vis_no" type="radio" name="visible" value=1>
    				    	<label for="vis_no">No</label>
    				    </div>
    				    
    			  </div>
    			   <div class="form-group">
    				    <label class="col-sm-2">Allow Commenting</label>
    				    <div class="form-group col-sm-10">
    				    	<input id="com_yes" type="radio" name="comment" value=0 checked="">
    				    	<label for="com_yes">Yes</label>
    				    </div>
    				    <div class="form-group col-sm-10 col-sm-offset-2  ">
    				    	<input id="com_no" type="radio" name="comment" value=1>
    				    	<label for="com_no">No</label>
    				    </div>
    				</div> 
    				 <div class="form-group">
    				    <label class="col-sm-2">Allow Ads</label>
    				    <div class="form-group col-sm-10">
    				    	<input id="ads_yes" type="radio" name="ads" value=0 checked="">
    				    	<label for="ads_yes">Yes</label>
    				    </div>
    				    <div class="form-group col-sm-10 col-sm-offset-2  ">
    				    	<input id="ads_no" type="radio" name="ads" value=1>
    				    	<label for="ads_no">No</label>
    				    </div>
    				</div> 
    				<button type="submit" class="btn btn-info btn-lg">Add Cateogery</button> 
    					
    							     			
    		</form>	
    	</div>     <!-- end user add from -->	
	
    	
	<?php }
// end add cateogery	

//start insert	
	elseif($action=='insert'){
		echo"<div class='container'>";
			if($_SERVER['REQUEST_METHOD']=='POST'){
	 				$name=$_POST['name'];
	 				$description=$_POST['description'];
	 				$ordering=$_POST['ordering'];
	 				$visible=$_POST['visible'];
	 				$comment=$_POST['comment'];
	 				$ads=$_POST['ads'];
	 				//check if item exists in cateogery
	 				$check=check("name","cateogerys",$name,'');
	 				if($check!=1){
	 				try{
		 				$statinsert=$con->prepare("insert into cateogerys (name,description,ordering,visiability,allow_comment,allow_ads) values(?,?,?,?,?,? )");
		 				$statinsert->execute(array($name,$description,$ordering,$visible,$comment,$ads));
		 				$mesg= "<div class='alert alert-success'>". $statinsert->rowCount()." row inserted"."</div>";
		 				redirect_to_home($mesg,'back');
					}
					catch(PDOException $e){
						echo $e->getmessage();
					}
				}
				else{
					$mesg="<div class='alert alert-danger'>". "this cateogery is exist"."</div>";
					redirect_to_home($mesg,'back');
				}
			}

			else{
				$mesg="<div class='alert alert-danger'>"."sorry you cannot browse insert directly"."</div>";
				redirect_to_home($mesg);
				}
		echo"</div>";
	}//end insert
	
//start edit	
	elseif($action=='edit'){ 
            echo"<div class='container'>";
			if(isset($_GET['cateogeryid']) && is_numeric($_GET['cateogeryid'])){
		    $cateogeryid=$_GET['cateogeryid'];
			$stat=$con->prepare("select * from cateogerys where cateogeryid=?");
			$stat->execute(array($cateogeryid));
			$row=$stat->fetch();
            $count=$stat->rowCount();
            if($count>0){// check if id exist in DB
		?>

		<h3 class="text-center " >Edit Cateogery</h3>
    	<div class="container addcatogery ">
    		<form  action="cateogery.php?action=update"  method="POST">
    			  
    			  <div class="form-group ">
    				    <label class="col-sm-2 col-xs-12 control-label" >Name</label>
    				    <div class=" col-sm-10 col-xs-12 coninput">
    				    	<input type="text" class="form-control " name="name" required  value="<?php echo $row['name'] ?>" >
                            <input type="hidden" name="cateogeryid" value="<?php  echo $cateogeryid; ?>" >
    					</div>
    			  </div>
    			   <div class="form-group">
    				    <label class="col-sm-2 col-xs-12 control-label">Description</label>
    				    <div class="coninput col-sm-10 col-xs-12">
    				   		 <input type="text" class="form-control " name="description"  value="<?php echo $row['description'] ?>">
    					</div>
    			  </div>
    			   <div class="form-group">
    				    <label class="col-sm-2 col-xs-12">Ordering</label>
    				    <div class="coninput col-sm-10 col-xs-12">
    				    	<input type="text" class="form-control" name="ordering"  value="<?php echo $row['ordering'] ?>">
    					</div>
    			  </div>
    			   <div class="form-group">
    				    <label class="col-sm-2 col-xs-12">Visible</label>
    				    <div class="form-group col-sm-10 col-xs-12">
    				    	<input id="vis_yes" type="radio" name="visible"  value="0" <?php if($row['visiability']==0){echo "checked";} ?> >
    				    	<label for="vis_yes">Yes</label>
    				    </div>
    				    <div class="form-group col-sm-10 col-xs-12 col-sm-offset-2 ">
    				    	<input id="vis_no" type="radio" name="visible" value="1" <?php if($row['visiability']==1){echo "checked";} ?>>
    				    	<label for="vis_no">No</label>
    				    </div>
    				    
    			  </div>
    			   <div class="form-group">
    				    <label class="col-sm-2 col-xs-12">Allow Commenting</label>
    				    <div class="form-group col-sm-10 col-xs-12">
    				    	<input id="com_yes" type="radio" name="comment"  value="0" <?php if($row['allow_comment']==0){echo "checked";} ?> >
    				    	<label for="com_yes">Yes</label>
    				    </div>
    				    <div class="form-group col-sm-10 col-xs-12 col-sm-offset-2  ">
    				    	<input id="com_no" type="radio" name="comment" value="1" <?php if($row['allow_comment']==1){echo "checked";} ?>>
    				    	<label for="com_no">No</label>
    				    </div>
    				</div> 
    				 <div class="form-group">
    				    <label class="col-sm-2 col-xs-12">Allow Ads</label>
    				    <div class="form-group col-sm-10 col-xs-12">
    				    	<input id="ads_yes" type="radio" name="ads"  value="0" <?php if($row['allow_ads']==0){echo "checked";} ?>>
    				    	<label for="ads_yes">Yes</label>
    				    </div>
    				    <div class="form-group col-sm-10 col-xs-12 col-sm-offset-2  ">
    				    	<input id="ads_no" type="radio" name="ads" value="1" <?php if($row['allow_ads']==1){echo "checked";} ?>>
    				    	<label for="ads_no">No</label>
    				    </div>
    				</div> 
    				<button type="submit" class="cateogeryupdate btn btn-info btn-lg col-sm-2 col-xs-12 col-sm-offset-4">Update Cateogery</button> 
    					
    							     			
    		</form>	
    	</div>     <!-- end user add from -->	
    <?php
        }
        else{
                $mesg= "<div class='alert alert-danger'>ID Not Exists </div>";
                redirect_to_home($mesg,'back');
            }

        	}
 else{
        $mesg= "<div class='alert alert-danger'>Error In ID Format </div>";
        redirect_to_home($mesg,'back');
    }
echo"</div>";
 }//end edit

//start update
	elseif($action=='update'){
        echo"<div class='container'>";
        echo"<h2 class='text-center'>Update Cateogery</h2>";
        if($_SERVER['REQUEST_METHOD']=='POST'){
        $cateogeryid=$_POST['cateogeryid'];
        $name=$_POST['name'];
        $description=$_POST['description'];
        $ordering=$_POST['ordering'];
        $visible=$_POST['visible'];
        $comment=$_POST['comment'];
        $ads=$_POST['ads'];      
        try{
        $statinsert=$con->prepare("update cateogerys set name=?,description=?,ordering=?,visiability=?,allow_comment=?,allow_ads=? where cateogeryid=? ");
        $statinsert->execute(array($name,$description,$ordering,$visible,$comment,$ads,$cateogeryid));
        $count=$statinsert->rowCount();
        $mesg="<div class='alert alert-success'>". $count."row updated</div>";
        redirect_to_home($mesg,'back');
}//end try

        catch(PDOException $e){
            echo $e->getmessage();
        }
	   }
       else{
            $mesg="<div class='alert alert-danger'>You Cannot Browse This Page Directly </div>";
            redirect_to_home($mesg);
       }
     echo"</div>" ; 
	}//end update

// start delete
	elseif($action=='delete'){
     echo"<div class='container'>";
        if(isset($_GET['cateogeryid'])&&is_numeric($_GET['cateogeryid'])){
            $cateogeryid=$_GET['cateogeryid'];
            $check=check("cateogeryid","cateogerys",$cateogeryid,'');
            if($check!=1){
                $mesg="<div class='alert alert-danger'>"."Sorry this ID Not Exists </div>";
                 redirect_to_home($mesg);
                 exit();

            }
            $statdelete=$con->prepare("delete from cateogerys where cateogeryid=?");
            $statdelete->execute(array($cateogeryid));
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

	

 include $tmp."footer.php";
}

else{
	header("location:index.php");
}















