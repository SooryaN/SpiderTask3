<?php
    session_start();
    $rel=substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME'])));
$_SESSION['dir']=$rel;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home</title>
  <link rel="stylesheet" href="<?php echo $rel ?>css/base.css">
  <link rel="stylesheet" href="<?php echo $rel ?>css/1.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
</head>
</head>
<body class="rel">
<nav id="menu">
  <ul>
    <li>
      <h1><i class="fa fa-list"></i> Menu</h1>
    </li>
    <li>
      <a href="<?php echo $rel ?>home"><i class="fa fa-check"></i> Home</a>
    </li>
    <li>
        <a href="<?php echo $rel ?>login"><i class="fa fa-check"></i>Login/Register</a>
      </li>
    
    <li>
      <a href="<?php echo $rel ?>submit"><i class="fa fa-check"></i>Submit Qs</a>
    </li>
      <li> <a href="<?php echo $rel ?>quiz"><i class="fa fa-check"></i> Answer Qs</a> </li>
      <li> <a href="<?php echo $rel ?>user"><i class="fa fa-check"></i> View Users</a> </li>
      <li> <a onclick="function(e){e.preventDefault();this.parents('header').hide();}"><i class="fa fa-check"></i> Exit</a> </li>
    
  </ul>
</nav>
  <button class="menu-btn fa fa-bars">Menu</button>
  <script src="<?php echo $rel ?>navbar.js"></script>
	<div id="wrapper">
    <h1>Quiz Away!</h1>
    <div class="whitebox">
      <a href='<?php echo $rel ?>login.php'><div class="white">
        <h2>Start Now!</h2></a>
      </div>
    </div>

</div>
<p style="width:56%;margin-top:180px;margin-left:22%;font-size:1.5em;background:rgba(255,255,255,0.5);"><b>Hello Again! This is a simple quizzing portal made as part of the Spider Inductions. You can check out the project <a href=https://github.com/SooryaN/SpiderTask3>here</a>.<br> Hope you like it!</b></p>

</body>
</html>