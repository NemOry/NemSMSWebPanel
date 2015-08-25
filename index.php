<?php 

require_once("includes/initialize.php");

if($session->is_logged_in())
{
  header("location: sendsms.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>NemSMS</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://getbootstrap.com/assets/ico/favicon.ico">
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://getbootstrap.com/examples/signin/signin.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
  </head>

  <body>
    <div class="container">
      <div class="form-signin">
        <h2 class="form-signin-heading">Login</h2>
        <input id="username" type="username" class="form-control" placeholder="username" required><br/>
        <input id="password" type="password" class="form-control" placeholder="password" required><br/>
        <button id="btnlogin" class="btn btn-lg btn-primary btn-block">Login</button>
      </div>
    </div>

    <script>

    $("#btnlogin").click(function()
    {
    	var theusername = $("#username").val();
	    var thepassword = $("#password").val();

	    if(theusername.length > 0 && thepassword.length > 0)
	    {
	    	$("#btnlogin").prop("disabled", true);
	    	$("#btnlogin").text("Logging In...");

	    	$.post("includes/webservices/login.php", {username: theusername, password: thepassword}, function(response) 
	    	{
          var responseJSON = JSON.parse(response);

  				if(responseJSON.status == "okay")
  				{
  					window.location.href = "sendsms.php";
  				}
  				else
  				{
  					alert(responseJSON.message);
  				}

  				$("#btnlogin").prop("disabled", false);
  				$("#btnlogin").text("Login");
  			});
	    }
	    else
    	{
    		alert("Please enter a username and a password.");
    	}
    });

    </script>

  </body>
</html>