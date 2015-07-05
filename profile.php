<?php session_start();
$uname=$_GET['username'];
$rel=substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME'])));
$_SESSION['dir']=$rel;
?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $uname?>'s Profile</title>
  <link href="<?php echo $rel ?>css/base.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $rel ?>css/style.css" rel="stylesheet" type="text/css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
</head>

<body class="rel">
<header id="page_header">
<ul>
<li><h1><?php echo $uname?>'s Page</h1></li>
<li><h1><a href="" onclick="instruct();">Instructions</a></h1></li>
<li><h1><a href="<?php echo $rel ?>logout.php">Logout</a></h1></li>
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
  <button class="menu-btn fa fa-bars">Menu</button>
  <script src="<?php echo $rel ?>navbar.js"></script>
<div class="content">
<div id="info">
<?php //include db configuration file 
        include_once( "config.php"); //MySQL query 
        $sql="SELECT Username, Name,Score,Answered from Userdata where Username='$uname'";
        $q=mysqli_query($mysqli,$sql);
        $row = mysqli_fetch_array($q);
        if(!$row)
        {
          echo "<h1 style='background:rgba(255,255,255,0.5);padding:2%;'><br>Sorry, looks like ".$uname." isn't a registered user.</h1>";
          exit;
        }
        if(strlen($row["Answered"])>0)
        {
        $array=json_decode($row["Answered"]);
        $l=count($array);
        }
        else
          $l=0;
          echo '<h2>'.$row["Name"]. '</h2><br>'; 
          echo 'a.k.a.'.$row[ "Username"].'<br>'; 
          echo '<p>Score:'.$row["Score"].'</p><br>'; 
          echo '<p>Questions Answered:'.$l.'</p><br>';
        ?> 
</div>
<div class="container">
<h2> Questions Answered</h2>
    <div class="content">
        
        <?php //include db configuration file 
        include_once( "config.php"); //MySQL query 
        $sql="SELECT Answered from Userdata where Username='$uname'";
        $q=mysqli_query($mysqli,$sql);
        $row = mysqli_fetch_array($q);
        if(strlen($row[0])>0)
        {
        $array=json_decode($row[0]);
        $l=implode(",", $array);
        $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE ID IN($l)";
        $q=mysqli_query($mysqli,$sql ); //get all records from add_delete_record table 
        while($row=mysqli_fetch_array($q, MYSQLI_ASSOC)) 
        { 
          echo '<div class="card" id="item_'.$row["ID"]. '">'; 
          echo '<b>Q.'.$row[ "Question"]. '</b><br><br>'; 
          echo '<ul>';
          echo '<li>'.$row[ "Ch1"].'</li><br>'; 
          echo '<li>'.$row[ "Ch2"].'</li><br>'; 
          echo '<li>'.$row[ "Ch3"].'</li><br>';
          echo '<li>'.$row[ "Ch4"].'</li><br></ul></div>'; 
          } 
        echo '  </div>  </div>';
        }
        else
        echo "<h1 style='background:rgba(255,255,255,0.5);padding:2%;'><br>".$uname." Hasn't answered any questions yet.</h1>";
        ?> 

  <div class="container">
    <div><h2> Questions Submitted</h2></div>
        
    <div class="content">
        <?php //include db configuration file 
        include_once( "config.php"); //MySQL query 
        $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE User='$uname'";
        $q=mysqli_query($mysqli,$sql ); //get all records from add_delete_record table 
        if(mysqli_num_rows($q)==0)
        echo "<h1 style='background:rgba(255,255,255,0.5);padding:2%;'><br>".$uname." Hasn't submitted any questions yet.</h1>";
        else{
        while($row=mysqli_fetch_array($q, MYSQLI_ASSOC)) 
        { 
          echo '<div class="card" id="item_'.$row["ID"]. '">'; 
          echo '<b>Q.'.$row[ "Question"]. '</b><br><br>'; 
          echo '<ul>';
          echo '<li>'.$row[ "Ch1"].'</li><br>'; 
          echo '<li>'.$row[ "Ch2"].'</li><br>'; 
          echo '<li>'.$row[ "Ch3"].'</li><br>';
          echo '<li>'.$row[ "Ch4"].'</li><br></ul></div>'; 
          } 
        
        }
        
        ?> 
    </div>
  </div></div>
</html>