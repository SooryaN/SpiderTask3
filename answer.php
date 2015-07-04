<?php session_start();
if (!isset($_SESSION['username']))
{
  echo '<script>alert("Looks like you arent Logged in");</script>"';
  header('refresh:0; url=login.php');}
  $uname=$_SESSION['username']; ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Submit</title>
<link href="css/base.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css" />

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

<script>
  $(document).ready(function () {
    $("body").on("click", ".container .content .card a", function (e){
      e.preventDefault();
      var ParentID = $(this).parents('div').attr('id').split('_')[1];
      var myData = {
        QID: ParentID,check:$(this).html() 
      }; //build a post data structure
      var li=$("#" + $(this).parents('div').attr('id'));
       //change background of this element by adding class
      //$(this).hide(); //hide currently clicked delete button
      jQuery.ajax({
        type: "POST", // HTTP method POST or GET
        url: "everything.php", //Where to make Ajax calls
        data: myData, //Form variables
        success: function (response) {
          console.log(li);
          if(response.search("correct")!=-1)
          {
            li.addClass('correct');
            li.html("Got it Right!");
            setTimeout(function(){li.fadeOut();},500);
          }
          else
          {
            li.addClass('wrong');
            li.html("Sorry, Wrong answer");
            setTimeout(function(){li.fadeOut();},500);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          //On error, we alert user
          alert(thrownError);
        }
      });
    });
  });
</script>
</head>

<body class="rel">
<div id="page_header">
<ul>
<li><h1>Gray matter testing site</h1></li>
<li><h1><a href="logout.php">Logout</a></h1></li>
</ul>
</div>
<nav id="menu">
  <ul>
    <li>
      <h1><i class="fa fa-list"></i> Menu</h1>
    </li>
    <li>
      <a href="index.php"><i class="fa fa-check"></i> Home</a>
    </li>
    <li>
        <a href="login.php"><i class="fa fa-check"></i>Login/Register</a>
      </li>
    
    <li>
      <a href="submit.php"><i class="fa fa-check"></i>Submit Qs</a>
    </li>
      <li> <a href="answer.php"><i class="fa fa-check"></i> Answer Qs</a> </li>
      <li> <a onclick="function(e){e.preventDefault();this.parents('header').hide();}"><i class="fa fa-check"></i> Exit</a> </li>
    
  </ul>
</nav>
<button class="menu-btn fa fa-bars fa-3x" ></button> <script src="navbar.js"></script>
<div class="container">
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
        $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE ID NOT IN($l) AND NOT User='$uname';";
        }
        else
         $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE NOT User='$uname';"; 
        $q=mysqli_query($mysqli,$sql ); //get all records from add_delete_record table 
        while($row=mysqli_fetch_array($q, MYSQLI_ASSOC)) 
        { 
          echo '<div class="card" id="item_'.$row["ID"]. '">'; 
          echo '<b>Q.'.$row[ "Question"]. '</b><br><br>'; 
          echo '<a href="">'.$row[ "Ch1"].'</a><br>'; 
          echo '<a href="">'.$row[ "Ch2"].'</a><br>'; 
          echo '<a href="">'.$row[ "Ch3"].'</a><br>';
          echo '<a href="">'.$row[ "Ch4"].'</a><br></div>'; 
          } 
          
        $mysqli->close(); 
        ?> 
    </div>
  </div>
<script>
  function isEmpty( el ){
      return !$.trim(el.html())
  }
  if (isEmpty($('.content'))) {
      $('.content').hide();$('.container').append("<h1 style='background:rgba(255,255,255,0.5);padding:2%;'><br>Woah! Looks like you've answered all the questions.<br>Want to add some more <a href='submit.php'>here</a>?<br>Or bask in your glory <a href='profile.php'>here</a>.</h1>");}
</script>
</body>
</html>
