<?php

include_once(dirname(__FILE__) . "/../../cabecera.php");

// quito el usuario que esta actualmente conectado
$acceso->quitarRegistroUsuario();

// redirecciono a index.php
header("Location: /index.php");
exit;