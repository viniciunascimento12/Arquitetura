<?php  
 session_start();
 session_destroy();
 $retorno_get = "";
 $retorno_get.= "logout=1";
 header("Location: index.php?".$retorno_get);
?>