<?php

include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");
//controlador
$barra=[
    [
        "TEXTO"=> "Inicio",
        "ENLACE"=> "/index.php",
        "ADICIONAL" => " >> "
        ],
        [
            "TEXTO"=>"Index R8",
            "ADICIONAL" => " >> "
        ]
];

//$usuario=getenv("MYSQL_USER");

$fondo = COLORESFONDO["blanco"];
$texto = COLORESTEXTO["negro"];
$cookieFondo = "";
$cookieTexto = "";
$visitas = 0;

if (isset($_COOKIE["colorFondo"])) {
    $cookieFondo = $_COOKIE["colorFondo"];
}

if (isset($_COOKIE["colorTexto"])) {
    $cookieTexto = $_COOKIE["colorTexto"];
}

if (validaRango($cookieFondo, COLORESFONDO,2)) {
    $fondo = COLORESFONDO[$cookieFondo];
}

if (validaRango($cookieTexto, COLORESTEXTO,2)) {
    $texto = COLORESTEXTO[$cookieTexto];
}


if (isset($_COOKIE["visitas"])) {
    
    $visitaActual = $_COOKIE["visitas"];

    if (validaExpresion($visitaActual, "/^\d+$/", 0)) {
        $visitas = intval($visitaActual);
    }

}
$visitas++;
setcookie("visitas", $visitas, time()+60*60*24*30);

//dibuja la plantilla de la vista
inicioCabecera("Index Relacion 8");
cabecera($fondo, $texto);
finCabecera();
inicioCuerpo("Index pruebas personalizar R8", $barra );
cuerpo($visitas);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera(string $fondo, string $texto) 
{

    ?>
        <style>
            #documento {
                background-color: <?php echo $fondo ?>;
                color: <?php echo $texto ?>;
            }
        </style>
    <?php

}

//vista
function cuerpo(int $visitas)
{
?>
    <h3>Número de visitas a la web: <?php echo $visitas ?></h3>
    <p>Prueba de colores de personalizar</p>
    
<?php
}
