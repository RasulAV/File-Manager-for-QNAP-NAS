<?php
	
require_once('settings.php');	
	
require(__DIR__.'/session_check.php');

if ( isset($_POST['login']) ){
		
		
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$mainservername = $nasserver['servername']['main'];
	$rootdir = $nasserver['servername']['rootdir'];
	
	$xml=simplexml_load_file( $mainservername.'/cgi-bin/authLogin.cgi?user='.$login.'&pwd='.$pass) or die("Error to open file");
	
	if ($xml->authPassed==1) {
		
			$authSid = $xml->authSid->__toString();//conver simplexml object to string
			$username = $xml->username->__toString();//conver simplexml object to string
			$groupname = $xml->groupname->__toString();//conver simplexml object to string
						
						
			//initialize SESSION values			
			$_SESSION["authSid"] = $authSid;
			$_SESSION["username"] = $username;
			$_SESSION["groupname"] = $groupname;
			$_SESSION["mainservername"] = $mainservername;
			$_SESSION["rootdir"] = $rootdir;
			
			
			
			$text_send = '{
							"authPassed": true ,
							"authSid": "'.$authSid.'",
							"userName": "'.$username.'",
							"serverName": "'.$nasserver['servername']['upload'].'"
							}'; // variable for javascipt cookies - upload to NAS
			
		} else {
			$text_send = '{"authPassed": false }';
		};
	
	echo $text_send;
}