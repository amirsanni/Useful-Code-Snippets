'use strict';

var appRoot = "http://localhost/merger/";

$(document).ready(function(){
	
	//WHEN THE SELECT FILES BUTTON IS CLICKED
	$("#selFilesBtn").click(function(e){
		e.preventDefault();
		
		//trigger the click event on the hidden file input
		$("#ftm").click();
	});
	
	
	//WHEN FILES ARE SELECTED
	$("#ftm").change(function(e){
		e.preventDefault();
		
		//get the names of each file and display a file icon labelling each with the file name
		var allFiles = $(this).get(0).files
		var totFile = allFiles.length;
		
		for(var i = 0; i < totFile; i++){
			var fileName = allFiles[i].name;
			
			var div = "<div><i class='fa fa-file'></i> "+fileName+"</div>";
			
			$("#displaySelectedFilesHere").prepend(div);
		}
		
	});
	
	
	
	//WHEN "MERGE FILES" IS CLICKED
	$("#mergeBtn").click(function(e){
		e.preventDefault();
		
		//get all files and send to server
		var files = $("#ftm").get(0).files;
		
		var fd = new FormData();
		
		for(var i = 0; i < files.length; i++){
			fd.append('all_files[]', files[i]);
		}
		
		$.ajax({
			url: appRoot+"Lib/Merger.php",
			data: fd,
			processData: false,
			method: "POST",
			contentType: false
		}).done(function(rd){
			var a = "<br>" + rd;
			
			$("#displaySelectedFilesHere").append(a);
		});
	});
});
