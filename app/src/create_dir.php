<?php


require_once('settings.php');

require(__DIR__.'/session_check.php');

if( isset($_SESSION['authSid']) && $_POST['path']) {


	//get path of files directory
	$path= trim($_POST['path']);
	$path = '/'.str_replace(' ', '%20', $path);//replace spaces with %20 symbols
	
	// created directory name
	$dirname= trim($_POST['dirName']);
	
	
	$sid= $_SESSION["authSid"];
	$username = $_SESSION['username'];
	$servername = $nasserver['servername']['main'];
	
	$rootdir = $nasserver['servername']['rootdir'];
	
	$request = $servername . '/cgi-bin/filemanager/utilRequest.cgi?func=createdir&sid=' . $sid . '&dest_folder=' . $dirname .'&dest_path=' . $rootdir . $username. $path;
	
	
	//echo($request);
	
	$myJSON = fopen( $request , "r") or die ("Unable to create folder!");
	$getJSON = fgets($myJSON);
	fclose($myJSON);
	
	// make json to xml
	$nasParamArray = json_decode($getJSON, true);
	
	
	// nas returned status 
	$status = $nasParamArray['status'];

	//print_r($nasParamArray);
	
	//check if NAS session ended
	if ( isset($status) ){
			
			switch ($status) {
			    case 1:
			        echo '{"status": "ready" }';
			        break;
			    case 33:
			        echo '{"status": "exist" }';
			        break;
			    case 2:
			        echo '{"status": "exist" }';
			        break;
			    case 4:
			        echo '{"status": "denied" }';
			        break;
			    default:
			        echo '{"sessionEnd": true }';
			}
					
	};
		
	

};