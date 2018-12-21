<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html>
<head>
    <?php include("pages/head.php"); ?>

    
    <script type="text/javascript" src="assets/js/jquery_dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/jquery_dataTables.min.css">


    
    <title>Results - RNAmining</title>
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


        <?php


            $dataDir = "./data/";

            $execDir = $dataDir . $_REQUEST['id'] ;
            $file = $execDir . '/predictions.txt';

            $array = explode("\n", file_get_contents($file));
            #dump($array);

            $initial_pos = 0;
            

            foreach ($array as $count => $line) {

                if($line == ""){

                    $initial_pos = $count;
                    break;
                }
                
            }


        ?>

        <table id="table_id" class="display">

                <?php
                    echo '<thead><tr><th style = "text-align:center;">Sequence ID</th>';
                    echo '<th style = "text-align:center;">Coding Potential Classification</th></tr></thead>';
                    
                    echo '<tbody>';

                    foreach ($array as $i => $line) {

                        if (($i > $initial_pos) == TRUE){
                            
                            $exploded = explode("\t", $line);

                            $sequence_id = $exploded[0];
                            $label = $exploded[1];


                            echo '<tr><td>'.$sequence_id .'</td>';
                            echo '<td>'.$label .'</td></tr>';
                        }
                    }

                    echo '</tbody>';

                ?>


        </table>

       

    </div> <!-- END DIV CONTAINER-FLUID -->

    <footer>
        <?php include("pages/footer.php"); ?>
    </footer>

    

    <script>

        $(document).ready(function() {
            $('#table_id').DataTable();
        } );

    </script>

</body>
</html>
