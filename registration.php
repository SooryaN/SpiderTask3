<?php 
include 'base.php';
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
<?php startblock( 'css&title') ?>
<title>Register</title>
<link href="<?php echo $rel ?>css/main.css" rel="stylesheet" type="text/css">
<?php endblock() ?>
<?php startblock( 'script') ?>
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
<?php endblock() ?>
<?php startblock( 'header_li') ?>
<li><h1>Join the Club!</h1></li>
<li><h1><a href="<?php echo $rel ?>login">Login?</a></h1></li>
<?php endblock() ?>
<?php startblock( 'main') ?>
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
        <?php endblock() ?>