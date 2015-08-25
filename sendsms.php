<?php 

require_once("includes/initialize.php");

if(!$session->is_logged_in())
{
  header("location: index.php");
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
      <div class="form-signin" role="form">
        <h2 class="form-signin-heading">Send SMS</h2>
        <input id="userid" type="text" hidden value="<?php echo $session->userid; ?>"><br/>
        <input id="phonenumber" type="text" class="form-control" placeholder="phonenumber" required><br/>
        <textarea id="message" class="form-control" rows="8" placeholder="message" required></textarea><br/>
        <button id="btnsend" class="btn btn-lg btn-primary btn-block">Send SMS</button><br/>
        <button id="btnlogout" class="btn btn-lg btn-danger btn-block">Logout</button>
      </div>
    </div>
    
    <script>

    $("#btnsend").click(function()
    {
    	var userid 			 = $("#userid").val();
	    var message 		 = $("#message").val();
	    var phonenumber  = $("#phonenumber").val();

	    if(message.length > 0 && phonenumber.length > 0)
	    {
        $("#btnsend").prop("disabled", true);
        $("#btnsend").text("Sending...");

	    	$.post("includes/webservices/create.php", {object: "message", userid: userid, message: message, phonenumber: phonenumber}, function(response) 
	    	{
  				if(response == "success")
          {
            alert("Your message has been successfully sent to your device. Now the device should start sending it via SMS.");
          }
          else
          {
            alert(response);
          }

          $("#btnsend").text("Send SMS");
          $("#btnsend").prop("disabled", false);
  			});
	    }
	    else
    	{
    		alert("Please enter a message and a phonenumber.");
    	}
    });

    $("#btnlogout").click(function()
    {
      $("#btnlogout").text("Logging out....");
      $("#btnlogout").prop("disabled", true);

    	$.post("includes/webservices/logout.php", function(response) 
    	{
  			window.location.href = "index.php";
  		});
    });

    </script>

  </body>
</html>