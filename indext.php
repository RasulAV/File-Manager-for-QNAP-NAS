<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>QNAP test</title>
	<!-- Include our stylesheet 
	<link href="style.css" rel="stylesheet"/>-->

</head>
<body>

	<div class="content">

		<?php
			
			$xml=simplexml_load_file("http://files.komek.me:8080/cgi-bin/authLogin.cgi?user=admin&pwd=R3JhdHNpeWEjMTI=") or die("Error ");
			echo '<br><br> <b>SID:</b> <br>';
			echo $xml->authSid.'<br>';
			//echo $xml->authPassed.'<br>';
			//echo $xml->groupname.'<br>';
			
			$authSid = $xml->authSid;
			
			// list files - show only JSON file
			$myJSON = fopen("http://files.komek.me:8080/cgi-bin/filemanager/utilRequest.cgi?func=get_tree&sid=$authSid&node=/test", "r") or die("Unable to open file!");
			$getJSON = fgets($myJSON);
			fclose($myJSON);
			
			$getJSON = '{"dir":'.trim($getJSON).'}';//clear for whitespaces
			
			//echo '<br><br> <b>JSON answer:</b> <br>';
			//echo $getJSON . '<br>';
			
			/* users LIST
				
			$xml=simplexml_load_file("http://files.komek.me:8080/cgi-bin/priv/privRequest.cgi?&subfunc=user&getdata=1&sort=13&filter=&lower=0&refresh=0&sid=$authSid&type=0&upper=10") or die("Error ");
			
			//echo $xml->userroot->data->user[1]->username .'<br>'; //single query for one user
			echo '<br><br> <b>Users:</b> <br>';
			foreach($xml->userroot->data->user as $users) { //loop for users
			    echo $users->username .'<br>';
			     
			}
			*/
			
			if(isset($_FILES['file'])){
				
				echo('yes!');
				
				print_r($_FILES['file']);
			}
			
			$myJSON = fopen('http://files.komek.me:8080/cgi-bin/filemanager/utilRequest.cgi?func=upload&type=standard&sid=ow9c4p3d&dest_path=/test&overwrite=1&progress=test.zip', "r") or die("Unable to upload file!");
			
			fclose($myJSON);
		?>
		
		<br>
		<br>
		
		<b>Custom path:</b> <br>
		<input type="text" class="path-name" value="/test"/>
		<button class="button" > List Folder </button>
		
		<br>
		<br>

		<b>Upload :</b> <br>
		<form action="indext.php" id="form1" name="form1" encType="multipart/form-data"  method="post" >
			
			<input type="text" name="func" style="width:450" value="upload" /> <br>
			
			<input type="text" name="type" style="width:450" value="standart" /><br>
			
			<input type="text" name="sid" style="width:450" value="<?php echo $xml->authSid?>" /><br>
			
			<input type="text" name="dest_path" style="width:450" value="/test" /><br>
			
			<input type="checkbox" name="overwrite" style="width:450" checked /><br>
			
			<input type="text" name="progress" style="width:450" value="-test" /><br>
			
			
			<input type="file" name="file" style="width:450" /><br><br>
			
			<input type="submit" name="submit" value="submit" />    
		</form>
	</div>
	<!-- Include our script files -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	

	<script>
		
		
		$('.button').click(function(){
		    var obj = JSON.parse('<?echo $getJSON ?>');
			//$(".content").html(obj.id+" "+obj.cls);
			
			for (var i = 0; i < obj.dir.length; i++) {
			    var dir = obj.dir[i];
			    $('.content').append(' <br>'+dir.text+'<br>');
			}
		});
		
		$('.upload').click(function(){
		    $.post("http://files.komek.me:8080/cgi-bin/filemanager/utilRequest.cgi",
			    {
			        path: "first"
			    },
			    function(data, status){
			        console.log("\nStatus: " + status + ' '+data);
			    }
			);
		});
		
		
		
		
		/*
		var encodeString = ezEncode(utf16to8('password'));
		*/
		
	</script>

</body>
</html>