<?php

require_once '../app/controllers/MenuPrincipal.php';

$scanner = fopen('php://stdin', 'r');

$menu = new MenuPrincipal();
$menu->mostrarMenu($scanner);

fclose($scanner);

?>