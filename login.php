<?php 
include 'base.php' ?>
<?php startblock( 'css&title') ?>
<title>Login</title>
<link href="<?php echo $rel ?>css/main.css" rel="stylesheet" type="text/css">
<?php endblock() ?>
<?php startblock( 'script') ?>
<script type="text/javascript">
    $(document).ready(function() {

        $("#FormSubmit").click(function(e) {
            e.preventDefault();

            $("#FormSubmit").hide();
            $("#LoadingImage").show();

            var myData = {
                page: 'Login',
                username: $("#username").val(),
                password: $("#password").val()
            }; //build a post data structure
            $.post('everything.php', myData, function(returnedData) {
                if (returnedData.search('Successful') != -1) {
                    window.setTimeout(function() {
                        var location="<?php echo $rel ?>user/" + $("#username").val();
                        console.log(location);
                        window.location.href = location;
                    }, 1500);
                }
                $("#responds").html(returnedData);
                $("#FormSubmit").show();
                $("#LoadingImage").hide();
            });
        });
    });
</script>
<?php endblock() ?>
<?php startblock( 'header_li') ?>
<li>
    <h1>Welcome Back!</h1>
</li>
<li>
    <h1><a href="<?php echo $rel ?>register">Register?</a></h1>
</li>
<?php endblock() ?>
<?php startblock( 'main') ?>
<div id="form">
    <div id="title">
         <h1>Login Here!</h1>

    </div>Username:
    <br>
    <input id="username" placeholder="Unique Username" type="text">
    <br>Password:
    <br>
    <input autocomplete="off" id="password" name="pass" placeholder="Password goes here" required="" type="password">
    <input onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'" type="checkbox">Show password
    <br>
    <div id="responds"></div>
    <br>
    <input id="FormSubmit" name="submit" type="submit" value="Login">
    <img id="LoadingImage" src="images/loading.gif" style="display:none">
    <br>
    <br>
    <div id="nregister">Not Registered yet? <a href="<?php echo $rel ?>register">Join now!</a>

    </div>
</div>
<?php endblock() ?>