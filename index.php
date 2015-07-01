<?php
	session_start();
	$_SESSION = array();
	
	include("simple-php-captcha.php");
	
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
		<link rel="stylesheet" href="main.css" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function() {

		$("#FormSubmit").click(function (e) {
				e.preventDefault();
								
				$("#FormSubmit").hide(); //hide submit button
				$("#LoadingImage").show(); //show loading image
				
			 	var myData = {name:$("#name").val(),username:$("#username").val(),password:$("#password").val(),captcha:$("#captcha").val()}; //build a post data structure
				$.post('register.php', myData, function(returnedData) {
				    // do something here with the returnedData
				    $("#responds").html(returnedData);
				    $("#FormSubmit").show(); //hide submit button
					$("#LoadingImage").hide(); //show loading image
				});
		});
	});
	</script>
	</head>
	<body>
		<div>
		
			<div id="title">
				<h1>Registration Form </h1>
			</div>
			<ol>
				<li>
					Name:
					<br>
					<input type="text" id="name" placeholder="Enter your name" required/>
					<br>
				</li>
				<li>
					Username:
					<br>
					<input type="text"  id="username" placeholder="Unique Username"  required/>
					<br>
				</li>
				<li>
					Password:
					<br>
					<input type="password" pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,})" required placeholder="At least 1 lowercase, 1 uppercase, 1 number, min length 6" name="pass" id="password" autocomplete="off"/>
					<input type="checkbox" style="margin-top:0;" onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"> Show password
					<br>
				</li>
				<br>
				<li>
					<label for="captcha">Enter the text:</label>
					<br>
					<?php
						echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
						
					?>
					<input type="text" id="captcha" name="captcha" autocomplete="off" required/>

					<br>
				</li>
				<div id="responds"></div>
				<br>
				<input type="submit" value="Register" id="FormSubmit" name="submit">
				<img src="images/loading.gif" id="LoadingImage" style="display:none" />
				<br><br>
			</ol>
		</div>
	</body>
</html>