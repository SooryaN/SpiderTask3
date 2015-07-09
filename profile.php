<?php if(isset($_GET[ 'username'])) { $uname=$_GET[ 'username']; } include 'base.php'; ?>
<?php startblock( 'css&title') ?>
<title>
    <?php if(isset($uname))echo $uname. "'s Profile";else echo 'Select Profile';?>
</title>
<link href="<?php echo $rel ?>css/style.css" rel="stylesheet" type="text/css" />
<?php endblock() ?>
<?php startblock( 'header_li') ?>
<li>
    <h1><?php 
    if(isset($uname))
    	echo $uname."'s Profile";
    else 
    	echo 'Select Profile';
    ?></h1>
</li>
<li>
    <h1><a href="" onclick="instruct();">Instructions</a></h1>
</li>
<?php endblock() ?>
<?php startblock( 'main') ?>
    <div class="content">
    <div id="info">
        <?php 
        if(!isset($uname)) 
        { 
            include_once( "config.php"); 
            $sql="SELECT Username from Userdata;"; 
            $q=mysqli_query($mysqli,$sql); 
            if(!$row=mysqli_fetch_array($q)) 
            {
                echo "No users yet";exit;
            } 
            else
            { 
                echo "<h1><br>Select a user!</h1>"; 
                echo '<select id="u">'; 
                echo '<option>'.$row[ 'Username']. '</option>'; 
                while($row=mysqli_fetch_array($q, MYSQLI_ASSOC)) 
                { 
                    echo '<option>'.$row[ 'Username']. '</option>'; 
                } 
                echo '</select>'; 
                echo '<button class="button" onclick="call()">Go</button>'; 
                echo '<script>function call(){
                    window.location = "'.$rel. 'user/"+$("#u").val();}</script>';
                exit; 
            } 
        } 
        include_once( "config.php"); 
        $sql="SELECT Username, Name,Score,Answered from Userdata where Username='$uname'"; 
        $q=mysqli_query($mysqli,$sql); 
        $row=mysqli_fetch_array($q); 
        $sql="SELECT COUNT(*) from Questions where User='$uname'"; 
        $q=mysqli_query($mysqli,$sql); 
        $row1=mysqli_fetch_array($q); 
        if(!$row) 
        { 
            echo "<h1 style='background:rgba(255,255,255,0.5);padding:2%;'><br>Sorry, looks like ".$uname. " isn't a registered user.</h1>";
            exit;
        } 
        if(strlen($row[ "Answered"])>0) 
        { 
            $array=json_decode($row["Answered"]); 
            $l=count($array); 
        } 
        else $l=0; 
        echo '
        <h1>'.$row["Name"]. '</h1>
        <br>'; 
        echo '
        <h1>a.k.a. : '.$row[ "Username"].'</h1>
        <br>'; 
        echo '
        <h1>Score : '.$row["Score"].'</h1>
        <br>'; 
        echo '
        <h1>Questions Answered : '.$l.'</h1>
        <br>'; 
        echo '
        <h1>Questions Submitted : '.$row1['COUNT(*)'].'</h1>
        <br>'; 
        ?>
        </div>
    </div>
    <div class="container">

        
<h2>Questions Answered</h2>

        <div class="content">
            <?php 
            include_once( "config.php"); 
            $sql="SELECT Answered from Userdata where Username='$uname'"; 
            $q=mysqli_query($mysqli,$sql); 
            $row=mysqli_fetch_array($q); 
            if(strlen($row[0])>0) 
            { 
                $array=json_decode($row[0]); 
                $l=implode(",", $array); 
                $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE ID IN($l)"; 
                $q=mysqli_query($mysqli,$sql ); 
                while($row=mysqli_fetch_array($q, MYSQLI_ASSOC)) 
                { 
                    echo '
                    <div class="card" style="margin:20px;" id="item_'.$row["ID"]. '">'; echo '<b>Q.'.$row[ "Question"]. '</b>
                        <br>
                        <br>'; echo '
                        <ul>'; echo '
                            <li>'.$row[ "Ch1"].'</li>
                            <br>'; echo '
                            <li>'.$row[ "Ch2"].'</li>
                            <br>'; echo '
                            <li>'.$row[ "Ch3"].'</li>
                            <br>'; echo '
                            <li>'.$row[ "Ch4"].'</li>
                            <br>
                        </ul>
                    </div>'; 
                } 
                echo '</div>
                    </div>'; 
                } 
                else echo "<h1 style='background:rgba(255,255,255,0.5);padding:2%;'><br>".$uname." Hasn't answered any questions yet.</h1>"; 
                ?>
    <div class="container">
        <h2> Questions Submitted</h2>
        <div class="content">
            <?php 
            include_once( "config.php"); 
            $sql="SELECT ID,Question,Ch1,Ch2,Ch3,Ch4 FROM Questions WHERE User='$uname'"; 
            $q=mysqli_query($mysqli,$sql ); 
            if(mysqli_num_rows($q)==0) 
                echo "<h1 style='background:rgba(255,255,255,0.5);padding:2%;'><br>".$uname. " Hasn't submitted any questions yet.</h1>"; 
            else
            { 
                while($row=mysqli_fetch_array($q, MYSQLI_ASSOC)) 
                { 
                    echo '<div class="card" id="item_'.$row[ "ID"]. '">'; 
                    echo '<b>Q.'.$row[ "Question"]. '</b><br><br>'; 
                    echo '<ul>'; 
                    echo '<li>'.$row[ "Ch1"]. '</li><br>'; 
                    echo '<li>'.$row[ "Ch2"]. '</li><br>'; 
                    echo '<li>'.$row[ "Ch3"]. '</li><br>'; 
                    echo '<li>'.$row[ "Ch4"]. '</li><br></ul></div>'; 
                } 
            } 
            ?>
        </div>
    </div>
<?php endblock()?>
