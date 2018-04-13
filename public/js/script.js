//Cookie functions
var setCookie = function(cname, cvalue) {
    
    document.cookie = cname + "=" + cvalue + ";path=/";
},

getCookie = function(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
};

$(document).ready(function(){
	
	var path = $('.js-path').val(); //take path value
	
	//if ENTER pressed on form 					 ****************************** *JS-ENTER-PRESS* keypress ***************************
	$(".js-enter-press input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            $('.js-submit').click();
            return false;
        } else {
            return true;
        }
    });
    
    
    //CLICK button to authentificate 					****************************** *JS-AUTH* click ******************************
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
					    			    
					    setCookie("nasSid", jsonData.authSid); //set NAS session id (SID) cookie
					    setCookie("serverName", jsonData.serverName); // set NAS ip adress cookie
					    setCookie("userName", jsonData.userName); // set user name cookie
					    
					   	window.open('./public/page.php',"_self") 
					 } else {
					    
					    $('.alert').addClass('alert-danger');
						$('.alert').html('You Login or Password is incorrect <br> Please try again');
				    }
			    }
			);
		}	
	});
	
	
	//Click on button to LIST file and SET LIMIT.       ****************************** *JS-SUBMIT* click ******************************
	$('.js-submit').on('click', function(){
			
			path= $('.js-path').val();
			
		var	limit= $('.js-limit').val();
			
		$.post("../app/src/list_files.php",
		    {
		        path: path,
		        limit: limit
		    },
		    function(data, status){

		        var jsonData = JSON.parse(data);
		        
		        if (!jsonData.sessionEnd){
			        
			        var fileString='<ul class="files-list js-files-list">';
			        	
			        $('.files-zone').empty();
			        
			        var jsonDataLeng = jsonData.datas.length; //take from QNAP API 'datas' array file list 

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
					alert('Session is ended, please re login')
				}
		    }
		);	    
	});
	
	
	//Click back button - for return to previous folder  ****************************** *JS-BACK* click ******************************
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
	
	
	//Click back button - for return to previous folder  ****************************** *JS-Create-DIR* click ******************************
	$('.js-create-dir').on('click', function(){
		
		path = $('.js-path').val(); //take value from path input field
		
		$.post("../app/src/create_dir.php",
			    {
			        path: path,
			        dirName: 'test'
			    },
			    function(data){
				    
					var jsonData = JSON.parse(data);
		        
					if (!jsonData.sessionEnd){ 
						
						switch (jsonData.status) {
						    case "ready":
						        $('.js-submit').click();
						        break;
						    case "exist":
						        alert('Folder Already Exist!'); 
						        break;
						    case "denied":
						    	alert('Access Denied');
						       
						}
						
					} 
					else { 
							alert('Session is ended, please re login'); 
					}
			    }
		    )
	});
	
	
	//Click on file item ( .js-file-item )	****************************** *JS-FILES-ZONE* length- if exist******************************
	if ($('.js-files-zone').length){
		
		
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
	
	
	//UPLOAD file to NAS.				***************************** *JS-UPLOAD-FORM* length- if exist ******************************
	if ($('.js-upload-form').length) {
		
		var fileForm = document.forms.namedItem("fileUpload");
	
		fileForm.addEventListener('submit', function(ev) {
			
		    var nasSid = getCookie('nasSid'),
		    	nasIp = getCookie('serverName'),
		    	userName = getCookie('userName'),
		    	dstPath = $('.js-path').val(),
				
				form_data = new FormData(fileForm);
				
				
				//append data to form
				form_data.append('sid', nasSid);
				form_data.append('ip', nasIp);
				form_data.append('user', userName);
				form_data.append('path', dstPath);
		    	
		    	
		    	$.ajax({
			        url: nasIp+"/index.php", // point to server-side PHP script 
			        dataType: 'text',  // what to expect back from the PHP script, if anything
			        cache: false,
			        contentType: false,
			        processData: false,
			        data: form_data,                         
			        type: 'post',
			        success: function(response){
				        
				        var jsonData = JSON.parse(response);
				        
			            if (jsonData.ready){ 		
					    	
					    	$('.alert').addClass('alert-success');
							$('.alert').html('Ready!');
							
							$('.js-submit').click();			    
					    
						 } else {
						    
						    $('.alert').addClass('alert-danger');
							$('.alert').html('Some Error Happened');
					    }
						
			        }
			     });
		    
		    ev.preventDefault();
		}, false);
	}
	
	
	console.log(getCookie('nasSid') + " " + getCookie('userName'));
})