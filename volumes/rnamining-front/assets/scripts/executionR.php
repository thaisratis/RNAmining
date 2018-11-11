<?php
header('Content-type: text/json');

$json = array();

$DEBUG = false;

$PROD = true;

$statusExecution = 0;

$backR = "./metavolcano_run.R";
$ncores = 20;
//$collaps = "TRUE";
$jobname = "job";
$dataDir = "../../data/";

if ($PROD){
    
    $columnFeatureid = $_REQUEST['columnFID'];
    $columnLog2fc = $_REQUEST['columnL2FC'];
    $columnStatistics = $_REQUEST['columnSTATS'];

    $organismslist = $_REQUEST['organismslist'];

    // COLUMN STATISTICS
    //$pcriteria = $_REQUEST['pcriteria'];
    
    $pvalue = $_REQUEST['pvalue'];
    $logfc = $_REQUEST['logfc'];
    $metathr = $_REQUEST['metathr'];
    $optionCI = $_REQUEST['optcheckedValue'];
    $metap = "Fisher";
    $execDir = $dataDir . $_REQUEST['exec'];

} else {

    $columnFeatureid = "ID";
    $columnLog2fc = "logFC";
    $columnStatistics = "P.Value";

    $organismslist = "Median";
    
    // COLUMN STATISTICS
    //$pcriteria = "adj.P.Val";
    
    $pvalue = 0.25;
    $logfc = 0.1;
    $metathr = 0.8;
    $optionCI = 0;
    $metap = "Fisher";
    $execDir = $dataDir . "TESTES";
}

$execLog = $execDir . "/exec.log";
$errorLog = $execDir . "/error.log";

class BackgroundProcess{
    private $command;
    private $pid;

    public function __construct($command){
        $this->command = $command;
    }

    public function run($outputExec, $outputError){
        $this->pid = shell_exec(sprintf('%s > %s 2> %s & echo $!',$this->command,$outputExec,$outputError));
    }

    public function isRunning(){
        try {
            $result = shell_exec(sprintf('ps %d', $this->pid));
            if(count(preg_split("/\n/", $result)) > 2) {
                return true;
            }
        } catch(Exception $e) {}

        return false;
    }

    public function getPid(){
        return $this->pid;
    }

}

function Compress($source_path, $destination_path){

    //echo "ORIGEM ANTES: " . $source_path . "\n";

    // Normaliza o caminho do diretório a ser compactado
    $source_path = realpath($source_path);

    //echo "ORIGEM DEPOIS: " . $source_path . "\n";
    //echo "DESTINO: " . $destination_path . "\n";

    // Caminho com nome completo do arquivo compactado
    // Nesse exemplo, será criado no mesmo diretório de onde está executando o script
    $zip_file = $destination_path .'/' .basename($source_path).'.zip';

    // Inicializa o objeto ZipArchive
    $zip = new ZipArchive();
    $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    // Iterador de diretório recursivo
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source_path),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        // Pula os diretórios. O motivo é que serão inclusos automaticamente
        if (!$file->isDir()) {
            // Obtém o caminho normalizado da iteração corrente
            $file_path = $file->getRealPath();

            // Obtém o caminho relativo do mesmo.
            $relative_path = substr($file_path, strlen($source_path) + 1);

            // Adiciona-o ao objeto para compressão
            $zip->addFile($file_path, $relative_path);
        }
    }

    // Fecha o objeto. Necessário para gerar o arquivo zip final.
    $zip->close();

    // Retorna o caminho completo do arquivo gerado
    return $zip_file;
}


//echo $execDir;

//Compress($execDir . "/output/", $execDir);



// R need variable HOME defined for user www-data
putenv("HOME=/tmp");

