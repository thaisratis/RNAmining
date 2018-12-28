<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html>
<head>
    <?php include("pages/head.php"); ?>
    <title>About - RNAmining</title>
</head>

<body>
    <?php include("pages/navbar.php"); ?>

    <div class="container" style='padding-top:100px'>
        <h2 class="text-center portfolio-text">About</h2>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12">
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p><span class="specialchar">RNAmining</span> is a web tool that allows coding potential prediction and non-coding RNA functional assignation. It takes a user-defined fasta sequences and depending on the user chosen option, it distinguish coding and non-coding sequences or perform the non-coding RNA assignation. This tool was implemented using machine learning algorithms. Machine learning is a subfield of computer science that developed from the study of pattern recognition and computational learning theories in artificial intelligence. This tool operate through a model obtained from training data analyzes and produces an inferred function, which can be used for mapping new examples.
		    </p>
                </h4>

                <h3 class="portfolio-text">What files do I need to provide?</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p>You need to upload your RNA sequences in fasta format, see the image example below:</p>
		    <img class="img-responsive" style="height:auto;max-width: 100%;margin:0 auto;display:block;padding-bottom:0;" src="../assets/images/Example.png"></img>

                </h4>

                <h3 class="portfolio-text">How does the algorithm used work?</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p>The algorithm begins by reading the RNA sequences provided in the uploaded file. Thereafter, it is divided into two main parts: the preprocessing and the prediction. In preprocessing, the algorithm do the tri-nucleotides frequency of each RNA sequence and save the results in a file, which is going to be used as input for the second part. In prediction, since the user provides the organism type (e.g. Escherichia coli), the algorithm selects a specific Deep Learning network architecture trained for this organism and perform the prediction, which is shown in the platform and can be downloaded as a .zip file.</p>
                </h4>

                <h3 class="portfolio-text">How can RNAmining helps?</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p>Non-coding RNAs are untranslated RNA molecules, but are important players in the cellular regulation of organisms from different kingdom. Thus, the research interest on non-coding RNAs has increased dramatically in recent years. Its investigation is routine in every transcriptome or genome project, since any mutations or misregulation on them result in disorders such as: tumor formation (cancerous or other type), cardiovascular, neurological diseases and others human illness. Therefore, exists two important steps on the predicting process and functional assignation of ncRNAs in which <span class="specialchar">RNAmining</span> was developed to perform: the ability to distinguish coding and non-coding sequences, followed by a functional assignation of ncRNA families.</p>

		   <p>Thus, <span class="specialchar">RNAmining</span> can help researchers to identify which families are similar functionally and structurally, assign functions to unknown RNA sequences, scan genomes detecting new or known RNAs involved in cancers and other diseases, as well as enable the identification of the sequences origin.</p>
                </h4>
            </div>
        </div>
        </br></br>
        
        <!--
        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="row">
                <img src="../assets/images/MDP_scheme_v3.png" style="width:100%" alt=""></img>
            </div>
        </div>


        <div class="col-md-6 col-xs-12 col-sm-12">
            <h3 class="portfolio-text"> The MDP works as follows: </h3>
            <div class="row text-about vertical-align" style="margin-left: 2px">
                <h4 class="text-about">
                    <a href="">  Step 1:</a> The median and standard deviation of the genes from the control samples are calculated.
                </h4>
            </div>
            </br></br>
            <div class="row text-about vertical-align" style="margin-left: 2px">
                <h4 class="text-about">
                    <a href="">  Step 2:</a> The median and standard deviation values are used to perform a Z-score normalization of all genes.
                </h4>
            </div>
            </br></br>
            <div class="row text-about vertical-align" style="margin-left: 2px">
                <h4 class="text-about">
                    <a href="">  Step 3:</a> The absolute value of these fasta values are taken, and values less than 2 are set to 0. The values that remain represent significant deviations from the healthy samples.
                </h4>
            </div>
            </br></br>
            <div class="row text-about vertical-align" style="margin-left: 2px">
                <h4 class="text-about">
                    <a href="">     Step 4:</a> The scores for each sample are calculated by finding the average of the normalized gene values for each sample, using either a) all genes, b) perturbed genes and c) optionally supplied gene sets.
                </h4>
            </div>
        </div>

        <div class="col-md-12 col-xs-12 col-sm-12">
            <h3 class="portfolio-text">What files do I need to provide?</h3>
            <div class="row text-about vertical-align">
                <h4 class="text-about">
                    You need to provide fasta data, a file containing the phenotypic information, and an optional .gmt file if you want run the MDP on different gene sets. <a href="tutorial">See the tutorial</a> for more information.
                </h4>
            </div>
        </div>

        <div class="col-md-12 col-xs-12 col-sm-12">
            <h3 class="portfolio-text">Additional details</h3>
            <div class="row text-about vertical-align">
                <h4 class="text-about">
                    <p>
                    The design of the algorithm is based on the Molecular Distance to Health which was first described by <a href="https://genomebiology.biomedcentral.com/articles/10.1186/gb-2009-10-11-r127" target="_blank">Pankla et al. 2009</a>. The MDP, by comparison, does not discretize the Z-score normalised gene scores. We also allow you to use the median rather than mean to compute the gene average, so that the gene average is less sensitive to outliers. You can also select the standard deviation threshold.
                    </p>
                    <p>
                    The MDP utilizes the ggplot2 R package - <a href="https://CRAN.R-project.org/package=ggplot2" target="_blank">https://CRAN.R-project.org/package=ggplot2</a>
                    </p>
                </h4>
            </div>
        </div>
        -->
    </div>

    <footer>
        <?php include("pages/footer.php"); ?>
    </footer>
</body>
</html>
