<?php
	
require_once('server_name.php');	
	
require(__DIR__.'/session_check.php');

if ( isset($_POST['login']) ){
		
		
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	
	$xml=simplexml_load_file( $server_name.'/cgi-bin/authLogin.cgi?user='.$login.'&pwd='.$pass) or die("Error to open file");
	
	if ($xml->authPassed==1) {
		
			$authSid = $xml->authSid->__toString();//conver simplexml object to string
			$username = $xml->username->__toString();//conver simplexml object to string
			$groupname = $xml->groupname->__toString();//conver simplexml object to string
						
			$_SESSION["authSid"] = $authSid;
			$_SESSION["username"] = $username;
			$_SESSION["groupname"] = $groupname;
			
			
			$text_send = '{
							"authPassed": true ,
							"authSid": "'.$authSid.'"
						  }';
			
		} else {
			$text_send = '{"authPassed": false }';
		};
	
	echo $text_send ;
}