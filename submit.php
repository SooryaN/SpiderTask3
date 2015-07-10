<?php
include 'base.php';
if (!isset($_SESSION['username']))
{
	echo '<script>alert("Looks like you arent Logged in");</script>"';
	header('refresh:0; url=login');}
$uname=$_SESSION['username'];
?>
<?php startblock( 'css&title') ?>
<title>Submit</title>
<link href="<?php echo $rel ?>css/style.css" rel="stylesheet" type="text/css">
<?php endblock() ?>
<?php startblock( 'script') ?>
<script type="text/javascript">
    $(document).ready(function () {
      $("#Qsubmit").click(function () {
        $("#Qsubmit").hide();
        $("#choices").show();
        $("#Csubmit").show();
      });
      $("#Csubmit").click(function () {
        $("#Csubmit").hide();
        $("#correct").show();
        $("#FormSubmit").show();
      });
      //##### send add record Ajax request to response.php #########
      $("#FormSubmit").click(function (e) {
        e.preventDefault();

        $("#FormSubmit").hide(); //hide submit button
        $("#LoadingImage").show(); //show loading image
        
        var myData={page:'SubmitQ',Question:$("#Question").val(),Ch1:$("#Ch1").val(),Ch2:$("#Ch2").val(),Ch3:$("#Ch3").val(),Ch4:$("#Ch4").val(),Ans:$("#Ch"+$("#ans").val()).val(),category:$("#category").val()};
        $.post('everything.php', myData, function (returnedData) {
          if (returnedData.search('<li id=".') != -1) {
            $("#respondsul").append(returnedData);
            $("#error").html("");
          }
          else{
          	$("#error").html(returnedData);}
          $("#FormSubmit").show();
          $("#LoadingImage").hide();
        });
      });
      //##### Send delete Ajax request to response.php #########
      $("body").on("click", "#responds .del_button", function (e) {
        e.preventDefault();
        var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var DbNumberID = clickedID[1]; //and get number from array
        var myData = {
          recordToDelete: DbNumberID
        }; //build a post data structure
        $('#item_' + DbNumberID).addClass("sel"); //change background of this element by adding class
        $(this).hide(); //hide currently clicked delete button
        jQuery.ajax({
          type: "POST", // HTTP method POST or GET
          url: "<?php echo $rel ?>everything.php", //Where to make Ajax calls
          data: myData, //Form variables
          success: function (response) {
            //on success, hide  element user wants to delete.
            $('#item_' + DbNumberID).fadeOut();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            //On error, we alert user
            alert(thrownError);
          }
        });
      });
      $("body").on("click", "#responds .edit_button", function (e) {
        e.preventDefault();
            e.preventDefault();
        var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var DbNumberID = clickedID[1]; //and get number from array
        var Arr=$(this).parents('li').html().split('</div>')[2].split('<br>');
        $("#Question").val(Arr[0]);
        $("#Ch1").val(Arr[1]);
        $("#Ch2").val(Arr[2]);
        $("#Ch3").val(Arr[3]);
        Ch4:$("#Ch4").val(Arr[4]);
        $("#correct").show();
        $("#choices").show();
        $("#FormSubmit").show();
        $("#Qsubmit").hide();
                var myData = {
          recordToDelete: DbNumberID
        }; //build a post data structure
        $('#item_' + DbNumberID).addClass("sel"); //change background of this element by adding class
        $(this).hide(); //hide currently clicked delete button
        jQuery.ajax({
          type: "POST", // HTTP method POST or GET
          url: "<?php echo $rel ?>everything.php", //Where to make Ajax calls
          data: myData, //Form variables
          success: function (response) {
            //on success, hide  element user wants to delete.
            $('#item_' + DbNumberID).fadeOut();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            //On error, we alert user
            alert(thrownError);
          }
        });
      });
    });

  </script>
<?php endblock() ?>
<?php startblock( 'header_li') ?>
<li><h1>Cooleos Questions</h1></li>
<li><h1><div href="#dialog" name="modal" >Instructions</div></h1></li>
<?php endblock() ?>

