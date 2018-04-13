<?php 
	
header('Access-Control-Allow-Origin: http://local.komek.me');


if ($_SERVER['REQUEST_METHOD']==='POST'){
	
	$sid= $_POST['sid'];
	$ip= $_POST['ip'];
	$path= $_POST['path'];
	$user= $_POST['user'];
	
	
	$target_dir = $user.$path."/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	
	
	
	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded." . "";
        $text_send = '{"ready": 1 }';
        
    } else {
        $text_send = '{"ready": 0 }';
    };

	
	echo($text_send);
	
	//echo($target_dir);
}