<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html>
<head>
    <?php include("pages/head.php"); ?>
    <title>Analysis - RNAmining</title>
</head>

<body>
    <?php include("pages/navbar.php"); ?>

    <?php $GLOBALS['DIR_RANDOM'] = md5(date('Y-m-d H:i:s.') . gettimeofday()['usec']) ; ?>

    <div class="container-fluid" style="padding-top:100px;">

        <form enctype="multipart/form-data" id="formUploadFasta">
            <input type="hidden" name="exec" value="<?php echo $DIR_RANDOM ?>">
                <h2 class="text-center portfolio-text">Upload your files</h2>
                <div class="container" style="text-align:center;">
                    <h4 class="text-center">Dataset</h4>
                    <p> <a href='/examples/file.fasta'>.fasta</a> - <a href='/examples/dataset.zip'>examples</a> </p>
                    <img class="img-responsive" style="height:auto;max-width: 100%;margin:0 auto;display:block;padding-bottom:0;" src="../assets/images/Example.png"></img>
                    
                    
                    <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                        <input id="fastaData" type="file" name="fastaData" class="btn btn-default btn-file center-block dz-clickable" accept=".fasta,.txt,.fa" required style="margin-bottom:2%;width:100%;">
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                        <div class="progress" data-action="progress">
                            <div class="progress-bar progress-bar-striped" id="progressBarFasta" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="transition: width 1s;"></div>
                        </div>
                    </div>

                    
		<!--<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
			<div id = "sequences" name = "sequences">
        	        	<h4 class="portfolio-text">Fasta Sequences</h4>
               			<textarea id = "fasta_sequences" name = "fasta_sequences" style = "width:100%; height:300px;">
                        
                		</textarea>
	        	</div>
		</div>-->

		
		<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
            <div id = "Run_Type" name = "Run_Type">
                    <h4 class="portfolio-text">Execution Options</h4>
                    <input id = "Coding_Prediction" type = "radio" name = "Type" value = "coding_prediction" checked="checked">
    				<label for = "Coding_Prediction"> Coding Potential Prediction </label> &nbsp;&nbsp;&nbsp;&nbsp;
    				<!--<input id = "ncRNA_Assignation" type = "radio" name = "Type" value = "ncRNA_functional_assignation">
    				<label for = "ncRNA_Assignation"> RNA Families Assignation </label>!-->
            </div>
        </div>


                </div>

        </form>

        <div class="container">
            
           
            <form enctype="multipart/form-data" id="formData">
                <input type="hidden" id="exec" name="exec" value="<?php echo $DIR_RANDOM ?>">
                <input type="hidden" id = "coding_type" name="coding_type" value="coding_prediction">

                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                    <h4 class="portfolio-text"> Organisms <span id='dropbut' class="glyphicon glyphicon-plus"></span></h4>
                    <div id='dropparams' style='display:none'>
                        <div class="row" style='margin-bottom:10px'>
                            
                            <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3" style='text-align:center;margin-bottom:10px'>
                                <div id="slidecontainer">
                                    <label>Organisms List:</label>
                                    <select class="form-control" name="organismslist" id="organismslist">

                                        <option selected value="all">All</option>
                    					<option value = "arabidopsis_thaliana">Arabidopsis thaliana</option>
                    					<option value = "drosophila_melanogaster">Drosophila melanogaster</option>
                    					<option value = "escherichia_coli">Escherichia coli</option>
                                        <option value = "homo_sapiens">Homo sapiens</option>
					                    <option value = "mus_musculus">Mus musculus</option>
                                        <option value = "saccharomyces_cerevisiae">Saccharomyces cerevisiae</option>

                                    </select>
                                </div>
                            </div>

                            
                        </div>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-md-offset-4 col-sm-12 col-xs-12" style="text-align:center;">
                        <h3><button id="runRNAmining" type="submit" name="runRNAmining" class="btn btn-default btn-sub" disabled><strong>Run RNAmining</strong></button></h3>

                        <div id="statusExecution" class="alert" role="warning" hidden>
                            <strong id="statusExecutionMsg"></strong>
                            </br>
                            <img id="loadingstatusExecution" src="assets/images/load.gif" style="height:50px;width:auto;display:block;margin: 0 auto;"></img>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                        <div id="alertErrorExecution" class="alert alert-danger" role="alert" hidden>
                            <img src="assets/images/failed.png" style="height:100px;width:auto;display:block;margin: 0 auto;"></img>
                            <strong>Your execution has failed with the following error:</strong></br></br>
                            <p id="errorExecutionMsg"></p>
                        </div>
                    </div>

                    <div class="col-md-4 col-md-offset-4 col-sm-12 col-xs-12" style="text-align:center;">
                        <p> Example of results are made available <a href="/pages/example">here</a>.</p>
                    </div>
                </div>
                    
            </form> <!-- END FORM PARAMETERS -->

        </div> <!-- END DIV CONTAINER -->

    </div> <!-- END DIV CONTAINER-FLUID -->

    <footer>
        <?php include("pages/footer.php"); ?>
    </footer>
</body>
    <?php include("pages/endScripts.php"); ?>
</html>
