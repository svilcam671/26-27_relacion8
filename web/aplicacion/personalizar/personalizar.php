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

// guardo la direccion de la pagina visitada 
$_SESSION["paginaActual"] = "/aplicacion/personalizar/personalizar.php";

// si no hay un usuario conectado redirecciono a la pagina del login
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// si el usuario no tiene permisos para acceder se le manda a la pagina de error.
// el enunciado dice que se necesita permiso 1 pero en la demostracion se enseño que un usuario normal no puede acceder y el permiso 1 es para los usuarios normales, el 2 de administrador
if (!$acceso->puedePermiso(2)) {
    paginaError("Acceso no permitido");
    exit;
}

// variables para el color de fondo y texto con valor inicial por defecto
$fondo = COLORESFONDO["blanco"];
$texto = COLORESTEXTO["negro"];

// variable para guardar los colores que halla en las cookies
$cookieFondo = "";
$cookieTexto = "";

// arrays para errores y datos del formulario
$errores = [];
$datos = [
    "fondo" => "",
    "texto" => "",
];

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

// recojo si se ha pulsado el boton de enviar el formulario
$enviar = isset($_POST["enviar"]);

// si se ha pulsado
if ($enviar) {

    // guardo el valor del color del fondo seleccionado en el array de datos
    $datos["fondo"] = isset($_POST["fondo"])?trim($_POST["fondo"]):"";

    // si no es un valor valido guardo un error
    if (!validaRango($datos["fondo"], COLORESFONDO, 2)) {
        $errores["fondo"] = "* Color de fondo no valido";
    }

    // guardo el valor del color del texto seleccionado en el array de datos
    $datos["texto"] = isset($_POST["texto"])?trim($_POST["texto"]):"";

    // si no es un valor valido guardo un error
    if (!validaRango($datos["texto"], COLORESTEXTO, 2)) {
        $errores["texto"] = "* Color de texto no valido";
    }

    // si no hay errores guardo una cookie para el color de fondo y otra para el color del texto con una duracion de 30 dias y recargo la pagina
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
cuerpo($cookieFondo, $cookieTexto, $errores);  //llamo a la vista
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
function cuerpo(string $cookieFondo, string $cookieTexto, array $errores)
{
?>
    <!-- Formulario para seleccionar los colores de un combo -->
    <form action="personalizar.php" method="post">
        
        <label for="fondo">Seleccionar color de fondo:</label>
        <br>
        <select name="fondo" id="fondo">
            
            <?php 
                // relleno el combo con las claves del array de colores de fondo
                foreach (COLORESFONDO as $clave => $valor) {

                    ?> <option value="<?php echo $clave ?>" <?php echo ($clave === $cookieFondo)?"selected":"" ?>><?php echo $clave ?></option> <?php

                }
            
            ?>

        </select>
        <?php 
        // si hay un error del fondo muestro el error guardado
        if (isset($errores["fondo"])) {

            echo '<span class="error">'.$errores["fondo"].'</span>';

        }             
        ?>
        <br>
        <label for="texto">Seleccionar color del texto:</label>
        <br>
        <select name="texto" id="texto">
            
            <?php 
                // relleno el combo con las claves del array de colores del texto
                foreach (COLORESTEXTO as $clave => $valor) {

                    ?> <option value="<?php echo $clave ?>" <?php echo ($clave === $cookieTexto)?"selected":"" ?>><?php echo $clave ?></option> <?php

                }
            
            ?>

        </select>
        <?php 
        // si hay errores lo muestro
        if (isset($errores["texto"])) {

            echo '<span class="error">'.$errores["texto"].'</span>';

        }             
        ?>
        <br><br>
        <input type="submit" name="enviar" value="Guardar preferencias">



    </form>
    
<?php
}
