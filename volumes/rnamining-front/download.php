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
                    <p><span class="specialchar">RNAmining</span> was also developed in a standalone software. A complete tutorial of how to install and use it to perform coding potential prediction and RNA functional assignationis is described below.</p>
                </h4>

                <h3 class="portfolio-text">Dependencies</h3>
                <h4 class="text-justify text-about">
			<ul style="list-style-type:circle">
  				<li>Python Version >= 3.8</li>
				<li>Pandas Version >= 0.23.3</li>
				<li>Scikit-learn Version >= 0.21.3</li>
				<li>XGBoost Version >= 1.2.0</li>
			</ul> 
                </h4>

                <h3 class="portfolio-text">How to run?</h3>
                <h4 class="text-justify text-about" style="line-height:30px;text-indent:50px">
                     <p>Download the <a href="https://gitlab.com/integrativebioinformatics/RNAmining/-/tree/master/volumes/rnamining-front/assets/scripts/">RNAmining</a> files and run the commands explain there to perform files prediction!</p>
                </h4>    
                        
                <h4 class="text-justify text-about" style="line-height:30px;">
                    <p>Run the following command to display all the parameters available to change in RNAmining:</p>
                </h4>
                        <div style="white-space: nowrap; overflow-x: auto;">
                            <table>
                                <th>
                                    python3 rnamining.py -h 
                                </th>
                            </table>
                        </div>
                    </br>    

               
                <h4 class="text-justify text-about" style="line-height:30px;">
                    <p>If need more information see the file README.md in the .zip file!</p>                    
                </h4>

            </div>
        </div>
        
    <footer>
        <?php include("pages/footer.php"); ?>
    </footer>
</body>
</html>
