$(document).ready(function(){
	
	var path = $('.js-path').val(); //take path value
	
	//on input form "Enter" button pressed equel to "js-submit" button pressed
	$(".js-enter-press input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            $('.js-submit').click();
            return false;
        } else {
            return true;
        }
    });
    
    
    //CLICK button to authentificate 
	$('.js-auth').on('click',function(){
		
		var login = $('.js-auth-login').val();
			pass = $('.js-auth-pass').val();
			
		if (login==''){
			$('.alert').addClass('alert-danger');
			$('.alert').html('Please type your login');
			
		}else if (pass==''){
			$('.alert').addClass('alert-danger');
			$('.alert').html('Please type your password');
			
		} else {
			
			pass = ezEncode(utf16to8(pass));
			//$('.alert').addClass('alert-danger');
			//$('.alert').html(login+' '+pass);
			
			$.post("./app/src/auth.php",
			    {
			        login: login,
			        pass: pass
			    },
			    function(data, status){
				    
				    var jsonData = JSON.parse(data);
				    
				    if (jsonData.authPassed){ 
					    document.cookie = "nasSid = "+jsonData.authSid;
					   	window.open('./public/page.php',"_self") 
					 } else {
					    
					    $('.alert').addClass('alert-danger');
						$('.alert').html('You Login or Password is incorrect <br> Please try again');
				    }
			        // console.log( jsonData.authPassed+" "+jsonData.authSid+" "+jsonData.sessionId );
			    }
			);
		}	
	});
	
	
	//Click on button to LIST file and SET LIMIT
	$('.js-submit').click(function(){
			
			path= $('.js-path').val();
			
		var	limit= $('.js-limit').val();
			
		$.post("../app/src/list_files.php",
		    {
		        path: path,
		        limit: limit
		    },
		    function(data, status){

		        var jsonData = JSON.parse(data),
		        	jsonDataLeng = jsonData.datas.length; //take from QNAP API 'datas' array file list 
		        
		        if (!jsonData.sessionEnd){
			        
			        var fileString='<ul class="files-list js-files-list">';
			        	
			        $('.files-zone').empty();
			        
			        for (var i = 0; i < jsonDataLeng; i++) {
				        
					    var file = jsonData.datas[i];
					    
					    fileString +='<li class="file-item list-group-item js-file-item" >';
					    
					    if (file.isfolder){fileString += '<img class="ico-folder" src="img/folder_ico.png" height=15px/>'}; //check if file item is folder
					    fileString += file.filename;
					    
					    fileString += '</li>';
					}
					
					fileString +='</ul>';
					
					$('.js-files-zone').append(fileString);	
				} else //session ended- need to relogin
				{
					alert('Session ended!')
				}
		    }
		);	    
	});
	
	
	//Click back button - for return to previous folder 
	$('.js-back').on('click', function(){
		
			path = $('.js-path').val(); //take value from path input field
		var slash = path.lastIndexOf("/"); //find last slash symbol
		
		
		if(path.length>1 && slash===0){ //if path is '/' only 
			
			var result = path.slice(0,1); //slice string 
			
			$('.js-path').val(result);
			
			
			
		} else if(path.length>1 && slash!=0){
			
			var result = path.slice(0,slash); //slice string 
			
			$('.js-path').val(result);
			
		};
		
		
		$('.js-submit').click();

		
	});
	
	
	//Click on file item ( .js-file-item )
	if ($('.js-files-zone').length){
		
		console.log(document.cookie);
		
		$('.js-submit').click(); //show file list on load Files Zone
		
		path = $('.js-path').val(); //take value from path input field

				
		$('.js-files-zone')
		.on('click','.js-file-item',function(){
						
			//highlight file item in file zone
			$('.js-file-item').removeClass('file-item-active');
			$(this).addClass('file-item-active');
			
		});
		
		$('.js-files-zone')
		.on('dblclick','.js-file-item',function(){
		
			if(path == '/'){
				path+= $(this).text();
				
			} else { 
				path= path+'/'+$(this).text();
			};
			
			$('.js-path').val(path);
			
			$('.js-submit').click();
		});
	}
	

	
	
	//Upload a file to NAS.
	if ($('.upload-form').length) {
		
		var fileForm = document.forms.namedItem("fileInfo");
	
		fileForm.addEventListener('submit', function(ev) {
			
		    var documentUpload = document.querySelector(".files"),
		    	nasSid = $('.upload-form').data('sid'),
		    	nasIp = $('.upload-form').data('server'),
				
				data = new FormData(fileForm),
		    	uploadFile = data.get("file"),
		    	
		    	dstPath = $('.js-path').val(),
		    	progress = '-' + uploadFile.name,
		    	request = new XMLHttpRequest();
		    	
		    	
		    request.open("POST", nasIp + "/cgi-bin/filemanager/utilRequest.cgi?sid=" + nasSid + "&func=upload&type=standard&dest_path=" + dstPath + "&overwrite=1&progress=" + progress, true);
		    request.onload = function(oEvent) {
			    if (request.status == 200) 
			    {
			        var result = JSON.parse(this.responseText);
			        if (result.status == 1) {
			          documentUpload.innerHTML = "File " + uploadFile.name + " is uploaded to path /share" + dstPath + ".";
			        } else {
			          documentUpload.innerHTML = "File " + uploadFile.name + " is not uploaded successfully.";
			        }
			    } else 
			    {
			        documentUpload.innerHTML = "Error " + request.status + " occurred when trying to upload your file.</br>";
				}
		    };
		    request.send(data);
		    ev.preventDefault();
		}, false);
	}
})


 /*$.ajax({
			    type:	'post',
			    url: 	nasIp + "/cgi-bin/filemanager/utilRequest.cgi?sid=" + nasSid + "&func=upload&type=standard&dest_path=" + dstPath + "&overwrite=1&progress=" + progress,
			    
			    success: function(result,status,xhr){
            	
	            	var jsonData = JSON.parse(result);
	            	console.log(result,status,xhr);
            	
            	},
            	
            	error: function(xhr,status,error){
	            	console.log(xhr + ' /n ' + status + ' /n ' + error);
            	}
            	
			});*/