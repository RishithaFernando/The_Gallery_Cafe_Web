<?php

$server="localhost";
$userName="root";
$password="";
$dbname="the gallery cafe";

$conn = mysqli_connect($server,$userName,$password,$dbname);
if(!$conn){
    echo "error in database connection";
}

?>