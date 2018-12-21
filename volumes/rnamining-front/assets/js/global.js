var DEBUG = true;

var maxSizeMB = 20
var maxSizeUpload = 1024 * 1024 * maxSizeMB ;

var allowExtensionFasta = ["fasta","txt","fa"];

var haveError = false;
var execError = false;

var fadeInTime = 1500;

uploadFasta = false;

listColumns = false;

$(document).ready(function(){

	// SLIDERS

	$("#dropbut").click(function() {
        $("#dropparams").slideToggle('slow')
        if ($(this).hasClass('glyphicon-plus')) {
            $(this).removeClass('glyphicon-plus');
            $(this).addClass('glyphicon-minus');
        } else if ($(this).hasClass('glyphicon-minus')) {
            $(this).removeClass('glyphicon-minus');
            $(this).addClass('glyphicon-plus');
        }
    })


    // DISABLE OPTION IN EXEC
    $("#runRNAmining").click(function() {
    	$('#fastaData').addClass("disabled");
    	$('#organismslist').addClass("disabled");
    	$('#runRNAmining').addClass("disabled");
		$('#statusExecution').fadeIn();
    });



    $('input[name=Type]').change(function(){
 
	    $('#coding_type').val( $('input[name=Type]:checked').val() );
	    console.log($('#coding_type').val());
	 
	 });

});

function solveAll(value){

	var type = value;

	var element;

	this.setType = function(value){
		type = value;
	}

	this.getType = function(){
		return type;
	}

	this.setElement = function(value){
		element = value;
	}

	this.getElement = function(){
		return element;
	}

	/*this.cleanColumns = function(){
		columnFeatureID=false;
		columnLog2FoldChange=false;
		columnStatistics=false;
	}

	this.hideAlertsColumns = function(){
		$("#alertcolumnFeatureID").attr("hidden","true");
		$("#alertcolumnLog2FoldChange").attr("hidden","true");
		$("#alertcolumnStatistics").attr("hidden","true");
	}

	this.hideColumns = function(){
		$("#columnsSelect").attr("hidden","true");
		this.hideAlertsColumns();
	}*/

	this.uploadSuccess = function(){

		progressBar = $('#progressBar' + type);

		switch(type) {

			case "Fasta":
				//console.log("entroou")
				uploadFasta=true;

				// ALLOW NEW SEND
				$('#fastaData').removeClass("disabled");

			break;

		}


		if (uploadFasta){
	            $('#runRNAmining').removeAttr("disabled");
	            $('#fasta_sequences').attr("disabled",true);
	        }
		
		else{
	            $('#runRNAmining').attr("disabled",true);
	     		$('#fasta_sequences').removeAttr("disabled");
		}

		progressBar.removeClass('bg-danger');
		progressBar.addClass('bg-success');
		progressBar.html("UPLOAD COMPLETE");
		progressBar.removeClass('progress-bar-animated');

//		$("#columnsSelect").removeAttr("hidden");

//		this.hideAlertsColumns();
		
		haveError=false;
	}

	this.uploadFail = function(msg){

		this["upload" + type]=false;
		haveError=true;

		switch(type) {

			case "Fasta":

				uploadFasta=false;
				$('#fastaData').removeClass("disabled");

				break;

		}

		this.msgError(msg);
	}

	this.execSuccess = function(){

		execError=false;

		$('#loadingstatusExecution').hide();

		$('#statusExecutionMsg').html("Execução com sucesso!");

		//link = "results.php?opt=" + $("#optcheckedValue").val() + "&id=" + $("#exec").val();
		link = "results.php?opt=" + "&id=" + $("#exec").val();
		window.location.href = link;

	}

	this.execFail = function(msg){

		execError=true;

		$('#loadingstatusExecution').hide();

		$('#fastaData').removeClass("disabled");
    	$('#organismslist').removeClass("disabled");
    	$('#runRNAmining').removeClass("disabled");
    	$('#runRNAmining').attr("disabled",true)

		this.msgExecError(msg);
	}

	this.msgExecError = function(msg){

		$('#loadingstatusExecution').hide();

		$('#errorExecutionMsg').html(msg);

		//$('#statusExecution').attr("hidden","true");

		$('#statusExecution').hide();

		$('#alertErrorExecution').removeAttr("hidden");

	}

	this.msgError = function(msg){

		progressBar=$('#progressBar' + type);

		progressBar.removeClass('bg-success');
		progressBar.addClass('bg-danger');
		progressBar.hide();
		progressBar.fadeIn(fadeInTime);
		progressBar.html(msg);
		progressBar.width("100%");

		$('#runRNAmining').attr("disabled",true)

	}

}

exec = new solveAll();

