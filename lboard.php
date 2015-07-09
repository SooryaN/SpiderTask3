<?php 
include 'base.php'; ?>
<?php startblock( 'css&title') ?>
<title>Leaderboard!</title>
<link rel='stylesheet' href='<?php echo $rel ?>/css/style.css'>
<script src="http://code.highcharts.com/highcharts.js" type="text/javascript"></script>
<script src="<?php echo $rel ?>Extras/jquery.highchartTable.js" type="text/javascript"></script>
<script src="<?php echo $rel ?>Extras/jquery.tablesorter.min.js" type="text/javascript"></script>
<?php endblock() ?>
<?php startblock( 'script') ?>
<script>
    $(document).ready(function() {
        $('table.highchart').highchartTable();
        $('table.highchart').tablesorter();
         
    });
</script>
<?php endblock() ?>
<?php startblock( 'header_li') ?>
<li>
     <h1>The Standings!</h1>

</li>
<?php endblock() ?>
<?php startblock( 'main') ?>
<div style="width:800px;margin:auto;margin-top:100px;">

    <table class="highchart tablesorter" data-graph-legend-layout: 'vertical' data-graph-subtitle-text="Play around with the attributes." data-graph-container-before="1" data-graph-type="column">
        <caption style='display:none;'>The leaders!</caption>
        <thead>
            <tr>
                <th>Users<img src='<?php echo $rel ?>images/updown.png'></th>
                <th>Score<img src='<?php echo $rel ?>images/updown.png'></th>
                <th data-graph-hidden="1" data-graph-stack-group='1'>Submitted<img src='<?php echo $rel ?>images/updown.png'></th>
                <th data-graph-hidden="1" data-graph-stack-group='1'>Answered<img src='<?php echo $rel ?>images/updown.png'></th>
            </tr>
        </thead>
        <tbody>

            <?php include_once( "config.php");
            $sql="SELECT Username,Score,Answered from Userdata order by Score desc;" ; 
            $q=mysqli_query($mysqli,$sql); 
            while($row=mysqli_fetch_array($q, MYSQLI_ASSOC)) 
            { 
            	if(strlen($row[ "Answered"])>0) 
            	{ 
            		$array=json_decode($row["Answered"]); 
            		$l=count($array); 
            	} 
            		else $l=0; 
            		$a=$row['Username']; 
            		$sql1="SELECT COUNT(*) from Questions where User='$a'"; 
            		$q1=mysqli_query($mysqli,$sql1); $row1 = mysqli_fetch_array($q1); 
            		echo '
			            <tr>
			                <td><b><a style="text-decoration:none;color:blue;"href="'.$rel.'user/'.$a.'">'.$row['Username'].'</a></b></td>
			                <td>'.$row['Score'].'</td>
			                <td>'.$row1['COUNT(*)'].'</td>
			                <td>'.$l.'</td>
			            </tr>'; 
            } ?>
        </tbody>
    </table>
</div>
<?php endblock() ?>