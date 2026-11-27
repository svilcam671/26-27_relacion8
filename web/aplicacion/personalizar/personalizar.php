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
            "TEXTO"=>"Personalizar",
            "ADICIONAL" => " >> "
        ]
];

$_SESSION["paginaActual"] = "/aplicacion/personalizar/personalizar.php";

if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

if (!$acceso->puedePermiso(1)) {
    paginaError("Acceso no permitido");
    exit;
}

//$usuario=getenv("MYSQL_USER");

$fondo = COLORESFONDO["blanco"];
$texto = COLORESTEXTO["negro"];
$cookieFondo = "";
$cookieTexto = "";
$claveFondo = "blanco";
$claveTexto = "negro";
$errores = [];
$datos = [
    "fondo" => "",
    "texto" => "",
];

if (isset($_COOKIE["colorFondo"])) {
    $cookieFondo = $_COOKIE["colorFondo"];
}

if (isset($_COOKIE["colorTexto"])) {
    $cookieTexto = $_COOKIE["colorTexto"];
}

if (validaRango($cookieFondo, COLORESFONDO,2)) {
    $fondo = COLORESFONDO[$cookieFondo];
    $claveFondo = $cookieFondo;
}

if (validaRango($cookieTexto, COLORESTEXTO,2)) {
    $texto = COLORESTEXTO[$cookieTexto];
    $claveTexto = $cookieTexto;
}

$enviar = isset($_POST["enviar"]);

if ($enviar) {

    $datos["fondo"] = isset($_POST["fondo"])?trim($_POST["fondo"]):"";

    if (!validaRango($datos["fondo"], COLORESFONDO, 2)) {
        $errores["fondo"] = "* Color de fondo no valido";
    }

    $datos["texto"] = isset($_POST["texto"])?trim($_POST["texto"]):"";

    if (!validaRango($datos["texto"], COLORESTEXTO, 2)) {
        $errores["texto"] = "* Color de texto no valido";
    }

    if (count($errores) === 0) {
        setcookie("colorFondo", $datos["fondo"], time()+60*60*24*30);
        setcookie("colorTexto", $datos["texto"], time()+60*60*24*30);

        header("Location: personalizar.php");
        exit;
    }

}

//dibuja la plantilla de la vista
inicioCabecera("Personalizar R8");
cabecera($fondo, $texto);
finCabecera();
inicioCuerpo("Personalizar", $barra );
cuerpo($claveFondo, $claveTexto, $errores);  //llamo a la vista
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
function cuerpo(string $claveFondo, string $claveTexto, array $errores)
{
?>
    <form action="personalizar.php" method="post">
        
        <label for="fondo">Seleccionar color de fondo:</label>
        <br>
        <select name="fondo" id="fondo">
            
            <?php 

                foreach (COLORESFONDO as $clave => $valor) {

                    ?> <option value="<?php echo $clave ?>" <?php echo ($clave === $claveFondo)?"selected":"" ?>><?php echo $clave ?></option> <?php

                }
            
            ?>

        </select>
        <?php if (isset($errores["fondo"])) {

            echo '<span class="error">'.$errores["fondo"].'</span>';

        }             
        ?>
        <br>
        <label for="texto">Seleccionar color del texto:</label>
        <br>
        <select name="texto" id="texto">
            
            <?php 

                foreach (COLORESTEXTO as $clave => $valor) {

                    ?> <option value="<?php echo $clave ?>" <?php echo ($clave === $claveTexto)?"selected":"" ?>><?php echo $clave ?></option> <?php

                }
            
            ?>

        </select>
        <?php if (isset($errores["texto"])) {

            echo '<span class="error">'.$errores["texto"].'</span>';

        }             
        ?>
        <br><br>
        <input type="submit" name="enviar" value="Guardar preferencias">



    </form>
    
<?php
}
