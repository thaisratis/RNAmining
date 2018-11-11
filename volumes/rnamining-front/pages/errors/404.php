<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html>
<head>
    <?php include("../../pages/head.php"); ?>
    <title>Home - MetaVolcano</title>
</head>

<body>
    <?php include("../../pages/navbar.php"); ?>

    <div class="container-fluid main" id="page-top">
        <div class="row">
        	<div class="alert alert-danger alert-dismissible fade in" role="alert" style="text-align:center;margin-top: 80px">
				<strong>ERROR - PAGE NOT FOUND</strong>
			</div>
        </div>
        <div class="row">
            <div class="col-md-12 backg">
            	<div class="col-md-4 col-md-offset-4 inner col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
                    <div class="text-box">
                        <p class="intro"></p>
                        <h2>MetaVolcano</h2>
                        <h3>Meta-analysis of GEO2R Results</h3>
                        <p><a href="/tutorial" class="link-button">Tutorial</a></p>
                    </div>
                </div>
            </div>
        </div>
    	<div class="row">
            <div id='about' class="col-xs-12" style='padding-top:70px'>
                <div class="container title">
                    <h2> Just upload your dataset </h2>
                </div>
                
                <div class="desc">
                    <p><span class="specialchar">M</span>eta<span class="specialchar">V</span>olcano is a web tool that allows the meta-analysis of GEO2R results.</p>
                    <!-- <img src="/assets/images/MDP_scheme_front.png" alt="MetaVolcano" class="img-responsive center-block"
                                                               style="width:50%; padding-top: 50px; padding-bottom: 50px"> -->
                    <p>See more <a href="/about">about</a> MetaVolcano and follow our <a href="/tutorial">tutorial</a> to learn how to use it.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-xs-12 col-sm-12" style="text-align:center">
                <h3><a href='/analysis' name="submit" class="btn btn-default btn-sub"><strong>Upload your files</strong></a></h3>
                <p> Example of results are made available <a href="/pages/example">here</a>.</p>
            </div>
        </div>
    </div>

    <div class="container-fluid" style='margin: 20px 0'>
        <div class="col-md-12 col-sm-12 col-xs-12 vcenter" style="text-align:center">
                <p> Created and maintained by: </p>
                <a href="http://csbiology.com" target="_blank">
                    <img height=100 src="../assets/images/logo-arrows-low.png"/></a>
                <a href="http://integrativebioinformatics.me/" target=_blank">
                    <img height=100 src="../assets/images/lib-logo-low.png"/></a>
        </div>
    </div>

    <footer>
        <?php include("../../pages/footer.php"); ?>
    </footer>
</body>
</html>