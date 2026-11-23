<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador
$barra=[
    [
        "TEXTO"=> "Inicio",
        "ADICIONAL" => " >> "
        ],
];




//dibuja la plantilla de la vista
inicioCabecera("Sesiones");
cabecera();
finCabecera();
inicioCuerpo("Sesiones", $barra);
cuerpo(); //llamo a la vista
finCuerpo();
// **********************************************************
//vista
function cabecera() {}
//vista
function cuerpo() {
?>

    
<?php
}