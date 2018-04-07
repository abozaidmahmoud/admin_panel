<nav class="navbar navbar-inverse" role="navigation">
  <div class="container">
   
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#startnav">
       <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>

      </button>
      <a class="navbar-brand" href="dashbord.php"><?php echo lang('admin'); ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="startnav">
      <ul class="nav navbar-nav">
        <li class=""><a href="cateogery.php"><?php echo lang('cateogery'); ?></a></li>
        <li class=""><a href="item.php"><?php echo lang('item'); ?></a></li>
        <li class=""><a href="member.php"><?php echo lang('member'); ?></a></li>
        <li class=""><a href="comment.php"><?php echo lang('comment'); ?></a></li>
        <li class=""><a href="#"><?php echo lang('statistics'); ?></a></li>
        <li class=""><a href="#"><?php echo lang('logs'); ?></a></li>
      </ul>
    
      <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
           <?php   echo $_SESSION['usersession'] ?> 
           <span class="caret"></span>
         </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="member.php?action=edit&userid=<?php echo $_SESSION['id'] ?> "> <?php echo lang('edit profile'); ?></a></li>
            <li><a href="setting.php"><?php echo lang('setting'); ?></a></li>
            <li><a href="logout.php"><?php echo lang('log out'); ?></a></li>
           
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
