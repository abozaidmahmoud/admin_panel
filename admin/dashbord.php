
<?php
session_start();


if(isset($_SESSION['usersession'])){
    $pagename='dashbord';
	include "init.php";
	/*start dashbord*/
	?>

	<h2 class="text-center">Dashbord</h2>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
					<div class="statist member ">
						<i class="fa fa-users"></i>
						<div class="info">
							Total Members
							<span>
								<a href="member.php">
								<?php
								$query="where groubid!=1";
								 echo rowcount('userid','users',$query); 
								?>	
								</a>		
							</span>	
						</div>				
					</div>					
			</div>
			<div class="col-md-3">
				<div class="statist pending">
					<i class="fa fa-user-plus"></i>
					<div class="info">
							Pending Members
							<span>   
							<a href="member.php?action=manage&page=pending">
								<?php 
                                 $query="and groubid!=1";
								echo check("regstatus","users",0,$query); ?>				
							 </a>
							 </span>	
					</div>					
				</div>			
			</div>
			<div class="col-md-3">
				<div class="statist items">
					<i class="fa fa-tag"></i>
					<div class="info">
						Total Items
						<a href="item.php"><span><?php echo (rowcount('item_id','items','')); ?> </span>	</a>

					</div>				
				</div>			
			</div>
			<div class="col-md-3">
				<div class="statist comments">
					<i class="fa fa-comments"></i>
					<div class="info">
						Total comments
						<span>0</span>	

					</div>				
				</div>			
			</div>			
		</div>
	</div>
	
<!-- start latest registered users -->
	<div class="container">
		<div class="row">
			<div class="col-md-6 latest">
				<?php 
				    $usernum=4; //num of latest users
					$getlatestusers=getlatest("*","users","userid",$usernum);// call fun to get users

				?>				
					<div class="panel">
						<div class="panel-heading">
							<i class="fa fa-users"></i>Latest <?php echo $usernum; ?> Registered Users
							<span class="plus-toggle pull-right">
							<i class="fa fa-plus  fa-lg "></i>
							<span>
						</div>
						<div class="panel-body">
							<?php 
							echo"<ul class='latest_ul list-unstyled'>"; 
							foreach($getlatestusers as $user){

								echo"<li>";
									echo $user['username'];
									echo "<a href='member.php?action=edit&userid=".$user['userid']."' >";
											echo"<span class='btn btn-primary pull-right'>";
												echo"<i class='fa fa-edit'>Edit  </i>";
											echo"</span>";
									echo "</a>";
									if($user['regstatus']==0){
										echo "<a href='member.php?action=active&userid=".$user['userid']."' >";
											echo"<span class='btn btn-info pull-right'>";
												echo"<i class='fa fa-check'>Active  </i>";
											echo"</span>";
									echo "</a>";

									}
								echo"</li>";
							}
							echo"</ul>";
							?>
						</div>
					</div>										
			</div>	
			<!-- end latest registered users -->
			<!-- start latest registered items -->
			<div class="col-md-6 latest">	
			<?php 
				$itemnum=5;
				$getlatestitems =getlatest("*","items","item_id",$itemnum);
			?>			
					<div class="panel">
						<div class="panel-heading">
							<i class="fa fa-tag"></i>Latest <?php echo $itemnum;?> Added Items 
							<span class="plus-toggle pull-right">
							<i class="fa fa-plus  fa-lg "></i>
							<span>
						</div>
						<div class="panel-body">
								<?php
								echo"<ul class='list-unstyled list_item'>";
									foreach($getlatestitems as $item){
										
											echo"<li>";
												echo $item['name'];
												echo "<a href='item.php?action=edit&itemid=".$item['item_id']."' >";
													echo"<span class='btn btn-primary pull-right'>";
														echo"<i class='fa fa-edit'>Edit  </i>";
													echo"</span>";
												echo "</a>";

											if($item['approve']==0){
												echo"<a href='item.php?action=approve&itemid=".$item['item_id']."' >";
													echo"<span class='btn btn-info pull-right'>";
														echo"<i class='fa fa-check'></i>"."Approve";
													echo"</span>";
												echo"</a>";
											}
																						
											echo"</li>";
										
									}
										echo"</ul>";

								?>
					</div>
				</div>										
			</div>	
		</div>		
	</div>
<!-- end latest registered items -->


	<?php
	/*end dashbord*/

include $tmp."footer.php";	
}

else{

		header("location:index.php");

	}