<?php startblock( 'main') ?>
<div id="boxes">

  
  <!-- #customize your modal window here -->

  <div id="dialog" class="window">
    <h1 style="margin:0;padding:0;"><b>Some Basic Instructions</b></h1>| 
    Enter or Esc to close<br>
    <h1>1. Fill out your questions of the left hand box</h1>
    <h1>2. The right hand box shows the questions you've already published</h1>
    <h1>3. Click on the cross at the top right corner of the question bubble to delete it</h1>
    <h1>3. Click on the <u>Edit</u> at the top right corner of the question bubble to edit your entry</h1>

  </div>

  
  <!-- Do not remove div#mask, because you'll need it to fill the whole screen -->  
  <div id="mask"></div>
</div>

<script>
$(document).ready(function() {  

  //select all the a tag with name equal to modal
  $('div[name=modal]').click(function(e) {
    //Cancel the link behavior
    e.preventDefault();
    //Get the A tag
    var id = $(this).attr('href');
  
    //Get the screen height and width
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
  
    //Set height and width to mask to fill up the whole screen
    $('#mask').css({'width':maskWidth,'height':maskHeight});
    
    //transition effect   
    $('#mask').fadeIn(1000);  
    $('#mask').fadeTo("slow",0.8);  
  
    //Get the window height and width
    var winH = $(window).height();
    var winW = $(window).width();
              
    //Set the popup window to center
    $(id).css('left', winW/2-$(id).width()/2);
  
    //transition effect
    $(id).fadeIn(2000); 
  
  });
  
  //if mask is clicked
  $('#mask').click(function () {
    $(this).hide();
    $('.window').hide();
  });     
  
});
$(document).keyup(function(e) {
  if(e.keyCode == 13 || e.keyCode==27) {
    $('#mask').hide();
    $('.window').hide();
  }
});
</script>
<div class="content_wrapper">
    <div id="responds">
      <h3 style='margin-left:13%'>Questions you've published</h3>
      <ul id="respondsul">
        <?php //include db configuration file 
        include_once("config.php"); //MySQL query 
        $q=mysqli_query($mysqli, "SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions where User='$uname'"); //get all records from add_delete_record table 
        if($q) { while($row=mysqli_fetch_array($q, MYSQLI_ASSOC)) 
        { 
        	echo '<li id="item_'.$row[ "ID"]. '">'; 
        	echo '<div class="del_wrapper"><a href="#" class="del_button" id="del-'.$row[ "ID"]. '">'; 
        	echo '<img src="'.$rel.'images/icon_del.gif" border="0" />'; 
        	echo '</a></div>';
          echo '<div class="del_wrapper"><a href="#" class="edit_button" id="edit-'.$row[ "ID"]. '">'; 
          echo 'Edit'; 
          echo '</a></div>';
           
        	echo $row[ "Question"]. '<br>'; 
        	echo $row[ "Ch1"]. '<br>'; 
        	echo $row[ "Ch2"]. '<br>'; 
        	echo $row[ "Ch3"]. '<br>'; 
        	echo $row[ "Ch4"]. '<br></li>'; 
        	} 
        	} 
        $mysqli->close(); 
        ?> 
       </ul>
    </div>
    <div class="form_style">
      <textarea type="text" id="Question" cols="45" rows="5" style="resize: none;"placeholder="Enter some text"></textarea>
      
      <button id="Qsubmit">Add Question</button>
      <div id="choices" style="display:none;">
        <input type="text" id="Ch1" placeholder="Enter Choice1">
        <input type="text" id="Ch2" placeholder="Enter Choice2">
        <input type="text" id="Ch3" placeholder="Enter Choice3">
        <input type="text" id="Ch4" placeholder="Enter Choice4">
      </div>
      <button id="Csubmit" style="display:none;">Add Choices</button>
      <div id="correct" style="display:none;">
        <input type="number" min=1 max=4 id="ans" placeholder="Enter correct answer number" />
        <select id="category" >
        	<option selected="selected">Select Category</option>
	        <option value="Sports">Sports</option>
			<option value="Politics">Politics</option>
			<option value="Science">Science</option>
			<option value="History">History</option>
			<option value="Popculture">Pop Culture</option>
			<option value="Miscalleneous">Miscalleneous</option>
		</select></div>
		<div id="error"></div>
      <button id="FormSubmit" style="display:none;">Add record</button> <img src="<?php echo $rel ?>images/loading.gif" style="display:none;" id="LoadingImage" /> </div>
  </div>
        <?php endblock() ?>
