<?php 
include 'base.php';
if (isset($_GET['category']))
{
  $category=ucfirst($_GET['category']);
}

if (!isset($_SESSION['username']))
{
  echo '<script>alert("Looks like you arent Logged in");</script>"';
  header('refresh:0; url=login');}
  $uname=$_SESSION['username'];
 ?>
<?php startblock( 'css&title') ?>
<title>Answer away!</title>
<link href="<?php echo $rel ?>css/style.css" rel="stylesheet" type="text/css" />
<?php endblock() ?>
<?php startblock( 'script') ?>
<script>
  $(document).ready(function () {
    $("body").on("click", ".container .content .card li", function (e){
      e.preventDefault();
      var ParentID = $(this).parents('div').attr('id').split('_')[1];
      var myData = {
        page:'quiz',QID: ParentID,check:$(this).html() 
      }; //build a post data structure
      var li=$("#" + $(this).parents('div').attr('id'));
       //change background of this element by adding class
      //$(this).hide(); //hide currently clicked delete button
      jQuery.ajax({
        type: "POST", // HTTP method POST or GET
        url: "everything.php", //Where to make Ajax calls
        data: myData, //Form variables
        success: function (response) {
          console.log(response);
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
        <?php endblock() ?>
<?php startblock( 'header_li') ?>
<li>
    <h1><?php 
    if(isset($category))
    	echo $category.' Qs';
    else 
    	echo 'All Questions';
    ?></h1>
</li>
<li><h1><div href="#dialog" name="modal" >Instructions</div></h1></li>
<?php endblock() ?>
<?php startblock( 'main') ?>
<div id="boxes">
  <!-- #customize your modal window here -->
  <div id="dialog" class="window">
    <h1 style="margin:0;padding:0;"><b>Some Basic Instructions</b></h1>| 
    Enter or Esc to close<br>
    <h1>1. Click on the options to record your answer.<br>But remember, you only get one chance!</h1>
    <h1>2. Change the URL to /quiz/(Category Name) <br>eg /quiz/miscalleneous to filter questions.</h1>
    <h1>3. Scores only get updated on page refresh or navigation to another page. Sorry 'bout that!</h1>
    <h1>4. Have fun!</h1>
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
/*$(document).ready(function () {
  //id is the ID for the DIV you want to display it as modal window
  launchWindow(id); 
});*/
$(document).keyup(function(e) {
  if(e.keyCode == 13 || e.keyCode==27) {
    $('#mask').hide();
    $('.window').hide();
  }
});
</script>
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
        if (isset($category))
          $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE ID NOT IN($l) AND NOT User='$uname' AND Category='$category';";
        else
          $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE ID NOT IN($l) AND NOT User='$uname';";
        }
        else{
          if (isset($category))
            $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE NOT User='$uname' AND Category='$category';"; 
          else
            $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE NOT User='$uname';"; 
        }
        $q=mysqli_query($mysqli,$sql ); //get all records from add_delete_record table 
        while($row=mysqli_fetch_array($q, MYSQLI_ASSOC)) 
        { 
          echo '<div class="card" id="item_'.$row["ID"]. '">'; 
          echo '<b>Q.'.$row[ "Question"]. '</b><br><br>'; 
          echo '<li>'.$row[ "Ch1"].'</li><br>'; 
          echo '<li>'.$row[ "Ch2"].'</li><br>'; 
          echo '<li>'.$row[ "Ch3"].'</li><br>';
          echo '<li>'.$row[ "Ch4"].'</li><br></div>'; 
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
      $('.content').hide();$('.container').append("<h1 style='background:rgba(255,255,255,0.5);padding:2%;'><br>Woah! Looks like you've answered all the questions here.<br>Want to add some more <a href='<?php echo $rel ?>submit'>here</a>?<br>Or bask in your glory <a href='<?php echo $rel ?>leaderboard'>here</a>.</h1>");}
</script>
        <?php endblock() ?>