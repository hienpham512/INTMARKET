<?php
/*$a = false;
$doc = new DOMDocument();
if($a == true){
    $doc->loadHTML("<html><body>Test ok<br></body></html>");
    echo $doc->saveHTML();
}else{
    $doc->loadHTML("<html><body>Test false<br></body></html>");
    echo $doc->saveHTML();
}*/
session_start();
var_dump($_SESSION);
$_SESSION[] = 1;
//var_dump($_SESSION);
//unset($_SESSION[0]);
var_dump($_SESSION);
session_destroy();
session_write_close();
var_dump($_SESSION);
unset($_SESSION);
session_start();
if(isset($_SESSION)){
    echo "ok";
}else{
    echo "no";
}
// saved