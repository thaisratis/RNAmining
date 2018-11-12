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


        $dataDir = "./data/";

        #$optionCI = $_REQUEST['opt'];

        $execDir = $dataDir . $_REQUEST['id'] ;

        echo '

            <a href="' . $execDir . '/predictions.txt" download><button class="btn btn-primary" style="margin-bottom: 30px;">Download</button></a></br>

            ';

        ?>

    </div> <!-- END DIV CONTAINER-FLUID -->

    <footer>
        <?php include("pages/footer.php"); ?>
    </footer>
</body>
</html>
