<?php
require "Cliente.php";

$cliente = new Cliente();
$cliente->nome = $_POST['firstname'];
$cliente->sobrenome = $_POST['lastname'];
echo $cliente->toString();


?>


