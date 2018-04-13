<?php

//require(__DIR__.'/session_check.php');

require(__DIR__.'/class.nas_requests.php');

if( isset($_SESSION['authSid']) && $_POST['path']) {

	//get path of files directory
	$path= trim($_POST['path']);
	$path = '/'.str_replace(' ', '%20', $path);//replace spaces with %20 symbols
	$limit= $_POST['limit'];
	
	$nasRequest = new NasRequest();	
	$paramArray = $nasRequest->listFiles($path,$limit);
	

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

	//well formated JSON data ready
	$listJSON ='{ "datas": [ '.$listJSON. '] }';

	//send it to AJAX JS file
	echo $listJSON;

}