if ($DEBUG) {

    echo "<script>console.info('command: Rscript " . $backR . " " . getcwd() . "/" . $execDir . " " . $jobname . " " . $metathr . " " . $pcriteria . " " . $pvalue . " " . $logfc . " " . $ncores . " " . $collaps . " " . $metap . " " . $organismslist . "');</script>";

    echo "<script>console.info('BackR: " . $backR . "');</script>";
    echo "<script>console.info('Execdir: " . $execDir . "');</script>";
    echo "<script>console.info('Jobname: " . $jobname . "');</script>";
    echo "<script>console.info('Metathr: " . $metathr . "');</script>";
    echo "<script>console.info('Pcriteria: " . $pcriteria . "');</script>";
    echo "<script>console.info('Pvalue: " . $pvalue . "');</script>";
    echo "<script>console.info('Logfc: " . $logfc . "');</script>";
    echo "<script>console.info('Ncores: " . $ncores . "');</script>";
    echo "<script>console.info('Colapps: " . $collaps . "');</script>";
    echo "<script>console.info('Metap: " . $metap . "');</script>";
    echo "<script>console.info('Metafc: " . $organismslist . "');</script>";
    echo "<script>console.info('OptionCI: " . $optionCI . "');</script>";

}

$cmd = "Rscript '" . $backR . "' '" . getcwd() . "/" . $execDir . "' '" . $jobname . "' '" . $metathr . "' '" . $columnFeatureid . "' '" . $columnLog2fc . "' '" . $columnStatistics . "' '" . $pvalue . "' '" . $logfc . "' '" . $ncores . "' '" . $metap . "' '" . $organismslist . "' '" . $optionCI . "'";

$process = new BackgroundProcess($cmd);
$log = $process->run($execLog,$errorLog);

while($process->isRunning()){

    exec("tail -n1 " . "'" . $execLog . "'",$line);

    sleep(2);

}

$returnCat = "";

// if size != 0 have problem
if ( filesize($errorLog) ){

    echo $errorLog;
    exit;

        //if(isset($returnRScript->error)){
        if(isset($errorLog)){

            exec("cat " . $errorLog,$outputCat,$statusCat);

            if (isset($outputCat)){
                foreach ($outputCat as $value) {
                    $returnCat .= $value . "</br>";
                }
            }

            // if cmd exec sucessful
            if(!$statusCat){
 
                $json['error'] = $returnCat;
                echo json_encode($json);
                exit; // stop execution script

            }

        } else {

            // get error stdout
            exec("cat " . $errorLog,$outputCat,$statusCat);

            if (isset($outputCat)){
                foreach ($outputCat as $value) {
                    $returnCat .= $value . "</br>";
                }
            }

            // if cmd exec sucessful
            if(!$statusCat){

                    $json['error'] = $returnCat;
                    echo json_encode($json);
                    exit; // stop execution script
            } else {

                    $json['error'] = "Undefined error";
                    echo json_encode($json);
                    exit; // stop execution script
            }
        }

// 0 -> execution ok
} else {

    if ($optionCI) {

        if ( file_exists( $execDir . "/cumdeg_" . $jobname . ".html" ) and file_exists( $execDir . "/degbar_" . $jobname . ".html" ) and file_exists( $execDir . "/randomSummary_" . $jobname . ".html" ) and file_exists( $execDir . "/" . $jobname . ".html" ) and file_exists( $execDir . "/" . $jobname . "_metap.html" ) ){
            //echo '<a href="' . $execDir . '/MDP_scores.tsv" download><button class="btn btn-primary" style="margin-bottom: 30px;">Download result data</button></a>';

            if(Compress($execDir . "/output/", $execDir)){
                $json['return']="success";
                echo json_encode($json);
            }

        } else {


            $json['error'] = "For some undefined reason the graphics could not be loaded - CI - Verify disk space";
            echo json_encode($json);
            exit; // stop execution script
        }

    } else {

        if ( file_exists( $execDir . "/cumdeg_" . $jobname . ".html" ) and file_exists( $execDir . "/degbar_" . $jobname . ".html" ) and file_exists( $execDir . "/" . $jobname . ".html" ) and file_exists( $execDir . "/" . $jobname . "_metap.html" ) ){
            //echo '<a href="' . $execDir . '/MDP_scores.tsv" download><button class="btn btn-primary" style="margin-bottom: 30px;">Download result data</button></a>';

            if(Compress($execDir . "/output/", $execDir)){
                $json['return']="success";
                echo json_encode($json);
            }

        } else {


            $json['error'] = "For some undefined reason the graphics could not be loaded - Verify disk space";
            echo json_encode($json);
            exit; // stop execution script
        }

    }
}



?>