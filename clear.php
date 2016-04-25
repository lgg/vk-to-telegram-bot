<?php
require_once "vendor/autoload.php";

if(isset($_GET["clear"])){
    Log::clearLog();
}