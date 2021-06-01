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
                    <p><span class="specialchar">RNAmining</span> is a web tool that allows nucleotides coding potential prediction. It takes a user-defined fasta sequences. This tool was implemented using XGBoost machine learning algorithm. Machine learning is a subfield of computer science that developed from the study of pattern recognition and computational learning theories in artificial intelligence. This tool operate through a model obtained from training data analyzes and produces an inferred function, which can be used for mapping new examples.
		    </p>
                </h4>

                <h3 class="portfolio-text">What files do I need to provide?</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p>You need to upload your RNA sequences in fasta format, see the image example below:</p>
		    <img class="img-responsive" style="height:auto;max-width: 100%;margin:0 auto;display:block;padding-bottom:0;" src="../assets/images/Example.png"></img>

                </h4>

                <h3 class="portfolio-text">How does the algorithm used work?</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p>The algorithm begins by reading the RNA sequences provided in the uploaded file. Thereafter, it is divided into two main parts: the preprocessing and the prediction. In preprocessing, we perfomed a tri-nucleotides frequency of each RNA sequence and then, we normalized it according to the sequence's lenght. This process is save in a file, which is going to be used as input for the second part. In prediction, since the user provides the organism type (e.g. Homo sapiens), the tool selects a specific organism model trained by XGBoost and perform the prediction, which is shown in the platform and can be downloaded as a .zip file.</p>
                </h4>

                <h3 class="portfolio-text">How can RNAmining helps?</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p>Non-coding RNAs are untranslated RNA molecules, but are important players in the cellular regulation of organisms from different kingdom. Thus, the research interest on non-coding RNAs has increased dramatically in recent years. Its investigation is routine in every transcriptome or genome project, since any mutations or misregulation on them result in disorders such as: tumor formation (cancerous or other type), cardiovascular, neurological diseases and others human illness. Therefore, exists an important step in ncRNAs research which is the ability to distinguish coding/non-coding sequences.</p>

		   <p>Thus, <span class="specialchar">RNAmining</span>  was built to enable easy access to nucleotides coding potential prediction for non-programming researchers. Additionally, the results are very easy to interpret.</p>
		   <p>More information about RNAmining in: Ramos TAR, Galindo NRO, Arias-Carrasco R et al. RNAmining: A machine learning stand-alone and web server tool for RNA coding potential prediction [version 1; peer review: 2 approved with reservations]. F1000Research 2021, 10:323 (<a href= 'https://doi.org/10.12688/f1000research.52350.1'>https://doi.org/10.12688/f1000research.52350.1</a>)</p>
                </h4>
            </div>
        </div>
        </br></br>
        
    </div>

    <footer>
        <?php include("pages/footer.php"); ?>
    </footer>
</body>
</html>
