<?php
	
//require(__DIR__.'/session_check.php');
	
//$sid = $_SESSION["authSid"];
//$username = $_SESSION['username'];
//$servername = $_SESSION['mainservername'];
//$rootdir = $_SESSION['rootdir'];

session_start();

class NasRequest {
		
		public function listFiles($path, $limit) {	
			
			$request = $_SESSION['mainservername'].'/cgi-bin/filemanager/utilRequest.cgi?';
			$request .='func=get_list';
			$request .='&sid='.$_SESSION["authSid"];
			$request .='&path='.$_SESSION['rootdir'].$_SESSION['username'].$path;
			$request .='&limit='.$limit;
			//advanced settings
			$request .='&sort=filename&start=0&dir=ASC&is_iso=0&list_mode=all';
		
			$myJSON = fopen( $request , 'r') or die ("Unable to open file!");
			$getJSON = fgets($myJSON);
			fclose($myJSON);
		
			// make json to xml
			$response = json_decode($getJSON, true);
			
			return $response;
			
		}
		
		
}

