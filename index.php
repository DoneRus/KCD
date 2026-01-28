<?php
    include_once('dbFunction.php');  

Echo "Hello World \n";

 $funObj = new dbFunction();

if ( $funObj !== null) {
    echo "there is connection";
} else {
    echo "no connection";
}

?>