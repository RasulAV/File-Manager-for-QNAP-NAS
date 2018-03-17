<?php

if ( !isset($_SESSION['authSid']) ){
	 
	header("Location: /qnap/index.php");
	die();
	
}