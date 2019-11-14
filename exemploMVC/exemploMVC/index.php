<?php
/**
* @package Exemplo MVC com PHP
*/
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'lib/Application.php';
$o_Application = new Application();
$o_Application->dispatch();
?>