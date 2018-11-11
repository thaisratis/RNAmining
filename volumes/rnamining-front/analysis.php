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
                    <p> <a href='/tutorial'>.zip</a> - <a href='/examples/dataset.zip'>example</a> </p>
                    <img class="img-responsive" style="height:auto;max-width: 100%;margin:0 auto;display:block;padding-bottom:0;" src="../assets/images/Example.png"></img>
                    
                    
                    <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                        <input id="fastaData" type="file" name="fastaData" class="btn btn-default btn-file center-block dz-clickable" accept=".tsv,.txt,.zip" required style="margin-bottom:2%;width:100%;">
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                        <div class="progress" data-action="progress">
                            <div class="progress-bar progress-bar-striped" id="progressBarFasta" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="transition: width 1s;"></div>
                        </div>
                    </div>

                    <!--<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3" id="columnsSelect" hidden>

                        <div class="row" style="margin-bottom:2%">
                                <div class="col-md-2 col-sm-12 col-xs-12" style="width:35%">
                                    <label style="width:100%;text-align: right;font-size: 24px" for="columnFeatureID">Feature ID</label>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12" style="width:65%">
                                    <select class="form-control" name="columnFeatureID" id="columnFeatureID">
                                        <option>Upload some Dataset file</option>
                                    </select>
                                </div>
                        </div>


                            <div id="alertcolumnFeatureID" class="alert alert-danger" style="padding: 0px">
                                <strong id="msgcolumnFeatureID"></strong>
                            </div>
                        

                        <div class="row" style="margin-bottom:2%">
                            <div class="form-group bottom" id="Log2FoldChange">
                                <div class="col-md-2 col-sm-12 col-xs-12" style="width:35%;">
                                    <label style="width:100%;text-align: right;font-size: 24px" for="columnLog2FoldChange">Log2FC</label>
                                </div>
                                 <div class="col-md-4 col-sm-12 col-xs-12" style="width:65%;">
                                    <select class="form-control" name="columnLog2FoldChange" id="columnLog2FoldChange">
                                        <option>Upload some Dataset file</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        
                            <div id="alertcolumnLog2FoldChange" class="alert alert-danger" style="padding: 0px" hidden>
                                <strong id="msgcolumnLog2FoldChange"></strong>
                            </div>
                        

                        <div class="row" style="margin-bottom:2%">
                            <div class="form-group bottom" id="Statistics">
                                <div class="col-md-2 col-sm-12 col-xs-12" style="width:35%;">
                                    <label style="width:100%;text-align: right;font-size: 24px" for="columnStatistics">Statistics</label>
                                </div>
                                 <div class="col-md-4 col-sm-12 col-xs-12" style="width:65%;">
                                    <select class="form-control" name="columnStatistics" id="columnStatistics">
                                        <option>Upload some Dataset file</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        
                            <div id="alertcolumnStatistics" class="alert alert-danger" style="padding: 0px" hidden>
                                <strong id="msgcolumnStatistics"></strong>
                            </div>

                    </div> --!>
                    
                    <!--<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="optchecked" id="optchecked">
                            <label class="form-check-label" for="optchecked">Files have the Confidence Interval (CI) column?</label>
                        </div>

               
                        <label class="radio-inline" style="font-weight: bold; font-size: 15px;margin-bottom:2%;"><input type="radio" name="optradio" id="allGenesRB" checked>All Genes</label>
                        <label class="radio-inline" style="font-weight: bold; font-size: 15px;margin-bottom:2%;"><input type="radio" name="optradio" id="pathwaysRB">Pathways</label>
                    </div>--!>
		<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
			<div id = "sequences">
        	        	<h4 class="portfolio-text">Fasta Sequences</h4>
               			<textarea style = "width:100%; height:300px;">
                        
                		</textarea>
	        	</div>
		</div>

		
		<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                        <div id = "Run_Type">
                                <h4 class="portfolio-text">Execution Options</h4>
                                <input id = "Coding_Prediction" type = "radio" name = "Type" value = "1">
				<label for = "Coding_Prediction"> Coding Potential Prediction </label> &nbsp;&nbsp;&nbsp;&nbsp;
				<input id = "ncRNA_Assignation" type = "radio" name = "Type" value = "0">
				<label for = "ncRNA_Assignation"> RNA Families Assignation </label>
                        </div>
                </div>



                </div>

        </form>

        <div class="container">
            
            <!--
            <div class="col-md-6 col-sm-12 col-xs-12">
                <form enctype="multipart/form-data" id="formUploadPhenotypic">
                    <input type="hidden" name="exec" value="<?php echo $DIR_RANDOM ?>">
                    
                    <label style='text-align:center;margin-bottom:3%;width:100%'> Phenotypic Data (<a href='/tutorial#phenotypes'>.txt/.tsv</a> - <a href='/examples/mdp-phenotypes.tsv'>example</a>)</label>
                
                    <input id="phenotypicData" type="file" name="phenotypicData" class="btn btn-default btn-file center-block dz-clickable" accept=".tsv,.txt" style="margin-bottom:2%;width:100%;" disabled>
                
                    <div class="progress" data-action="progress">
                        <div class="progress-bar progress-bar-striped" id="progressBarPhenotypic" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="transition: width 1s;"></div>
                    </div>
                    
                </form>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12">
                <form enctype="multipart/form-data" id="formUploadPathways">
                    <input type="hidden" name="exec" value="<?php echo $DIR_RANDOM ?>">
                
                    <label style='text-align:center;margin-bottom:3%;width:100%'> Pathways GMT (<a href='/tutorial#gmt'>.gmt</a> - <a href='/examples/mdp-genesets.gmt'>example</a>)</label>
                
                    <input id="pathwaysGMT" type="file" name="pathwaysGMT" class="btn btn-default btn-file center-block dz-clickable" accept=".tsv,.txt,.gmt" style="margin-bottom:2%;width:100%;" disabled>
                
                    <div class="progress" data-action="progress">
                        <div class="progress-bar progress-bar-striped" id="progressBarPathways" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="transition: width 1s;"></div>
                    </div>
                    
                </form>
            </div>
            -->
            
            <!--<form enctype="multipart/form-data" id="formData" method="POST" action="results">-->
            <form enctype="multipart/form-data" id="formData">
                <!--<input type="hidden" id="exec" name="exec" value="<?php echo $DIR_RANDOM ?>">

                <input type="hidden" id="optcheckedValue" name="optcheckedValue" value="0">

                <input type="hidden" id="columnFID" name="columnFID">
                <input type="hidden" id="columnL2FC" name="columnL2FC">
                <input type="hidden" id="columnSTATS" name="columnSTATS">
		!-->
                <!--
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group bottomSpace" id="parameters">
                        <label for="param">Select the control class</label>
                        <select class="form-control" name="classes1" id="param" style="margin-bottom:2%;" disabled>
                            <option>Upload some file in Phenotypic Data</option>
                        </select>
                    </div>
                </div>
            
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group bottomSpace" id="parameters2">
                        <label for="param2">Select the geneset from the pathways gmt file</label>
                        <select class="form-control" name="classes2" id="param2" disabled>
                            <option>Upload some file in Pathways GMT File</option>
                        </select>
                    </div>
                </div>
                -->

                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                    <h4 class="portfolio-text"> Organisms <span id='dropbut' class="glyphicon glyphicon-plus"></span></h4>
                    <div id='dropparams' style='display:none'>
                        <div class="row" style='margin-bottom:10px'>
                            
                            <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3" style='text-align:center;margin-bottom:10px'>
                                <div id="slidecontainer">
                                    <label>Organisms List:</label>
                                    <select class="form-control" name="organismslist" id="organismslist">

                                        <option selected>All</option>
					<option>Arabidopsis thaliana</option>
					<option>Drosophila melanogaster</option>
					<option>Escherichia coli</option>
                                        <option>Homo sapiens</option>
					<option>Mus musculus</option>
                                        <option>Saccharomyces cerevisiae</option>

                                    </select>
                                </div>
                            </div>

                            <!--
                            <div class="col-md-6 col-sm-12 col-xs-12" style='text-align:center;margin-bottom:10px'>
                                <div id="slidecontainer">
                                    <label>Signicance Criteria:</label>
                                    <select class="form-control" name="pcriteria" id="pcriteria">
                                        <option selected>adj.P.Val</option>
                                        <option>P.Value</option>
                                    </select>
                                </div>
                            </div>
                            -->
                            <!--
                            <div class="col-md-6 col-sm-12 col-xs-12" style='text-align:center;margin-bottom:10px'>
                                <label>Standart Deviation: <span id='stanVal'>2</span></label>
                                <input class="slider" type="range" min="1" max="3" step="1" value="2" name="stan"  id="stan" style="height: 30px; color: #fff;">
                            </div>
                            -->
                        </div>
                        <!--<div class="row" style='margin-bottom:10px'>
                            <div class="col-md-6 col-sm-12 col-xs-12" style='text-align:center;margin-bottom:10px'>
                                <label for="pvalue">Pvalue: <h6 style="position: absolute; margin-left: 60px; margin-top: -20px;"><span class="badge badge-primary" id="pvalueVal">0.25</span></h6></label>
                                <input class="slider" type="range" name="pvalue" id="pvalue" value="0.25" min="0" max="1" step="0.05">
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12" style='text-align:center;margin-bottom:10px'>
                                <label for="logfc">Logfc: <h6 style="position: absolute; margin-left: 50px; margin-top: -20px;"><span class="badge badge-primary" id="logfcVal">0.1</span></h6></label>
                                <input class="slider" type="range" name="logfc" id="logfc" value="0.1" min="-3" max="3" step="0.1">
                            </div>
                        </div>--!>
                        <!--<div class="row" style='margin-bottom:10px'>
                            <div class="col-md-12 col-sm-12 col-xs-12 center" style='text-align:center;margin-bottom:10px' id="topPertubedGenes">--!>
                                <!--<label>Top Perturbed Genes (%): <span id='pertubedVal'>0.25</span></label>-->
                                <!--<label>Top Perturbed Genes (%): <h6 style="position: absolute; margin-left: 185px; margin-top: -20px;"><span class="badge badge-primary" id="pertubedVal">0.80</span></h6></label>
                                <input class="slider" type="range" name="metathr" id="metathr" value="0.80" min="0.05" max="0.95" step="0.05">--!>
                            <!--</div>
                        </div>--!>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-md-offset-4 col-sm-12 col-xs-12" style="text-align:center;">
                        <h3><button id="runRNAmining" type="submit" name="runRNAmining" class="btn btn-default btn-sub" disabled><strong>Run RNAmining</strong></button></h3>

                        <div id="statusExecution" class="alert" role="warning" hidden>
                            <strong id="statusExecutionMsg"></strong>
                            </br>
                            <img id="loadingstatusExecution" src="assets/images/loading.gif" style="height:50px;width:auto;display:block;margin: 0 auto;"></img>
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
