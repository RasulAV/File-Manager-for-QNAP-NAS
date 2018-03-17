<?php

if ( isset($_SESSION['authSid']) ){
	 
	header("Location: /qnap/public/page.php");
	die();
	
}