/*
FASTA CHANGE - PRE-UPLOAD
*/
$('#fastaData').change(function(){
	var a = $(this),
		b = a.val(),
		c = b.substr(b.lastIndexOf('\\') + 1);
	a.next().next().html(c);

	if(DEBUG){
		console.info("=========== FASTA ===========");
	}

	exec.setType("Fasta");

	//exec.cleanColumns();

	//exec.hideColumns();

	$('#runRNAmining').attr("disabled",true);

	progressBar = $('#progressBar' + exec.getType());

	if($('#fastaData')[0].files[0]){
		var sizeFile = $('#fastaData')[0].files[0].size;
		var fileName = $("#fastaData")[0].files[0].name;
	}else{
		exec.msgError("Couldn't complete file upload because: The file wasn't sent");
		return 3;
	}

	if(DEBUG){
		console.info("Filename: " + fileName);
		console.info("Extension: " + fileName.split('.').pop());

		if ( fileName.includes(".") ){
			console.info("Have dot");
		} else {
			console.info("Not have dot");
		}

	}

	// IF FILE HAVE EXTENSION
	if ( fileName.includes(".") ){
		
		// GET EXTENSION
		extensionFile = fileName.split('.').pop();

		// IF EXTENSION IS ALLOW
		// INDEXOF RETURN -1 IF EXTENSION NOT FOUND
		if ( allowExtensionFasta.indexOf(extensionFile) != -1 ){

			if(DEBUG){
				console.info("Extension FOUND in allow - return: " + allowExtensionFasta.indexOf(extensionFile));
			}

		// IF EXTENSION NOT ALLOW
		}else{

			if(DEBUG){
				console.info("Extension NOT FOUND in allow - return: " + allowExtensionFasta.indexOf(extensionFile));
			}

			exec.msgError("Please, send files with the following extension(s): txt, fasta or fa");
			return 1;

		}

	// IF FILE NOT HAVE EXTENSION
	} else {

		if(DEBUG){
			console.info("File without extension");
		}

		exec.msgError("File without extension. Please, send files with the following extension(s): txt, fasta or fa.");
		return 1;
	}

	// TEST FILE SIZE
	if (sizeFile > maxSizeUpload){
		exec.msgError("File is too large. The file size limit is " + maxSizeMB + " MB");
		return 2;
	}

	// BLOCK FOR NOT TRY SEND OTHER WHILE SEND
	$('#fastaData').addClass("disabled");

	// SUBMIT
	$('#formUploadFasta').submit();
});

/*
FASTA SUBMIT
*/
$('body').on('submit','#formUploadFasta', function(e){
	e.preventDefault();
	haveError=false;
  	var formData = new FormData($(this)[0]);
  	progressBar = $('#progressBarFasta');
  	progressBar.removeClass('bg-success');
  	progressBar.removeClass('bg-danger');
  	$("#alertErrorFasta").hide();
	$.ajax({
		url : "/assets/scripts/upload.php",
		type: "POST",
		processData: false,
		contentType: false,
	    data: formData,
	    xhr: function(){
	      xhr = new window.XMLHttpRequest();
	      xhr.upload.addEventListener("progress", function(evt){
	        if(evt.lengthComputable){

        	    progress_percent_full = (evt.loaded / evt.total) * 100;
			    var new_width = progress_percent_full + "%";

			    percent = parseInt(progress_percent_full) + "%";

			    progressBar.width(new_width).text(percent);

				if(DEBUG){
					console.log('FASTA SIZE: ' + (evt.total));
					console.log('FASTA PERCENT: ' + (percent));
					console.log('FASTA LOADED: ' + (evt.loaded));
				}

	        }
	      }, false);
	      return xhr;
	    },
	   	success: function(data){
	   		if(DEBUG){
	   			console.info("entry success - fasta");
	   			console.info(data);
	   		}

			if (data.error) {
				exec.uploadFail(data.error);				
			} else if (data.columns) {
				exec.listColumns(data);
			}
	    },
	    error: function(data){
	    	if(DEBUG){
		    	console.info("entry error - fasta");
		    	console.info(data);
		    }

	    	if (data.error){
	    		exec.uploadFail(data.error);
			}
	    },
	    complete: function(data){
	    	if(DEBUG){
	    		console.info("entry complete - fasta");
	    		console.info(data);
	    		console.info("Erro: " + haveError);
	    	}

	    	// if not have error
	    	if (!haveError){
	    		exec.uploadSuccess();
	    	}
	    }
  	});
});

/*
FORMDATA SUBMIT
*/
$('body').on('submit','#formData', function(e){
	e.preventDefault();
	exec.setType("Formdata");
	execError = false;

  	var formData = new FormData($(this)[0]);
	$.ajax({
		url : "/assets/scripts/executionR.php",
		type: "POST",
		processData: false,
		contentType: false,
    	data: formData,

		success: function(data){
			if(DEBUG){
				console.log("============ entry success - FORMDATA ============");
				console.log(data);
			}

			if (data.error) {

				exec.execFail(data.error);

			}
    	},

	    error: function(data){
	    	if(DEBUG){
		    	console.info("============ entry error - FORMDATA ============");
		    	console.info(data);
		    }

	    	if (data.error) {

	    		exec.execFail(data.error);

	    	}
	     
	    },

	    complete: function(data){
	    	if(DEBUG){
		    	console.info("============ entry complete - FORMDATA ============");
		    	console.info(data);
		    	//console.info(data.return);
		    }

	    	if (!execError){

	    		exec.execSuccess();
	    	}
	    }
	});
});
