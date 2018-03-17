<div class="container main-content">
	    
	    
	<div class="form"> 
	   <input type="text" class="path js-path" value="/"/> <br>
	   <input type="text" class="js-limit" value="50" hidden/>  <br>
	   <br>
	   <button class="js-path-limit js-submit" hidden> List Files </button>
	</div>
    
    <div class="alert" role="alert"> <!-- Something will go here... --></div>
    
    <div class="container files-zone js-files-zone"> <!-- js-files-list ul go here from JS script --></div>
    
    
    <br>
    <br>
    
    
    <form style="border: 1px dashed rgba(0, 0, 0, 0.58); padding: 30px" class="upload-form" enctype="multipart/form-data" method="post" name="fileInfo" data-sid='<?php echo $_SESSION["authSid"];?>' data-server='<?php echo $server_name; ?>'>
	  <input type="file" name="file" required="">
	  <input type="submit" value="Upload the file!" class="js-upload">
	</form>
	
	<input class="js-test" type="submit" style="margin-top: 60px"/>
	    
</div>