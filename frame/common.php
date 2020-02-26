<?php

function dd($val)
{
    if(is_array($val)){
        print_r($val);die;
    }elseif(is_string($val)){
        echo $val;die;
    }else{
        var_dump($val);die;
    }
}

function app($key=null)
{
    $app = require "../config/app.php";
    if(is_null($key)){
        return $app;
    }else{
        return $app[$key];
    }
}
function db($key=null)
{
    $databases = require "../config/databases.php";
    if(is_null($key)){
        return $databases;
    }else{
        return $databases[$key];
    }
}

function dump($var) {
    echo '<pre>';
    print_r ( $var );
    echo '</pre>';

}