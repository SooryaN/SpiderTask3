<?php
    session_start();
    $rel=substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME'])));
$_SESSION['dir']=$rel;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">

  <title>Login</title>
  <link href="<?php echo $rel ?>css/main.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $rel ?>css/base.css" rel="stylesheet" type="text/css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
  <script type="text/javascript">
$(document).ready(function() {

        $("#FormSubmit").click(function (e) {
                e.preventDefault();
                                
                $("#FormSubmit").hide(); 
                $("#LoadingImage").show();
                
                var myData = {page:'Login',username:$("#username").val(),password:$("#password").val()}; //build a post data structure
                $.post('everything.php', myData, function(returnedData) {
                  if(returnedData.search('Successful')!=-1)
                    {window.setTimeout(function(){window.location = "http://localhost<?php echo $rel ?>user/"+$("#username").val()}, 1500);}
                    $("#responds").html(returnedData);
                    $("#FormSubmit").show(); 
                    $("#LoadingImage").hide();
                });
        });
    });
  </script>
</head>

<body class="rel">
<header id="page_header">
<ul>
<li><h1>Welcome Back!</h1></li>
<li><h1><a href="<?php echo $rel ?>register">Register?</a></h1></li>
</ul></header>
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
  <button class="fa fa-bars  menu-btn " >Menu</button> <script src="<?php echo $rel ?>navbar.js"></script>

  <div id="form" >
    <div id="title">
      <h1>Login Here!</h1>
    </div>

      Username:<br>
      <input id="username" placeholder="Unique Username" type="text"><br>


      Password:<br>
        <input autocomplete="off" id="password" name="pass" placeholder="Password goes here" required="" type="password"> <input onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"  type="checkbox"> Show password<br>


        <div id="responds">
        </div>
        <br>
        <input id="FormSubmit" name="submit" type="submit" value="Login"> <img id="LoadingImage" src="images/loading.gif" style="display:none"><br>
        <br>
      <div id="nregister">
      Not Registered yet? <a href="<?php echo $rel ?>register">Join now!</a>
      </div>
  </div>
</body>
</html>