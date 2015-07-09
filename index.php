<?php
    include 'base.php';
?>
<?php startblock( 'css&title') ?>
<title>Hello there</title>
  <link rel="stylesheet" href="<?php echo $rel ?>css/1.css">
<?php endblock() ?>
<?php startblock( 'main') ?>
	<div id="wrapper">
    <h1>Quiz Away!</h1>
    <div class="whitebox">
      <a href='<?php echo $rel ?>login'><div class="white">
        <h2>Start Now!</h2></a>
      </div>
    </div>

</div>
<p style="width:56%;margin-top:180px;margin-left:22%;font-size:1.5em;background:rgba(255,255,255,0.5);"><b>Hello Again! This is a simple quizzing portal made as part of the Spider Inductions. You can check out the project <a href=https://github.com/SooryaN/SpiderTask3>here</a>.<br> Hope you like it!</b></p>
<?php endblock() ?>       