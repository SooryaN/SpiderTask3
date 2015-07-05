<?php
    session_start();
$rel=substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME'])));
$_SESSION['dir']=$rel;    
    
    include("captcha/simple-php-captcha.php");
    
$_SESSION['captcha'] = simple_php_captcha( array(
    'min_length' => 5,
    'max_length' => 7,
    'fonts' => array($_SERVER['DOCUMENT_ROOT'] . '/' .'REG/captcha/fonts/1.ttf',$_SERVER['DOCUMENT_ROOT'] . '/' . 'REG/captcha/fonts/2.ttf'),
    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
    'min_font_size' => 20,
    'max_font_size' => 28,
    'color' => '#666',
    'angle_min' => 0,
    'angle_max' => 10,
    'shadow' => true,
    'shadow_color' => '#fff',
    'shadow_offset_x' => -2,
    'shadow_offset_y' => 1
));
    
    ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">

  <title>Register</title>
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
                
                var myData = {page:'Reg',name:$("#name").val(),username:$("#username").val(),password:$("#password").val(),captcha:$("#captcha").val()}; //build a post data structure
                $.post('everything.php', myData, function(returnedData) {
                    if(returnedData.search('successfully registered.')!=-1)
                    {window.setTimeout(function(){window.location = "http://localhost<?php echo $rel ?>login"}, 1500);}
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
<li><h1>Join the Club!</h1></li>
<li><h1><a href="<?php echo $rel ?>login">Login?</a></h1></li>
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
  <button class="menu-btn fa fa-bars">Menu</button> <script src="<?php echo $rel ?>navbar.js"></script>

  <div id="form">
    <div id="title">
      <h1>Registration Form</h1>
    </div>
      Name:<br>
      <input id="name" placeholder="Enter your name" type="text"><br>

      Username:<br>
      <input id="username" placeholder="Unique Username" type="text"><br>

      Password:<br>
      <input autocomplete="off" id="password" name="pass" pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,})" placeholder="At least 1 lowercase, 1 uppercase, 1 number, min length 6" required="" type="password"> <input onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"  type="checkbox"> Show password<br>
      <br>

      <label for="captcha">Enter the text:</label><br>
        <?php
                                        echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
                                        
                                    ?> <input autocomplete="off" id="captcha" name="captcha" type="text"><br>


        <div id="responds">
        </div>
        <br>
        <input id="FormSubmit" name="submit" type="submit" value="Register"> <img id="LoadingImage" src="images/loading.gif" style="display:none"><br>
        <br>
        <div id="nregister">
      Already Registered? <a href="<?php echo $rel ?>login">Login here!</a>
      </div>
  </div>
</body>
</html>