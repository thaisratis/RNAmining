<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html>
<head>
    <?php include("pages/head.php"); ?>
    <title>Results - MetaVolcano</title>
</head>

<body>
    <?php include("pages/navbar.php"); ?>

    <div class="text-center container" style="padding-top:100px;">

        <h2 class="text-center portfolio-text">Results</h2>

        <?php

        $jobname = "job";

        $dataDir = "./data/";

        $optionCI = $_REQUEST['opt'];

        $execDir = $dataDir . $_REQUEST['id'];

        if ($optionCI){

            echo '<a href="' . $execDir . '/deg_by_study_' . $jobname . '.tsv" download><button class="btn btn-primary" style="margin-bottom: 30px;">Download result - deg_by_study_' . $jobname . '</button></a></br>';
            echo '<a href="' . $execDir . '/meta_degs_' . $jobname . '_combining.tsv" download><button class="btn btn-primary" style="margin-bottom: 30px;">Download result - meta_degs_' . $jobname . '_combining</button></a></br>';
            echo '<a href="' . $execDir . '/metafor_degs_' . $jobname . '_summarizing.tsv" download><button class="btn btn-primary" style="margin-bottom: 30px;">Download result data - metafor_degs_' . $jobname . '_summarizing</button></a>';

            echo '<iframe class="fundoIframe" src="' . $execDir . '/cumdeg_' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;border-radius: 8px 8px 0 0;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>';
            echo '<iframe class="fundoIframe" src="' . $execDir . '/degbar_' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>';
            echo '<iframe class="fundoIframe" src="' . $execDir . '/' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>';
            echo '<iframe class="fundoIframe" src="' . $execDir . '/' . $jobname . '_metap.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>';
            echo '<iframe class="fundoIframe" src="' . $execDir . '/randomSummary_' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>';

        } else {


            echo '

            <a href="' . $execDir . '/output.zip" download><button class="btn btn-primary" style="margin-bottom: 30px;">Download result(s)</button></a></br>
            
            <ul class="nav nav-pills nav-justified">
              <li class="nav-item active">
                <a class="nav-link" data-toggle="pill" href="#home">CUMDEG</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#menu1">DEGBAR</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#menu2">OTRO</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#menu3">METAP</a>
              </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane container active" id="home">
                    <iframe class="fundoIframe" src="' . $execDir . '/cumdeg_' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;border-radius: 8px 8px 0 0;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>
                </div>
                <div class="tab-pane container fade" id="menu1">
                    <iframe class="fundoIframe" src="' . $execDir . '/degbar_' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>
                </div>
                <div class="tab-pane container fade" id="menu2">
                    <iframe class="fundoIframe" src="' . $execDir . '/' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>
                </div>
                <div class="tab-pane container fade" id="menu3">
                    <iframe class="fundoIframe" src="' . $execDir . '/' . $jobname . '_metap.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>
                </div>
            </div>

            ';

            /*
            <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Active</a>
                            <iframe class="fundoIframe" src="' . $execDir . '/cumdeg_' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;border-radius: 8px 8px 0 0;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>
                        </li>
                    </ul>
            echo '<iframe class="fundoIframe" src="' . $execDir . '/degbar_' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>';
            echo '<iframe class="fundoIframe" src="' . $execDir . '/' . $jobname . '.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>';
            echo '<iframe class="fundoIframe" src="' . $execDir . '/' . $jobname . '_metap.html" width="100%" frameborder="0" style="height: 500px;margin-top:-5px;background:url(assets/images/loading_2.gif) center center no-repeat;"></iframe>';
            */
        }

        ?>

    </div> <!-- END DIV CONTAINER-FLUID -->

    <footer>
        <?php include("pages/footer.php"); ?>
    </footer>
</body>
</html>
