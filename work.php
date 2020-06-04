<?php
function raspred($originalText,$put){
    $originalText = mb_strtolower($originalText);
    $massSymbol = [",",".","-",PHP_EOL];
    $originalText = str_replace($massSymbol,"",$originalText);
    $assoc = [];
    $WordArray = explode(' ',$originalText);
    foreach ($WordArray as $value){
        if (!array_key_exists($value, $assoc)){
            $assoc[$value] = 1;
        }
        else{
            $assoc[$value] += 1;
        }
    }
    $pushArray = [array("Слово","Кол-во вхождений")];
    foreach ($assoc as $key=>$value){
        array_push($pushArray,array($key,$value));
    }
    $file = fopen($put."/".rand().".csv","w");
    foreach ($pushArray as $value){
        fputcsv($file,$value);
    }
    fputcsv($file,array("Кол-во слов:",count($WordArray)));
    fclose($file);
}


if(!is_dir("outFile")){
    mkdir("outFile",0777,true);
}
if(!is_dir("outText")){
    mkdir("outText",0777,true);
}
if(!empty($_FILES['docs']['name'])){
    $text1 = file_get_contents($_FILES['docs']['tmp_name']);
    raspred($text1,'outFile');
}
if(!empty($_POST['text'])){
    $text2 = $_POST['text'];
    raspred($text2,'outText');
}