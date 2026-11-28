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

// guardo la direccion de la pagina visitada 
$_SESSION["paginaActual"] = "/aplicacion/personalizar/index.php";

// si no hay un usuario conectado redirecciono a la pagina del login
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// variables para el color de fondo y texto con valor inicial por defecto
$fondo = COLORESFONDO["blanco"];
$texto = COLORESTEXTO["negro"];

// variable para guardar los colores que halla en las cookies
$cookieFondo = "";
$cookieTexto = "";

// contador de visitas
$visitas = 0;

// compruebo que halla un valor guardado en la cookie y lo asigno a la variable
if (isset($_COOKIE["colorFondo"])) {
    $cookieFondo = $_COOKIE["colorFondo"];
}

if (isset($_COOKIE["colorTexto"])) {
    $cookieTexto = $_COOKIE["colorTexto"];
}

// si el valor corresponde con uno del array de colores validos lo guardo en la variable de los colores
if (validaRango($cookieFondo, COLORESFONDO,2)) {
    $fondo = COLORESFONDO[$cookieFondo];
}

if (validaRango($cookieTexto, COLORESTEXTO,2)) {
    $texto = COLORESTEXTO[$cookieTexto];
}

// compruebo que exista la cookie con el valor del contador de visitas, lo valido y asigno a la variable de las visitas
if (isset($_COOKIE["visitas"])) {
    
    $visitaActual = $_COOKIE["visitas"];

    if (validaExpresion($visitaActual, "/^\d+$/", 0)) {
        $visitas = intval($visitaActual);
    }

}

// sumo una visita al contador
$visitas++;

// guardo la cookie de las visitas con el valor del contador y fecha de caducidad de 1 mes
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
        <!-- Etiqueta stlye para cambiar el color de fondo segun los valores que tengamos en las variables en el documento -->
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
