<?php
include_once(__DIR__ . "/config.php");
include_once(__DIR__ . "/include.php");

$con_string = "host= port= dbname= user= password=";

$dbcon = pg_connect($con_string);
pg_query("SET search_path TO sesplan");

?>
