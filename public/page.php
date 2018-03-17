<?php 
require(__DIR__.'/../app/src/session_check.php');

require(__DIR__.'/../app/src/logout.php');

require(__DIR__.'/../app/src/to_index.php');

require(__DIR__.'/../app/src/server_name.php');	
	
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
    <link rel="stylesheet" href="css/style.css">

    <title>Komek Me File Manager</title>
  </head>
  <body>
	
	<?php include('../app/views/header.php');?>	 
	      
	<?php include('../app/views/content.php');?>	 
    
	<?php include('../app/views/footer.php');?>
		 
  </body>
</html>