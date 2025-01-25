<?php

require_once '../views/MenuPrincipal.php';

$scanner = fopen('php://stdin', 'r');

$menu = new MenuPrincipal();
$menu->mostrarMenu($scanner);

fclose($scanner);

?>