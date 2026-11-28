<?php 

error_reporting(0); //mostrar todos los errores

define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO","desarrollo"); //en "produccion o en desarrollo
date_default_timezone_set('Europe/Madrid');

if (MODO_TRABAJO=="produccion")
    error_reporting(0);
    else 
        error_reporting(E_ALL);  

spl_autoload_register(function ($clase){
    $ruta=RUTABASE."/aplicacion/clases/";
    $fichero=$ruta."$clase.php";
    
    // ruta para la autocarga de las clases que halla en /scripts/clases
    $fichero2=RUTABASE."/scripts/clases/$clase.php";

    if (file_exists($fichero))
        {
            require_once($fichero);
        }
    // else if para comprobar si existe la clase en la ruta y le hace la autocarga
    else if (file_exists($fichero2)) {
            require_once($fichero2);
        }
    else
        {
            throw new Exception("La clase $clase no se ha encontrado.");
        }
});

include(RUTABASE."/aplicacion/plantilla/plantilla.php");

//creo todos los objetos que necesita mi aplicación

// iniciamos la session para tener el array con los datos de la sesion, id y demas
session_start();

// creo una instancia de acl array y acceso para las validaciones de usuarios
$acl = new ACLArray();
$acceso = new Acceso();

// array asociativo con los colores de fondo
const COLORESFONDO = [
    "blanco" => "#ffffff",
    "noche" => "#1e1e2e",
    "pizarra" => "#2f3e46",
    "bosque" => "#1b4332",
    "vino" => "#4a1c2c",
    "arena" => "#f4ecd8",
    "cielo" => "#dbeafe",
];

// array asociativo con los colores de texto
const COLORESTEXTO = [
    "negro" => "#212529",
    "blanco" => "#f8f9fa",
    "crema" => "#fdf0d5",
    "dorado" => "#ffd166",
    "menta" => "#95d5b2",
    "coral" => "#ff8a80",
    "azul" => "#1d3557",
];