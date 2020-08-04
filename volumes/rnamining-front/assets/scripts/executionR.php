<?php
header('Content-type: text/json');

$json = array();

$DEBUG = false;

$PROD = true;

$statusExecution = 0;

$backR = "./rnamining.py";

$dataDir = "../../data/";

if ($PROD){
    
    #$fastaData = $_REQUEST['fastaData'];
    #$sequence = $_REQUEST['sequences'];
    $run_Type = $_REQUEST['coding_type'];
    $organismslist = $_REQUEST['organismslist'];
    
    $execDir = $dataDir . $_REQUEST['exec'];

} else {

    #$fastaData = "";
    #$sequence = $_REQUEST['sequences'];
    $run_Type = "coding_type";
    $organismslist = "Anolis_carolinensis";
    
    $execDir = $dataDir . "d7d47c58a9b73343e3ec0f01eec79059";
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

#python3 -W ignore rnamining.py -f sequencias_Arabidopsis.txt -organism_name arabidopsis_thaliana -prediction_type coding_prediction

$cmd = "python3 -W ignore '" . $backR. "' -f '" . $execDir . "/edata.fasta" . "' -organism_name '" . $organismslist . "' -prediction_type '" . $run_Type . "' -output_folder '" . $execDir ."'";


$process = new BackgroundProcess($cmd);
$log = $process->run($execLog,$errorLog);

while($process->isRunning()){

    exec("tail -n1 " . "'" . $execLog . "'",$line);

    sleep(2);

}

$returnCat = "";

// if size != 0 have problem
if ( filesize($errorLog) ){

    exec("cat " . $errorLog,$outputCat,$statusCat);

    if (isset($outputCat)){
        foreach ($outputCat as $value) {
            $returnCat .= $value . "</br>";
        }
    }

    if(!$statusCat){
        
        $json['error'] = $returnCat;
        echo json_encode($json);
        exit; // stop execution script

    }

// 0 -> execution ok
} else {

    

        if ( file_exists( $execDir . "/predictions.txt" )){
            //echo '<a href="' . $execDir . '/MDP_scores.tsv" download><button class="btn btn-primary" style="margin-bottom: 30px;">Download result data</button></a>';
            $zip = new ZipArchive();
            $filename = $execDir . '/RNAmining.zip';
            
            if($zip->open($filename,ZIPARCHIVE::CREATE) === true){
                $zip->addFile($execDir . "/predictions.txt");
                $zip->addFile($execDir . "/codings.txt");
                $zip->addFile($execDir . "/noncodings.txt");
            }

            $json['return'] = "success";
            echo json_encode($json);

        } else {


            $json['error'] = "predictions file don't exist!";
            echo json_encode($json);
            exit; // stop execution script
        }



}



?>
