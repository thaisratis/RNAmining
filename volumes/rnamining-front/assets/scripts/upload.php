<?php
header('Content-type: text/json');

$json = array();

$DEBUG = true;

error_reporting(E_ALL ^ E_WARNING);
/*
$json['error'] = "Error, fix permissions in directory data";
echo json_encode($json);
exit;
*/

$dir_random = '../../data/' . $_REQUEST['exec']; 

$files = glob($dir_random . '/input/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

// Tamanho do arquivo para upload em MB
$fileSizeMB = 20 ;

# if direcotiry not exists
if ( !(is_dir($dir_random)) ){

        # if not create directory
        if(!mkdir($dir_random,0755)){
                $json['error'] = "Error, fix permissions in directory data";
                echo json_encode($json);
                exit;
        } else {
            mkdir($dir_random . "/input",0755);
            mkdir($dir_random . "/output",0755);
        }

}

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = $dir_random . '/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * $fileSizeMB; // MB

// Array com as extensões permitidas
$_UP['extensoes'] = array('txt' ,'tsv' , 'gmt', 'zip');

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = "There wasn't any problem";
$_UP['erros'][1] = "Uploaded file is larger than the PHP limit";
$_UP['erros'][2] = "Uploaded file is larger than the limit";
$_UP['erros'][3] = "O upload do arquivo foi feito parcialmente";
$_UP['erros'][4] = "The file wasn't sent";

// Function for basic field validation (present and neither empty nor only white space
function IsNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '');
}

class Actions{

  function verificaExtensao($fileName, $arrayExtensoes) {

    // Caso o script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
    // Faz a verificação da extensão do arquivo
    $preextensao = explode('.', $fileName); 
    // Se fizer tudo direto o php retorna um erro
    // PHP Notice:  Only variables should be passed by reference 
    $extensao = strtolower(end($preextensao));
    if (array_search($extensao, $arrayExtensoes) === false) {
      $json['error'] = "Please, send files with the following extension(s): txt, tsv, gmt or zip.";
      echo json_encode($json);
      exit;
    }

    return $extensao;

  }

  function verificaTamanho($tamanhoArquivo, $tamanhoMaximo) {

    // Faz a verificação do tamanho do arquivo
    if ($tamanhoArquivo > $tamanhoMaximo){
      $json['error'] = "Uploaded file is too large. The file size limit is " . $tamanhoMaximo . ".";
      echo json_encode($json);
      exit; // Para a execução do script
    }

  }

  function extractColumns($dirDestino, $nomes){

    $delmLine="\n";
    $delmColumn="\t";

    foreach ($nomes as $nome_final) {

      $arquivo = fopen($dirDestino . $nome_final, "r");

      if ($arquivo) {
        
        while(!feof($arquivo)){
          // get line 1
          $linha[$nome_final][] = explode($delmLine, fgets($arquivo));
          break;
        }

        fclose($arquivo);

        // get columns
        $arrayColumns = explode($delmColumn, $linha[$nome_final][0][0]);

        foreach ($arrayColumns as $item) {
          if($item){
            //$jsonColumns['columns'][$nome_final][] = str_replace("\"", "", $item);
            $jsonColumns['columns']['allColumns'][] = str_replace("\"", "", $item);
          }else{
            $json['error'] = "Column is null!";
            echo json_encode($json);
            exit;
          }
        }

        /*
        // if before name is set
        if(isset($nome_anterior)){
          $result = array_diff($jsonColumns['columns'][$nome_anterior],$jsonColumns['columns'][$nome_final]);

          // if is set result exists columns diff
          if(isset($result)){
            foreach ($result as $value) {
              $json['error'] = $nome_anterior . " has the " . $value . " column and " . $nome_final . " does not.";
              echo json_encode($json);
              exit;
            }
          }
        }
        */

      }
      //$nome_anterior = $nome_final;
    }

    // COLUMNS
    $json['columns'] = array_unique($jsonColumns['columns']['allColumns']);
    echo json_encode($json);
    exit;
  }

  function moveArquivo($tipo, $extensao, $origem, $dirDestino) {

    $jsonClass = array();

    switch ($tipo) {

      case "fasta":

        $nome_final = 'edata.tsv';
        $nome_final_zip = 'edata.zip';
      
      break;

      case "phenotypic":

        $nome_final = 'pdata.tsv';
      
      break;

      case "gmt":

        $nome_final = 'pathways.gmt';
      
      break;

    }

    switch ($extensao) {

        case 'tsv':
        case 'gmt':
        case 'txt':

          $destino = $dirDestino . $nome_final;

          if (move_uploaded_file($origem, $destino)){

          } else {

            // Não foi possível fazer o upload, provavelmente a pasta está incorreta
            $json['error'] = "Couldn't send file, please, try again";
            echo json_encode($json);
            exit; // Para a execução do script

          }

          //echo json_encode($jsonClass);

        break;

        case 'zip':

          $fileZip = $dirDestino . $nome_final_zip;

          // Verifica se é possível mover o arquivo para a pasta escolhida
          if (move_uploaded_file($origem, $fileZip)){
            
            // Upload efetuado com sucesso

            $zip = new ZipArchive;
            
            if ($zip->open($fileZip)) {
              
                $zip->extractTo($dirDestino . "/input");

                $filenames = array();

                // list files
                for ($i = 0; $i < $zip->numFiles; $i++) {
                  $filenames[$i] = $zip->getNameIndex($i);
                }

                $zip->close();

                unlink($fileZip);

                return $filenames;

            } else {
            
                $json['error'] = "Failed.";
                echo json_encode($json);

            }      

          } else {
            // Não foi possível fazer o upload, provavelmente a pasta está incorreta
            $json['error'] = "Couldn't send file, please, try again";
            echo json_encode($json);
            exit; // Para a execução do script
          }

        break;

    } // FIM DO CASE

  //echo json_encode($json);

  } // FIM DO METODO MOVEARQUIVO

