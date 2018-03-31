<div class="container main-content">
	    
	<div class="path-and-limit js-enter-press" > 
	   <label for="path"> Path </label> <input type="text" class="js-path" id="path" value="/"/> <br>
	   <label for="limit"> Limit </label> <input type="text" class="js-limit" id="limit" value="50" />  <br>
	   <br>
	   <button class="js-submit" > List Files </button>
	   <br>
	   <br>
	   <button class="js-back" > <-Back </button>

	</div>
    
    <div class="alert" role="alert"> <!-- Something will go here... --></div>
    
    <div class="container files-zone js-files-zone"> <!-- js-files-list ul go here from JS script --></div>
    
    
    <br>
    <br>
    
    
    <form style="border: 1px dashed rgba(0, 0, 0, 0.58); padding: 30px" class="js-upload-form" enctype="multipart/form-data" method="post" name="fileUpload" >
	    
	  <input type="file" name="file" required="">
	  <input type="submit" value="Upload the file!" class="js-upload">
	  
	</form>
	
	    
</div>