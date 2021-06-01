<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html>
<head>
    <?php include("pages/head.php"); ?>
    <title>Tutorial - RNAmining</title>
</head>

<body>
    <?php include("pages/navbar.php"); ?>

    <div class="container" style='padding-top:100px'>
        <h2 class="text-center portfolio-text">Download</h2>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12">

		<h3 class="portfolio-text">Used databases</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p><span class="specialchar">RNAmining</span> was validated by a series of tests. all the FASTA sequences used in the creation process of this tool can be downloaded <a href = "../examples/Sequences.zip">here.</a></p>
                </h4>



                <h3 class="portfolio-text">Standalone Version</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p><span class="specialchar">RNAmining</span> was also developed in a standalone software. A complete tutorial of how to install and use it to perform coding potential prediction is described below.</p>
                </h4>

                <h3 class="portfolio-text">Dependencies</h3>
                <h4 class="text-justify text-about">
			<ul style="list-style-type:circle">
  				<li>Python Version >= 3.8</li>
				<li>Pandas Version >= 0.23.3</li>
				<li>Scikit-learn Version >= 0.21.3</li>
				<li>XGBoost Version >= 1.2.0</li>
				<li>Biopython Version >= 1.78</li>
			</ul> 
                </h4>

                <h3 class="portfolio-text">How to run?</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                    <p><span class="specialchar">RNAmining</span> is supported in <a href = "https://gitlab.com/integrativebioinformatics/RNAmining"> Docker version </a>and the user also can download the <a href="https://gitlab.com/integrativebioinformatics/RNAmining/-/tree/master/volumes/rnamining-front/assets/scripts/">RNAmining stand-alone version</a> through Gitlab. All the installation and run commands are explained in:</p>
                </h4>    
		
		<div class="container-fluid" style='margin: 20px 0'>
        <div class="col-md-12 col-sm-12 col-xs-12 vcenter" style="text-align:center">
                <h4> Docker and stand-alone versions with all commands: </p>
		<a href="https://gitlab.com/integrativebioinformatics/RNAmining" target=_blank">
                <img height=70 src="../assets/images/Logos/docker_image.png"/>Docker Version</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="https://gitlab.com/integrativebioinformatics/RNAmining/-/tree/master/volumes/rnamining-front/assets/scripts/" target="_blank">
                <img height=75 src="../assets/images/Logos/GitLab_Logo.png"/>&nbsp;&nbsp;Stand-alone Version</a>


        </div>
    </div>



                <h3 class="portfolio-text">Release history</h3>
                <h4 class="text-justify text-about">
                        <ul style="list-style-type:circle">
                                <li><b>RNAmining v1.0.4</b> (Jun 01, 2021)</li>
                                <p> Inclusion of classification probabilities in the output file </p>
                                <li><b>RNAmining v1.0.3</b> (Dec 17, 2020)</li>
                                <p> Fix inconsistency in sequence's read.</p>
                                <li><b>RNAmining v1.0.2</b> (Nov 13, 2020)</li>
                                <p> New version using XGBoost models.</p>
                        </ul> 
                </h4>


            </div>
        </div>
        
    <footer>
        <?php include("pages/footer.php"); ?>
    </footer>
</body>
</html>
