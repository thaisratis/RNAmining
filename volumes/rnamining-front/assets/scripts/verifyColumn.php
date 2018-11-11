<?php
header('Content-type: text/json');

$json = array();

$DEBUG = false;

$PROD = true;

$statusExecution = 0;

$isFeatureID = false;

$dataDir = "../../data/";

if ($PROD){

    $columnVerify = $_REQUEST['column'];

    if($_REQUEST['element']=="columnFeatureID"){
        $isFeatureID = true;
    }
    
    $execDir = $dataDir . $_REQUEST['id'] . "/input/";

} else {

    $columnVerify = "P.Value";
    $isFeatureID = true;
    $execDir = $dataDir . "TESTES-3columns-ORIGI/input/";
}

$execLog = $execDir . "/exec.log";
$errorLog = $execDir . "/error.log";

class Actions{

    function listFiles($dirDestino){

        $fileNames = array();

        if ($handle = opendir($dirDestino)) {

            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != "..") {
                    array_push($fileNames, $entry);
                }
            }

            closedir($handle);
        }

        return $fileNames;
    }
    
    function verifyColumns($dirDestino, $nomes, $columnverify, $isfeatureid){

        $delmLine="\n";
        $delmColumn="\t";

        $campo = array();
        $dados = array();
        $arrayCompare = array();

        foreach ($nomes as $nome_final) {

            $count[$nome_final] = 1;

            $jsonColumns['columns'][$nome_final.'-haveColumn'] = 0;

            $arquivo = fopen($dirDestino . $nome_final, "r");

            if ($arquivo) {
                
                while($eachLine = fgetcsv($arquivo,0,$delmColumn)){
                    
                    if ($count[$nome_final]==1){

                        $campo[$nome_final] = $eachLine;

                        if(!$isfeatureid){
                            break;
                        }

                    } else {

                        if($dados[$nome_final][] = array_combine($campo[$nome_final], $eachLine)){
                            //pass
                        } else {
                            $json['error'] = "Number of elements diferents";
                            echo json_encode($json);
                            exit;
                        }
                    }

                    $count[$nome_final]++;

                }

                fclose($arquivo);

                foreach ($campo[$nome_final] as $item) {
                    if($item){
                        $jsonColumns['columns'][$nome_final][] = str_replace("\"", "", $item);
                    }/*else{
                        #$json['error'] = "Value is null!";
                        $json['error'] = "Column null in file \"" . $nome_final . "\"";
                        echo json_encode($json);
                        exit;
                    }*/
                }

                foreach ($jsonColumns['columns'][$nome_final] as $column) {
                    
                    if (isset($column)) {
                        if ($column == $columnverify) {
                            $jsonColumns['columns'][$nome_final.'-haveColumn'] = 1;
                        }
                    }   
                }

                if(!$jsonColumns['columns'][$nome_final.'-haveColumn']){
                    $json['error'] = "Column \"" . $columnverify . "\" not found for file \"" . $nome_final . "\"";
                    echo json_encode($json);
                    exit;
                }

                if($isfeatureid){

                    foreach ($dados[$nome_final] as $value) {
                        $arrayCompare[$nome_final][] = $value[$columnverify];
                    }

                    // detect duplicate
                    $outputDuplicate[$nome_final] = array_unique(array_diff_assoc($arrayCompare[$nome_final],array_unique($arrayCompare[$nome_final])));

                    if($outputDuplicate[$nome_final]){

                        $valuesDuplicates[$nome_final] = "";

                        foreach ($outputDuplicate[$nome_final] as $value) {
                            $valuesDuplicates[$nome_final] .= "\"" . $value . "\" ";
                        }

                        $json['columnDuplicate'] = "Column \"" . $columnverify . "\" with value(s) " . $valuesDuplicates[$nome_final] . "duplicate(s) in file \"" . $nome_final . "\"";
                        echo json_encode($json);
                        exit;

                    }
                }
            }
        }
    }

    function verifyColumnKey(){

    }
}

$run = new Actions();

$run->verifyColumns($execDir, $run->listFiles($execDir), $columnVerify, $isFeatureID);

//if($elementName == "columnFeatureID"){
//    $run->verifyColumnKey();
//}

$json['return']="success";
echo json_encode($json);

?>