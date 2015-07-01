<?php 
session_start();
include_once("config.php");
if($_POST['page']=='Reg')
{
	$uname=$_POST['username'];
	$name=$_POST['name'];
	$pass=$_POST['password'];
	$captcha=$_POST['captcha'];
	
	//Basic Form Validation
	if(!(strlen($name)>0))
	{
		echo "Please enter a name";
		exit;
	}
	else if(!(strlen($uname)>0))
	{
		echo "Please enter a username";
		exit;
	}
	else if(!(strlen($pass)>0))
	{
		echo "Password field empty";
		exit;
	}
	
	else if($captcha!=$_SESSION['captcha']['code']) 
	{
		echo "Oops! Captcha Error";
		exit;
	}
	$query = ("SELECT Username FROM Userdata WHERE Username='$uname';");
	$q=mysqli_query($mysqli,$query);
	if($q)
	{
	if (mysqli_num_rows($q)>0)
		{
			echo $uname." is already registered.<a href='login.php'>Login?</a>";
 			exit;
	}}
	$pwd = sha1($pass);
	$sql = "INSERT INTO Userdata (Username,Name,Password) VALUES(?,?,?)";
	if ($stmt = $mysqli->prepare($sql)) {
	$stmt->bind_param("sss", $uname,$name,$pwd);
	$stmt->execute();
	echo "Congratulations, you have been successfully registered.";
	}
	
	$mysqli->close(); //close db connection
	exit();
}
else if($_POST['page']=='Login')
{
	$uname=$_POST['username'];
	$pass=$_POST['password'];
	
	//Basic Form Validation
	if(!(strlen($uname)>0))
	{
		echo "Please enter a username";
		exit;
	}
	else if(!(strlen($pass)>0))
	{
		echo "Password field empty";
		exit;
	}
	
	$query = ("SELECT Username FROM Userdata WHERE Username='$uname';");
	$q=mysqli_query($mysqli,$query);
	if($q)
	{
	if (mysqli_num_rows($q)==0)
		{
			echo $uname." is not registered yet.<a href='register.php'>Register?</a>";
 			exit;
	}
	else
	{
		$pwd = sha1($pass);
		$sql = "SELECT Password FROM Userdata WHERE Username='$uname';";
		$q=mysqli_query($mysqli,$sql);
		$row = mysqli_fetch_array($q);
		if ($pwd==$row[0])
		{
			$_SESSION["username"]=$uname;
			echo "Login Successful.";
		}
	}
	}
	
	
	$mysqli->close(); //close db connection
	exit();
}