  function verificaEstrutura($dirDestino,$nomes){

    $delm="\t";
    $row=1;

    $numColsPrevious=0;
    $numColsCurrent=0;

    foreach ($nomes as $nome_final) {

      $file = fopen($dirDestino . $nome_final, "r");

      if ($file) {

        //$file = fopen($dirDestino . $nome,"r");

        $numLines[$nome_final] = count(file($file));

        while (($data = fgetcsv($file,$numLines[$nome_final],$delm)) !== FALSE) {
          $numColsCurrent[$nome_final] = count($data);

          if($row!=1){
            if ($numColsCurrent[$nome_final]==1){
              foreach ($data as $value){
                if(IsNullOrEmptyString($value)){
                  $json['error'] = "Structure error in file " . $nome_final . " line " . $row . ", blank line";
                  echo json_encode($json);
                  exit;
                }
              }
            } elseif ($numColsPrevious == $numColsCurrent[$nome_final]){
              foreach ($data as $value){
                if(IsNullOrEmptyString($value)){
                  $json['error'] = "Structure error in file " . $nome_final . " line " . $row . ", blank column";
                  echo json_encode($json);
                  exit;
                }
              }
            } elseif ($numColsPrevious != $numColsCurrent[$nome_final]){
              $json['error'] = "Structure error in file " . $nome_final . " line " . $row . ", number of columns diverge";
              echo json_encode($json);
              exit;
            }
          }
          
          $row++;
          $numColsPrevious = $numColsCurrent[$nome_final];
        }

        fclose($file);
      }

    }

  } // FIM METODO VERIFICAESTRUTURA

  function extrairClasse($tipo,$dirDestino){

    if ($tipo == "phenotypic" or $tipo == "gmt") {

      $delm="\t";

      if ($tipo == "phenotypic") {

        $nome="pdata.tsv";
        $colunaClass=1;

      } elseif ($tipo == "gmt") {

        $nome="pathways.gmt";
        $colunaClass=0;

      }

      $arquivo = fopen($dirDestino . $nome, "r");

      if ($arquivo) {
        
        while(!feof($arquivo)){ 
          $linhas[] = explode($delm, fgets($arquivo));
        }

        fclose($arquivo);
          
        unset($linhas[0]);
        unset($linhas[count($linhas)]);

        foreach($linhas as $elemento){
          if(isset($elemento[$colunaClass])){
            $arrayClass_before[] = $elemento[$colunaClass];
          }
        }

        // Remove duplicates class and organize id values
        if (isset($arrayClass_before)){ 
          $arrayClass = array_values(array_unique($arrayClass_before));
        }else{
          $json['error'] = "Invalid file or do not have classes";
          echo json_encode($json);
          exit;
        }

        $jsonClass = array();

        if ($tipo == "phenotypic") {

          $jsonClass['classes1'] = array();
          // Show class
          foreach ($arrayClass as $item) {
            if($item){
              $jsonClass['classes1'][] = $item;
            }else{
              $json['error'] = "Invalid file or do not have classes";
              echo json_encode($json);
              exit;
            }
          }
        } elseif ($tipo == "gmt") {

          $jsonClass['classes2'] = array();
          // Show class
          foreach ($arrayClass as $item) {
            if($item){
              $jsonClass['classes2'][] = $item;
            }else{
              $json['error'] = "Invalid file or not have null classes";
              echo json_encode($json);
              exit;
            }
          }
        }

        echo json_encode($jsonClass);
        exit;

      }
    }
  } // FIM METODO EXTRAICLASSES

} // FIM DA CLASSE Actions
 
$run = new Actions();

/*
EXPRESSIONDATA UPLOAD
*/
if ( isset($_FILES['fastaData']) ) {

  $tipo = "fasta";

  // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
  if ($_FILES['fastaData']['error'] != 0) {
    $json['error'] = "Couldn't complete file upload because: " . $_UP['erros'][$_FILES['fastaData']['error']];
    echo json_encode($json);
    exit; // Para a execução do script
  }

  $extensao = $run->verificaExtensao($_FILES['fastaData']['name'],$_UP['extensoes']);

  $run->verificaTamanho($_FILES['fastaData']['size'], $_UP['tamanho']);

  $fileNames = $run->moveArquivo($tipo, $extensao, $_FILES['fastaData']['tmp_name'],$_UP['pasta']);

  $run->verificaEstrutura($_UP['pasta']."input/",$fileNames);

//  $run->extractColumns($_UP['pasta']."input/",$fileNames);

}

$json['return']="success";
echo json_encode($json);

?>
