<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home</title>
	<link rel="stylesheet" href="css/1.css">
	<link rel="stylesheet" href="css/base.css">
	
</head>
<body>
	<div id="wrapper">
    <h1>Quiz Away!</h1>
    <div class="whitebox">
      <div class="white">
        <h2><?php echo substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME'])));?></h2>
      </div>
    </div>
</div>
</body>
</html>