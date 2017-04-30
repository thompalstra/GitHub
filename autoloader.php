<?php
function __autoload($classname){

    $classname = str_replace('\\', '/', $classname);
    if(file_exists(__DIR__.'/'.$classname.'.php')){
        include (__DIR__.'/'.$classname.'.php');
    }
}
?>
