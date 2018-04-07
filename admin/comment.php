<?php
/*manage comment page ,delete,edit,update comments */

session_start();
if(isset($_SESSION['usersession'])){
   $pagename='comment';
   include"init.php";
   $action=isset($_GET['action'])?$_GET['action']:'manage';
   if($action=='manage'){ ?>
        <div class="container text-center">
            <h2>Manage Comment </h2>
            <div class="table-responsive">
                <table class="table table-bordered main-table">
                    <tr class="main-tr">
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Item Name </td>
                        <td>Username</td>
                        <td>Date</td>
                        <td>Control</td>            
                    </tr>
                    <?php //get data from db and put it in table

                       $stat=$con->prepare("select comments.*,items.name,users.username
                        from comments 
                        inner join items on items.item_id=comments.item_id
                        inner join users on users.userid=comments.user_id
                        ");
                       $stat->execute();
                       $rows=$stat->fetchAll();
                     foreach($rows as $row){
                        echo "<tr>";
                        echo "<td>". $row['comment_id'] ."</td>";
                        echo "<td>". $row['comment'] ."</td>";
                        echo "<td>". $row['name'] ."</td>";
                        echo "<td>". $row['username'] ."</td>";
                        echo "<td>". $row['date'] ."</td>";
                        echo "<td> "; ?>

                        <a href="comment.php?action=edit&commentid=<?php echo $row['comment_id']; ?> " class='btn btn-primary'>Edit</a>
                        <a href="comment.php?action=delete&commentid=<?php echo $row['comment_id']; ?> " class='btn btn-danger delebut'>Delete</a>
                        <?php  
                            if($row['status']==0){
                                echo"<a href='comment.php?action=approve&commentid=".$row['comment_id'] ."' >";
                              echo "<span class='btn btn-info'>"."Approve"."</span>";
                                echo"</a>";
                            }
                        ?>
                         </td>
                        </tr>
                      <?php  }
               
               echo "</table>";
           echo" </div>";        

 }//end manage action

//start actio delete
 elseif($action=='delete'){
    echo"<div class='container'>";
    echo"<h2 class='text-center'>Delete Comment</h2>";
    if(isset($_GET['commentid'])&&is_numeric($_GET['commentid'])){
        $statdelete=$con->prepare("delete from comments where comment_id=?");
        $statdelete->execute(array($_GET['commentid']));
        $count=$statdelete->rowCount();
        if($count>0){
            $mesg="<div class='alert alert-success'>".$count." Row Deleted </div>";
            redirect_to_home($mesg,'back');
        }
        else{
            $mesg="<div class='alert alert-danger'>"." CommentID Not Exists </div>";
            redirect_to_home($mesg);
        }
    }
    else{
         $mesg="<div class='alert alert-danger'>"." Error In CommentID Format</div>";
        redirect_to_home($mesg);
    }


 }//end action delete

 //start action approve
 elseif($action=='approve'){
    echo"<div class='container'>";
    echo"<h2 class='text-center'>"."Approve Comment"."</h2>";
    if(isset($_GET['commentid'])&&is_numeric($_GET['commentid'])){
        $stat=$con->prepare("update comments set status=1 where comment_id=?");
        $stat->execute(array($_GET['commentid']));
        $count=$stat->rowCount();
        if($count>0){
             $mesg="<div class='alert alert-success'>".$count ." Row Approved</div>";
             redirect_to_home($mesg,'back');
        } 
        else{
                $mesg="<div class='alert alert-danger'>"."  CommentID Not Exists</div>";
                redirect_to_home($mesg);   
        }

    }
    else{
         $mesg="<div class='alert alert-danger'>"." Error In CommentID Format</div>";
        redirect_to_home($mesg);
    }
    echo"</div>";
 }//end action approve



}//end isset(usersession)