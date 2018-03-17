<?php

require_once('server_name.php');	
	
require(__DIR__.'/session_check.php');
	
if( isset($_SESSION['authSid']) && $_POST['path']) {
	
	//get path of files directory	
	$path= trim($_POST['path']);
	$path = '/'.str_replace(' ', '%20', $path);//replace spaces with %20 symbols
	
	//echo $path;
	
	$limit= $_POST['limit'];
	
	//set session ID
	$sid= $_SESSION["authSid"];
	
	$myJSON = fopen( $server_name.'/cgi-bin/filemanager/utilRequest.cgi?func=get_list&sid='.$sid.'&is_iso=0&list_mod%20e=all&path=/km_files/'.$_SESSION['username'].$path.'&dir=ASC&limit='.$limit.'&sort=filename&start=0', "r") or die ("Unable to open file!");
	$getJSON = fgets($myJSON);
	fclose($myJSON);
	
	// make json to xml
	$paramArray = json_decode($getJSON, true);
	
	//print all array
	//print_r($paramArray);
	
	//check if NAS session ended	
	if (isset($paramArray['status']) && $paramArray['status']==3){
		echo '{"sessionEnd": true }'; 
		exit;
	};
	
	//define variable for json answer for jquery
	$listJSON='';
	
	//return only needed elements from array
	foreach ($paramArray['datas'] as $values) {
		$listJSON .= "{";
		$listJSON .= '"filename":"'.$values['filename'].'",';
		$listJSON .= '"isfolder":'.$values['isfolder'];
		$listJSON .= "}\n,";    
	};
	
	//trim last comma and format strin as JSON
	$listJSON = chop($listJSON,",");
			
	$listJSON ='{ "datas": [ '.$listJSON. '] }';
		
	echo $listJSON;	
		
}