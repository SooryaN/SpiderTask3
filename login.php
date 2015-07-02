<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Register</title>
		<link rel="stylesheet" href="css/main.css" type="text/css">
		<link rel="stylesheet" href="css/base.css" type="text/css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function() {

		$("#FormSubmit").click(function (e) {
				e.preventDefault();
								
				$("#FormSubmit").hide(); 
				$("#LoadingImage").show();
				
			 	var myData = {page:'Login',username:$("#username").val(),password:$("#password").val()}; //build a post data structure
				$.post('everything.php', myData, function(returnedData) {
				    $("#responds").html(returnedData);
				    $("#FormSubmit").show(); 
					$("#LoadingImage").hide();
				});
		});
	});
	</script>
	</head>
	<body class="wrapper">
<nav id="menu">
    <ul>
      <li id="back"><h1><i class="fa fa-list"></i>Menu</h1></li>
      <li><a href="index.php"><i class="fa fa-check"></i>Home</a></li>
      <li><a href="login.php"><i class="fa fa-check"></i>Login</a></li>
      <li><a href="registration.php"><i class="fa fa-check"></i>Register</a></li>
      <li><a href="#paragraph4"><i class="fa fa-check"></i>Paragraph 4</a></li>
      <li><a href=""><i class="fa fa-check"></i>Back</a></li>
    </ul>
  </nav>
  <button href="#" class="menu-btn"><i class="fa fa-bars fa-3x"></i></button>
  <script src="navbar.js"></script>
		<div style="width: 500px;margin:auto;margin-top:100px;" id="form">
		
			<div id="title" >
				<h1>Login Here!</h1>
			</div>
			<ol>
				
				<li>
					Username:
					<br>
					<input type="text"  id="username" placeholder="Unique Username"  required/>
					<br>
				</li>
				<li>
					Password:
					<br>
					<input type="password" required placeholder="At least 1 lowercase, 1 uppercase, 1 number, min length 6" name="pass" id="password" autocomplete="off"/>
					<input type="checkbox" style="margin-top:0;" onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"> Show password
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