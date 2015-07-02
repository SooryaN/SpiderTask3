<?php
session_start()
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Submit</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/base.css" rel="stylesheet" type="text/css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#Qsubmit").click(function(){
		$("#Qsubmit").hide();
		$("#choices").show();
		$("#Csubmit").show();

	});
	$("#Csubmit").click(function(){
		$("#Csubmit").hide();
		$("#correct").show();
		$("#FormSubmit").show();

	});
	//##### send add record Ajax request to response.php #########
	$("#FormSubmit").click(function (e) {
			e.preventDefault();
			if($("#contentText").val()==='')
			{
				alert("Please enter some text!");
				return false;
			}
			
			$("#FormSubmit").hide(); //hide submit button
			$("#LoadingImage").show(); //show loading image
			
			var myData = {page:'AddQ',}; //build a post data structure
            $.post('response.php', myData, function(returnedData) {
                if(returnedData.search('successfully registered.')!=-1)
                {window.setTimeout(function(){window.location = "http://localhost/SpiderTask3/login.php"}, 1500);}
                $("#responds").html(returnedData);
                $("#FormSubmit").show(); 
                $("#LoadingImage").hide();
            });
	});

	//##### Send delete Ajax request to response.php #########
	$("body").on("click", "#responds .del_button", function(e) {
		 e.preventDefault();
		 var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
		 var DbNumberID = clickedID[1]; //and get number from array
		 var myData = {recordToDelete:DbNumberID}; //build a post data structure
		 
		$('#item_'+DbNumberID).addClass( "sel" ); //change background of this element by adding class
		$(this).hide(); //hide currently clicked delete button
		 
			jQuery.ajax({
			type: "POST", // HTTP method POST or GET
			url: "response.php", //Where to make Ajax calls
			data:myData, //Form variables
			success:function(response){
				//on success, hide  element user wants to delete.
				$('#item_'+DbNumberID).fadeOut();
			},
			error:function (xhr, ajaxOptions, thrownError){
				//On error, we alert user
				alert(thrownError);
			}
			});
	});

});
</script>

</head>
<body class="rel">
  <nav id="menu">
    <ul>
      <li>
        <h1><i class="fa fa-list"></i> Menu</h1>
      </li>


      <li>
        <a href="index.php"><i class="fa fa-check"></i> Home</a>
      </li>


      <li>
        <a href="login.php"><i class="fa fa-check"></i> Login</a>
      </li>


      <li>
        <a href="registration.php"><i class="fa fa-check"></i>Register</a>
      </li>


      <li>
        <a href="#paragraph4"><i class="fa fa-check"></i> Paragraph 4</a>
      </li>


      <li>
        <a href=""><i class="fa fa-check"></i> Back</a>
      </li>
    </ul>
  </nav>
  <button class="menu-btn fa fa-bars fa-3x" ></button> <script src="navbar.js"></script>
<div class="content_wrapper">
<ul id="responds">
<?php
//include db configuration file
include_once("config.php");

//MySQL query
$q = mysqli_query($mysqli,"SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions");
//get all records from add_delete_record table

if($q)
{
while($row = mysqli_fetch_array($q, MYSQLI_ASSOC))
{
  echo '<li id="item_'.$row["ID"].'">';
  echo '<div class="del_wrapper"><a href="#" class="del_button" id="del-'.$row["ID"].'">';
  echo '<img src="images/icon_del.gif" border="0" />';
  echo '</a></div>';
  echo $row["Question"].'<br>';
  echo $row["Ch1"].'<br>';
  echo $row["Ch2"].'<br>';
  echo $row["Ch3"].'<br>';
  echo $row["Ch4"].'<br></li>';
}
}
//close db connection
$mysqli->close();
?>
</ul>
    <div class="form_style">
    <textarea type="text" id="Question" cols="45" rows="5" placeholder="Enter some text"></textarea>
    <br>
    <button id="Qsubmit">Add Question</button>
    <div id="choices" style="display:none;" >
    <input type="text" id="Ch1"  placeholder="Enter Choice1">
    <input type="text" id="Ch2"  placeholder="Enter Choice2">
    <input type="text" id="Ch3"  placeholder="Enter Choice3">
    <input type="text" id="Ch4"  placeholder="Enter Choice4">
    </div>
    <button id="Csubmit" style="display:none;">Add Choices</button>
    <div id="correct" style="display:none;">
    <input type="number" min=1 max=4 id="ans" placeholder="Enter correct answer number"/>
    </div>
    <button id="FormSubmit" style="display:none;">Add record</button>
    <img src="images/loading.gif" style="display:none;" id="LoadingImage" />
    </div>
</div>

</body>
</html>
