<?php 
session_start();
$rel=$_SESSION['dir'];
include_once("config.php");
if($_POST["page"]=="SubmitQ") 
{	$question=$_POST['Question'];
	$Ch1=$_POST['Ch1'];
	$Ch2=$_POST['Ch2'];
	$Ch3=$_POST['Ch3'];
	$Ch4=$_POST['Ch4'];
	if(isset($_POST['Ans']))
	$Ans=$_POST['Ans'];
	$category=$_POST['category'];
	
	//Basic Form Validation
	if(!(strlen($question)>0))
	{
		echo "Please enter a Question.";
		exit;
	}
	else if(!(strlen($Ch1)>0) || !(strlen($Ch2)>0) || !(strlen($Ch3)>0) ||!(strlen($Ch4)>0))
	{
		echo "Fill in 4 non choices amigo.";
		exit;
	}
	else if($category=='Select Category')
	{
		echo "Can't think of a category? Try Misc";
		exit;
	}
	$sql = "INSERT INTO Questions (Question,Ch1,Ch2,Ch3,Ch4,Category,Ans,User) VALUES(?,?,?,?,?,?,?,?)";
	if ($stmt = $mysqli->prepare($sql)) {
	$stmt->bind_param("ssssssss", $question,$Ch1,$Ch2,$Ch3,$Ch4,$category,$Ans,$_SESSION['username']);
	$stmt->execute();
		$my_id = $mysqli->insert_id; //Get ID of last inserted row from MySQL
		echo '<li id="item_'.$my_id.'">';
		echo '<div class="del_wrapper"><a href="#" class="del_button" id="del-'.$my_id.'">';
		echo '<img src="images/icon_del.gif" border="0" />';
		echo '</a></div>';
		echo '</a></div>'; 
		echo $question. '<br>'; 
		echo $Ch1. '<br>'; 
		echo $Ch2. '<br>'; 
		echo $Ch3. '<br>'; 
		echo $Ch4. '<br></li>'; ;
  $mysqli->close(); //close db connection"
	}
	
	else{
		
		//header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
		echo('HTTP/1.1 500 Looks like mysql error, could not insert record!');
		exit();
	}

}
elseif(isset($_POST["recordToDelete"]) && strlen($_POST["recordToDelete"])>0 && is_numeric($_POST["recordToDelete"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$idToDelete = filter_var($_POST["recordToDelete"],FILTER_SANITIZE_NUMBER_INT); 
	
	//try deleting record using the record ID we received from POST
	$delete_row = $mysqli->query("DELETE FROM Questions WHERE ID=".$idToDelete);
	
	if(!$delete_row)
	{    
		//If mysql delete query was unsuccessful, output error 
		header('HTTP/1.1 500 Could not delete record!');
		exit();
	}
	$mysqli->close(); //close db connection
}
elseif($_POST["page"]=='quiz')
{
	$id=$_POST['QID'];
	$check=$_POST['check'];
	$uname=$_SESSION['username'];
	$sql="SELECT Ans from Questions where ID='$id'";
	$q=mysqli_query($mysqli,$sql);
	$row = mysqli_fetch_array($q);
	$sql="SELECT Answered from Userdata where Username='$uname'";
	$q=mysqli_query($mysqli,$sql);
	$row1 = mysqli_fetch_array($q);
	if (strlen($row1[0])==0)
	{
		$arr=json_encode(array($id));
		$sql = "UPDATE Userdata SET Answered='$arr' Where Username='$uname'";
		$q=mysqli_query($mysqli,$sql);
	}
	else
	{
		$arr=json_decode($row1[0]);
		var_dump($arr);
		$arr[]=$id;
		$arr=json_encode($arr);
		$sql = "UPDATE Userdata SET Answered='$arr' Where Username='$uname'";
		$q=mysqli_query($mysqli,$sql);
	}
	
	if ($check==$row[0])
	{
		
		echo "correct";
	
	
	$sql="SELECT Score from Userdata where Username='$uname'";
	$q=mysqli_query($mysqli,$sql);
	$row = mysqli_fetch_array($q);
	$row[0]+=1;
	$sql = "UPDATE Userdata SET Score='$row[0]' Where Username='$uname'";
	$q=mysqli_query($mysqli,$sql);
	}
	else
	{
	$sql="SELECT Score from Userdata where Username='$uname'";
	$q=mysqli_query($mysqli,$sql);
	$row = mysqli_fetch_array($q);
	$row[0]-=1;
	$sql = "UPDATE Userdata SET Score='$row[0]' Where Username='$uname'";
	$q=mysqli_query($mysqli,$sql);

	}
}


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
	header("refresh:1; url=login");
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
			echo $uname." is not registered yet.<a href='registration.php'>Register?</a>";
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
			header("refresh:0; url=<?php echo $rel ?>user/$uname");
		}
		else
			echo "Incorrect Password. Please try again.";
	}
	}
elseif(isset($_POST['logout']))
{
	session_start();
if(session_destroy())
{
header("refresh:0; url=login");
}
}
else
{
	//Output error
	header('HTTP/1.1 500 Error occurred, Could not process request!');
    exit();
}	
	
	$mysqli->close(); //close db connection
	exit();
}
