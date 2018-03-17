<?php 
	
require(__DIR__.'/app/src/session_check.php');

require(__DIR__.'/app/src/to_page.php');

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="author" content="Rasul Akhmedkhanov" >
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css">

    <title>Komek Me File Manager</title>
  </head>
  <body>
    
    <div class="container main-content">
	    
	    <div class="alert" role="alert">
		</div>
	    
	    <div class="authenticate form" >
		    <form >
			    <label for="login">Login</label>
				<input type="text" placeholder="type your login" class="js-auth-login" id="login" required="" autocomplete="off"/> 
			    <br>
			    <br>
		    	<label for="password">Password</label>
				<input type="password" placeholder="type your password" class="js-auth-pass" id="password" required="" autocomplete="off"/>
			    <br>
			    <br>
				<input type="button" id="submit" class="auth-submit js-auth js-submit" value="Submit"/>
			</form>
		</div>
	    
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    
    <script src="public/js/script.min.js"></script>
    <script src="public/js/get_sid.js"></script>
  </body>
</html>