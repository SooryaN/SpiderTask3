<?php 
session_start();
$rel=substr($_SERVER[ 'SCRIPT_NAME'], 0, strpos($_SERVER[ 'SCRIPT_NAME'],basename($_SERVER[ 'SCRIPT_NAME']))); 
$_SESSION['dir']=$rel;
require_once 'ti.php' ?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="UTF-8">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <link href="<?php echo $rel ?>css/base.css" rel="stylesheet" type="text/css">
        <?php startblock( 'css&title') ?>
        <?php endblock() ?>
        
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        
        <?php startblock( 'script') ?>
        <?php endblock() ?>
    </head>
    
    <body class="rel">
        <header id="page_header">
            <ul>
                <?php startblock( 'header_li') ?>
                <?php endblock() ?>
   				<?php 
				if(isset($_SESSION[ 'username']))
				{
					$name=$_SESSION[ 'username'];
					echo '
					<li>
				    <h1><a href="'.$rel.'logout.php">Logout</a></h1>
				</li>
					<li class="user"><h1>Hi '.$name. '</h1></li>"'; 
				} 

				
				?>                
            </ul>
        </header>
        <nav id="menu">
            <ul>
                <li>
                     <h1><i class="fa fa-list"></i> Menu</h1>

                </li>
                <li> <a href="<?php echo $rel ?>home"><i class="fa fa-check"></i> Home</a>

                </li>
                <li> <a href="<?php echo $rel ?>login"><i class="fa fa-check"></i>Login/Register</a>

                </li>
                <li> <a href="<?php echo $rel ?>submit"><i class="fa fa-check"></i>Submit Qs</a>

                </li>
                <li> <a href="<?php echo $rel ?>quiz"><i class="fa fa-check"></i> Answer Qs</a> 
                </li>
                <li> <a href="<?php echo $rel ?>user"><i class="fa fa-check"></i> View Users</a> 
                </li>
                <li> <a href="<?php echo $rel ?>leaderboard"><i class="fa fa-check"></i>Leaderboard</a> 
                </li>
                <li> <a onclick="function(e){e.preventDefault();this.parents('header').hide();}"><i class="fa fa-check"></i> Exit</a> 
                </li>
            </ul>
        </nav>
        <button class="fa fa-bars  menu-btn ">Menu</button>
        <script src="<?php echo $rel ?>navbar.js"></script>
        <?php startblock( 'main') ?>
        <?php endblock() ?>
    </body>

</html>