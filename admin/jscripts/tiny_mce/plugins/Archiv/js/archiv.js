var archiv = {
	/*
		Pre-initialize the plugin
	*/
	preInit : function() {
		// language pack
		tinyMCEPopup.requireLangPack();		
	},

	/*
		Initialize the vars & gets settings from config.php
	*/
	init : function(){
		try{	
			// Globals
			this.SettingsFile 	= tinyMCE.activeEditor.getParam('Archiv_settings_file');	
			this.Connector   	= null;					// connector file	
			this.CurrentDir  	= null; 				// the dir we are currently watching (element)
			this.CurrentPath 	= null;					// the path of the current dir we are watching
			this.DirList 		= Array(); 				// array of directory's we have fetched from the server
			this.ContentList 	= Array(); 				// array of files we have fetched from the server
			this.InfoArray   	= Array();
			this.BrowserType 	= this.gup('type');		// find out if we are a file or a image browser
			this.Parameter 		= this.timestamp();		// Some browsers have a problem with cashing a HTTPX request, so we add a time parameter
			this.Debug			= "true";					// Debug settings (enabled by default)
			this.SecurityAdd	= null;			
						
			// settings
			archiv.getSettings();			
		}
		catch(e){
			this.debug(arguments.callee,e);
		}	
	},
	
	/*
		Register all vars & starts the processing
	*/
	postinit : function(){
		try{
			// Set the connector
			this.Connector = this._connector;
			
			// Set debug
			this.Debug = this._debug
			
			// Set passphrase
			if(this._security_passphrase){
				this.SecurityAdd = "&security_passphrase="+this._security_passphrase;
			}
			
			// Set password
			if(this._security_password){
				this.SecurityAdd = "&security_password="+this._security_password;
			}			
		
			// Load the functions
			this.build_swfupload();	
			this.getTreePopulation();
			this.getContentPopulation(null,"/");
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	/*
		Function will get the settings form config.php
	*/
	getSettings : function (){	
		try{	
			new Ajax.Request(this.SettingsFile+"?js",
			{
			  method:'get',
			  onSuccess: function(transport){	
			  	try{			
				    if(transport.responseXML != null){
				    	var response = transport.responseXML;
						response = response.documentElement; // fix for IE7
						
				   	 	archiv._connector 			= response.childNodes[0].firstChild.nodeValue;
				   	 	archiv._path 				= response.childNodes[1].firstChild.nodeValue;
				   	 	archiv._files 				= response.childNodes[2].firstChild.nodeValue;
				   	 	archiv._image_files 		= response.childNodes[3].firstChild.nodeValue;
				   	 	archiv._file_size_limit 	= response.childNodes[4].firstChild.nodeValue;
				   	 	archiv._file_upload_limit 	= response.childNodes[5].firstChild.nodeValue;
						archiv._debug 				= response.childNodes[6].firstChild.nodeValue;
				   	 	archiv._security_passphrase	= (response.childNodes[7].firstChild != null) ? response.childNodes[7].firstChild.nodeValue : null;

				   	 	if(response.childNodes[8].firstChild.nodeValue == "3"){
				   	 		password = Prompt.show(tinyMCEPopup.getLang('Archiv.QuestionPassword')+":");
				   	 		archiv._security_password = password;
				   	 	}
				   	 	
				   	 	archiv.postinit();
				    }
				    else{
				    	archiv.displayError(tinyMCEPopup.getLang('Archiv.ErrorReadingSettingsFile')+" `"+ tinyMCE.activeEditor.getParam('Archiv_settings_file')+"?js`<br />"+transport.responseText);
				    }
				 }
				 catch(e2){
						archiv.debug(arguments.callee,e2);
				 }
			  },
			  onFailure: function(){ archiv.displayError(tinyMCEPopup.getLang('Archiv.ErrorReadingSettingsFile')+" `"+ tinyMCE.activeEditor.getParam('Archiv_settings_file')+"?js`"); }
			});
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	/*
		Function to get the current timestamp
	*/
	timestamp : function(){
		var now 	= new Date();
		var hour 	= now.getHours();
		var min 	= now.getMinutes();
		var sec 	= now.getSeconds();	
		
		return hour+''+min+''+sec;
	},
	
	/*
		Fungtion get GET parameter from url
	*/
	gup : function( name )
	{		
		try{
			name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
			var regexS = "[\\?&]"+name+"=([^&#]*)";
			var regex = new RegExp( regexS );
			var results = regex.exec( window.location.href );
			if( results == null )
				return "";
			else
				return results[1];
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},	
	
		
	/*
		Function will get the dir list from connector and call populateTreeView()
	*/
	getTreePopulation : function (){
		try{		
			this.showLoading("loader_tree");
			
			new Ajax.Request(this.Connector+"?get=dirList&settings_file="+this.SettingsFile+"&time="+this.Parameter+"&browser="+this.BrowserType+this.SecurityAdd,
			{
			  method:'get',
			  onSuccess: function(transport){	  	
			    var response = transport.responseXML || null;
			    // we have folders		    
			    if(response != null || (response != null && response.documentElement != null)){		    	
			   	 	archiv.populateTreeView(response);
			    	archiv.stopLoading("loader_tree");
			    }
			    // we only have a root
			    else{
			    	archiv.populateTreeView(null);
			    	archiv.stopLoading("loader_tree");
			    	//archiv.displayError(tinyMCEPopup.getLang('Archiv.ErrorLoadingTree'));
			    }
			  },
			  onFailure: function(){ archiv.displayError(tinyMCEPopup.getLang('Archiv.ErrorLoadingTree')); }
			});
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	/*
		Function will get the dir list from connector and call populateTreeView()
	*/
	getContentPopulation : function (folderObj,folderPath){
		try{
			this.showLoading("loader_browser");
			
			if(folderObj != null)
				this.setCurrentDir(folderObj,folderPath);
			
			this.CurrentPath = folderPath; //getPath(CurrentDir);		
			
			new Ajax.Request(this.Connector+"?get=dirContent&settings_file="+this.SettingsFile+"&time="+this.Parameter+"&folderRoot="+this.CurrentPath+"&browser="+this.BrowserType+this.SecurityAdd,
			{
			  method:'get',
			  onSuccess: function(transport){		  	
			  	archiv.clearDirContent();
			    var response = transport.responseXML || null;		    
	
			    if(archiv.CurrentPath != "/"){
		   	 		$("removeFolder").style.display = "block";
		   	 	}
		   	 	else{
		   	 		$("removeFolder").style.display = "none";
		   	 	}
				
			    if(response != null && (response != null && response.documentElement != null)){
			   	 	archiv.populateContentView(response);		   	 	
			    	archiv.stopLoading("loader_browser");
			    }
			    else{
			    	archiv.displayError(tinyMCEPopup.getLang('Archiv.NoFiles')+"<br />"+transport.responseText);
			    	archiv.stopLoading("loader_browser");
			    }
			  },
			  onFailure: function(){ archiv.displayError(tinyMCEPopup.getLang('Archiv.ErrorLoadingDirContent')); }
			});		
		}
		catch(e){
			this.debug(arguments.callee,e);
		}	
	},

	/*
		Function will set the current dir to a givven var
	*/
	setCurrentDir : function (Obj,folderPath){
		try{
			if(this.CurrentDir != null){
				this.CurrentDir.className = "";
			}
			
			this.CurrentDir = Obj;
			this.CurrentDir.className = "selectedDir";
			
			this.setCurrentDirLabel(folderPath);
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
		
	/*
		Function will (re)populate the treeview with the given array
	*/
	populateTreeView : function (content){	
		try{
			// fix for IE7
			content = content != null ? content.documentElement : null;
	
			if(content != null){					
				this.DirList = this.xmlToUL(content);
			}
			else{
				this.DirList = "";
			}
			
			this.DirList = "<ul id=\"sitemap\">"+
							"<li><a href=\"javascript:void(0);\" onclick=\"archiv.getContentPopulation(this,'/');\" id=\"/\">/</a>"+
							"<ul>"+
							this.DirList+
							"</ul></li>"+
						"</ul>";
			
			this.setDirList(this.DirList);
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	
	/*
		Function will transform our XML data into a nice list of dirs
	*/
	xmlToUL : function(node,path) {	
		try{
			path = (path) ? path : "";
			var list = "";	
	
			for(var i = 0; i < node.childNodes.length; i++){
				if(node.childNodes[i].firstChild.childNodes.length == 1){	
					list += "<li><a href=\"javascript:void(0);\" onclick=\"archiv.getContentPopulation(this,'"+path+"/"+node.childNodes[i].firstChild.firstChild.nodeValue+"');\" id=\""+path+"/"+node.childNodes[i].firstChild.firstChild.nodeValue+"\">"+node.childNodes[i].firstChild.firstChild.nodeValue+"</a>";
				}		
				
				if(node.childNodes[i].childNodes.length > 1){			
					for(var ii = 1; ii < node.childNodes[i].childNodes.length; ii++){	
						list += "<ul>"+this.xmlToUL(node.childNodes[i],(path+"/"+node.childNodes[i].firstChild.firstChild.nodeValue))+"</ul>";
					}					   
				}
				
				list += "</li>";			
			 }		 
			
			return list;
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	/*
		Get the path of the object (the DOM way) 
	*/
	getPath : function(obj){
		try{
			path = obj.innerHTML;
		
			tmpObj = obj.parentNode;
		
			for(counter=0; (typeof tmpObj.parentNode.id != null && tmpObj.parentNode.id != "treeView");counter++){
				if(tmpObj.nodeName == "UL"){
					path = tmpObj.parentNode.innerHTML+"/"+path;
				}
				tmpObj = tmpObj.parentNode;
			}
		
			this.CurrentPath = "/"+path;
		
			return "/"+path;
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},	
	
	/*
		Function wil (re)populate the contentview with the given array
	*/
	populateContentView : function(content){
		try{
			dirContent = "";
			infoArray = Array();		
				
		    // fix for IE7
			content = content.documentElement;
			
			path = (this.CurrentPath != null) ? this.CurrentPath : "/";
	
			//loop all files
			for(var i = 0; i < content.childNodes.length; i++){		
				dirContent += "<div class=\"file\"><img src=\""+content.childNodes[i].childNodes[2].firstChild.nodeValue+"\" alt=\"\" id=\"file"+i+"\"  onclick=\"archiv.insertFile('"+path+"','"+content.childNodes[i].childNodes[1].firstChild.nodeValue+"')\" /><div class=\"info transp80\" id=\"file"+i+"_info\"></div>"+content.childNodes[i].childNodes[0].firstChild.nodeValue+"<div class=\"delete\" id=\"file"+i+"_delete\" title=\""+tinyMCEPopup.getLang('Archiv.FileDelete')+"\" onclick=\"archiv.deleteFile('"+content.childNodes[i].childNodes[1].firstChild.nodeValue+"','"+path+"',this);\"></div></div>";
				infoArray[i] = Array("file"+i+"_info","<table><tr><th>"+tinyMCEPopup.getLang('Archiv.FileName')+":</th><td>"+content.childNodes[i].childNodes[1].firstChild.nodeValue.substr(33)+"</td></tr><tr><th>"+tinyMCEPopup.getLang('Archiv.FileType')+":</th><td>"+content.childNodes[i].childNodes[3].firstChild.nodeValue+"</td></tr><tr><th>"+tinyMCEPopup.getLang('Archiv.FileSize')+":</th><td>"+content.childNodes[i].childNodes[4].firstChild.nodeValue+"</td></tr><tr><th>"+tinyMCEPopup.getLang('Archiv.FileDimentions')+":</th><td>"+content.childNodes[i].childNodes[5].firstChild.nodeValue+"</td></tr></table>");
			 }
			 
			this.setDirContent(dirContent,infoArray,this.Connector,this.Parameter);
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	/*
		Function adds a server to the list, then refreshes the dirList
	*/
	addFolder : function(folderName){		
		try{
			folderRoot = (this.CurrentPath!=null) ? this.CurrentPath : "/";
	
			new Ajax.Request(this.Connector+"?do=addMap&settings_file="+this.SettingsFile+"&time="+this.Parameter+"&dirName="+folderName+"&dirRoot="+folderRoot+this.SecurityAdd,
			{
			  method:'get',
			  onSuccess: function(transport){
			    var response = transport.responseText || null;
			    if((response != null || (response != null && response.documentElement != null)) && (response == "ok" || response.responsedocumentElement=="ok")){
					archiv.getTreePopulation();
					archiv.displayError("Directory `"+folderName+"` added!",2000);
			    }
			    else{
			    	archiv.displayError(response);
			    }
			  },
			  onFailure: function(){ archiv.displayError(tinyMCEPopup.getLang('Archiv.ErrorAddingFolder')); }
			});
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	/*************** FILETREE FUNCTIONS **********************/
	/*
		Function sets the folder structure in the HTML
	*/
	setDirList : function(dirList){
		$("treeView").innerHTML = dirList;
	},
	
	/*
		Show the loading image
	*/
	showLoading : function(el){
		$(el).style.display = "block";
	},
	
	/*
		Hide the loading image
	*/
	stopLoading : function(el){
		$(el).style.display = "none";
	},
	
	/*
		Ask for the name of the new folder
	*/
	askFolderName : function(){
		try{
			folderName = Prompt.show(tinyMCEPopup.getLang('Archiv.QuestionFolderName')+":");
			
			if(folderName != "" && folderName != null){
				this.addFolder(folderName);
			}
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	/***************** FILECONTENT FUNCTIONS *************************/
	/*
		Insert the file into the editor by the way the type is defined
	*/
	insertFile : function(thePath,theFile){
		try{
			if(this.BrowserType == "images")
				this.insertImageAndClose(thePath,theFile);
			else
				this.insertFileAndClose(thePath,theFile);
		}
		catch(e){
			this.debug(arguments.callee,e);
		}			
	},
	
	/*
		Insert the file as a link
	*/	
	insertFileAndClose : function(thePath,theFile) {
		try{		
			absPath = this._path;	
			tinyMCEPopup.editor.execCommand('mceInsertContent', false, "<a href=\""+absPath+thePath+"/"+theFile+"\" title=\""+theFile.substr(33)+"\">"+theFile.substr(33)+"</a>");
			tinyMCEPopup.close();
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	/*
		Insert the file as a image
	*/	
	insertImageAndClose : function(thePath,theImage) {
		try{
			absPath = this._path;			
			tinyMCEPopup.editor.execCommand('mceInsertContent', false, "<img src=\""+absPath+thePath+"/"+theImage+"\" alt=\""+theImage.substr(33)+"\" />");
			tinyMCEPopup.close();
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
		
	/*
		SWFupload constructor
	*/
	build_swfupload : function(){
		try{
			// get the absolute path of the plugin
			plugin_abspath = window.location.href.substring(0,window.location.href.lastIndexOf("/")+1);
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
		
		try{
			if(!this.swfu){
				this.swfu = new SWFUpload({
					// Backend Settings
					upload_url: plugin_abspath+archiv.Connector+"?do=addFile&settings_file="+archiv.SettingsFile+"&path="+$('currentFolder').innerHTML+"&browser="+archiv.BrowserType,	// Relative to the SWF file
					//post_params: {"PHPSESSID": "<?php echo session_id(); ?>"},				
		
					// File Upload Settings
					file_size_limit 		: archiv._file_size_limit, 											 				//"52100",	// 50MB
					file_types 				: (archiv.BrowserType == "images") ? archiv._image_files  : archiv._files ,	//"*.jpg",
					file_types_description 	: (archiv.BrowserType == "images") ? "Images" : "Files",
					file_upload_limit 		: archiv._file_upload_limit, 											 				//"0",
					file_queue_limit 		: 0,
					button_image_url 		: "img/SmallSpyGlassWithTransperancy_17x18.png",	// Relative to the SWF file
					button_placeholder_id 	: "spanButtonPlaceholder",
					button_width			: 180,
					button_height			: 18,
					button_text 			: '<span class="button">Select Files</span>',
					button_text_style 		: '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
					button_text_top_padding	: 0,
					button_text_left_padding: 18,
					button_window_mode		: SWFUpload.WINDOW_MODE.TRANSPARENT,
					button_cursor			: SWFUpload.CURSOR.HAND,


					// Event Handler Settings - these functions as defined in Handlers.js
					//  The handlers are not part of SWFUpload but are part of my website and control how
					//  my website reacts to the SWFUpload events.
					file_queue_error_handler 		: fileQueueError,
					file_dialog_complete_handler 	: fileDialogComplete,
					upload_progress_handler 		: uploadProgress,
					upload_error_handler 			: uploadError,
					upload_success_handler 			: uploadSuccess,
					upload_complete_handler 		: uploadComplete,
		
					// Flash Settings
					flash_url : plugin_abspath+"swf/swfupload_f10.swf",	// Relative to this file
		
					custom_settings : {
						upload_target : "divFileProgressContainer"
					},
					
					// Debug Settings
					debug: false
				});	
			}
			else{
				this.swfu.setUploadURL(plugin_abspath+archiv.Connector+"?do=addFile&settings_file="+archiv.SettingsFile+"&path="+$('currentFolder').innerHTML+"&browser="+archiv.BrowserType);
			}
		}
		catch(e){
			this.debug(arguments.callee,e);
		}				
	},
    
    /*
    	Set the current directory in HTML and SWFupload
    */
    setCurrentDirLabel : function(dirName){   
    	try{ 	
	    	document.getElementById('currentFolder').innerHTML = dirName;
	    	this.build_swfupload();
	    }
		catch(e){
			this.debug(arguments.callee,e);
		}
    },    
		
	/*
		Set the content of the dir and the additional file info
	*/	  
	setDirContent : function(dirContent, infoArray, connector, parameter){
		try{
			tipTop 		= "<div class=\"title\">"+tinyMCEPopup.getLang('Archiv.FileInfo')+"</div>";
			tipBottom 	= "<div class=\"bottom\">"+tinyMCEPopup.getLang('Archiv.FileClickToAdd')+"</div>";
			$("fileHolder").innerHTML = dirContent;
	
			for(i=0; i < infoArray.length;i++){
			
				this.InfoArray[infoArray[i][0]] = infoArray[i][1];
				
				$(infoArray[i][0]).onmouseout = function(){				
					//archiv.hideFileInfo();	
					//tooltip.hide();		
					//UnTip();
					$('tooltip').innerHTML = "";
					$('tooltip').style.display = "none";
				}
						
				$(infoArray[i][0]).onmouseover = function(){				
					//archiv.showFileInfo(this,tipTop+"<div class=\"content\">"+archiv.InfoArray[this.id]+"</div>"+tipBottom);
					//tooltip.show(tipTop+"<div class=\"content\">"+archiv.InfoArray[this.id]+"</div>"+tipBottom,220);
					//Tip('test');
					$('tooltip').innerHTML = tipTop+"<div class=\"content\">"+archiv.InfoArray[this.id]+"</div>"+tipBottom;
					$('tooltip').style.display = "block";
				}			
			}
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},
	
	/*
		Clear the dircontent
	*/
	clearDirContent : function(){
		try{
			document.getElementById("fileHolder").innerHTML = "";
			this.hideError();
		}
		catch(e){
			this.debug(arguments.callee,e);
		}
	},

	/*
		Delete a file from the server
	*/
	deleteFile : function(fileName, path, obj){
		try{	
			awnser = confirm(tinyMCEPopup.getLang('Archiv.ConfirmDeleteFile')+" `"+path+fileName.substr(33)+"`?");
			if(awnser == true){
				new Ajax.Request(this.Connector+"?do=deleteFile&settings_file="+this.SettingsFile+"&time="+this.Parameter+"&fileName="+fileName+"&fileRoot="+path+this.SecurityAdd,
				{
				  method:'get',
				  onSuccess: function(transport){
				    var response = transport.responseText || null;
				    if((response != null || (response != null && response.responsedocumentElement != null)) && (response=="ok" || response.responsedocumentElement =="ok")){
				   	 	obj.parentNode.style.display="none";
				   	 	archiv.displayError("File `"+fileName.substr(33)+"` deleted!",2000);
				    }
				    else{
				    	archiv.displayError(response);
				    }
				  },
				  onFailure: function(){ archiv.displayError(tinyMCEPopup.getLang('Archiv.ErrorDeletingFile')); }
				});
			}	
		}
		catch(e){
			this.debug(arguments.callee,e);
		}	
	},
	
	/*
		Delete a folder from the server
	*/
	deleteFolder : function(path){
		try{
			awnser = confirm(tinyMCEPopup.getLang('Archiv.ConfirmDeleteFolder')+" `"+path+"`?");
			if(awnser == true){
				new Ajax.Request(this.Connector+"?do=deleteFolder&settings_file="+this.SettingsFile+"&time="+this.Parameter+"&fileRoot="+path+this.SecurityAdd,
				{
				  method:'get',
				  onSuccess: function(transport){
				    var response = transport.responseText || null;
				    if((response != null || (response != null && response.responsedocumentElement != null)) && (response=="ok" || response.responsedocumentElement =="ok")){
				   	 	archiv.getTreePopulation();
				   	 	archiv.getContentPopulation(null,"/");
				   	 	archiv.displayError("File `"+path+"` deleted!");
				    }
				    else{
				    	archiv.displayError(response);
				    }
				  },
				  onFailure: function(){ archiv.displayError(tinyMCEPopup.getLang('Archiv.ErrorDeletingFolder')); }
				});
			}
		}
		catch(e){
			this.debug(arguments.callee,e);
		}		
	},
	
	/*
		Display a error
	*/
	displayError: function(errorMsg, displayTime){
		$('error').style.display = "block";
		$('error').innerHTML = errorMsg;
		//FadeIn($('error'), 50);
		
		if(displayTime != null)
			setTimeout("archiv.hideError()",displayTime);
	},
	
	/*
		Hide the error
	*/
	hideError: function(){
		//alert("hideError");
		$('error').innerHTML = "";
		$('error').style.display = "none";
		//FadeOut($('error'), 50);
	},
	
	debug: function(callerFunction, message){	
		if(this.Debug == "true")
			alert("ERROR:\r\n"+message.message +"\r\n\r\n FUNCTION:\r\n"+callerFunction);
		else
			alert("Error, please restart the filemanager!");
	}	
}

archiv.preInit();	
tinyMCEPopup.onInit.add(archiv.init, archiv);	