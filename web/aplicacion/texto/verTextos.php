<?php

include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador
$barra=[
    [
        "TEXTO"=> "Inicio",
        "ENLACE"=> "/index.php",
        "ADICIONAL" => " >> "
        ],
        [
            "TEXTO"=>"Ver textos",
            "ADICIONAL" => " >> "
        ]
];

// guardo la direccion de la pagina visitada 
$_SESSION["paginaActual"] = "/aplicacion/texto/verTextos.php";

// si no hay un usuario conectado redirecciono a la pagina del login
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// array con los textos guardados y errores
$textos=[];
$errores=[];

// si hay textos guardados en la sesion los guardo en el array de textos
if (isset($_SESSION["textos"])) {
    $textos = $_SESSION["textos"];
}

// recojo si se ha pulsado el boton de enviar el formulario
$enviar = isset($_POST["enviar"]);

// si se ha pulsado
if ($enviar) {

    // recojo el texto que se ha mandado 
    $texto = isset($_POST["texto"])?trim($_POST["texto"]):"";

    // si el texto esta vacio guardo un error
    if ($texto === "") {
        $errores["texto"] = "* El texto no puede estar vacio";
    }
    
    // si no hay errores 
    if (count($errores)===0) {

        // guardo en el array de los textos un nuevo objeto RegistroTexto con el texto que se ha mandado
        $textos[] = new RegistroTexto($texto);

        // guardo en la sesion el array con los textos
        $_SESSION["textos"] = $textos;

        // recargo la pagina
        header("Location: verTextos.php");
        exit;
    }
}

// si se ha pulsado el boton de borrar 
if (isset($_POST["borrar"])) {

    // vacio el array de textos
    $textos = [];

    // quito la variable de textos del array de sesion
    unset($_SESSION["textos"]);

    // recargo la pagina
    header("Location: verTextos.php");
    exit;
}

//dibuja la plantilla de la vista
inicioCabecera("VerTextos R8");
cabecera();
finCabecera();
inicioCuerpo("VerTextos", $barra );
cuerpo($textos, $errores);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{

}

//vista
function cuerpo(array $textos, array $errores) {
?>
    <h2>Registrar textos</h2>
    <form action="verTextos.php" method="post">

        <input type="text" name="texto">
        <?php  
            // si hay errores los muestro
            if (isset($errores["texto"])) {
                ?> <small class="error"> <?php echo $errores["texto"] ?> </small> <?php
            }
        
        ?>

        <br><br>
        <input type="submit" name="enviar" value="Registrar texto">

        <h2>Textos registrados</h2>
        <!-- Relleno el textarea con los textos guardados en el array de textos con su fecha y hora -->
        <textarea name="area" id="area" cols="40" rows="20"><?php 
                foreach ($textos as $clave => $valor){
                    echo $valor->getFechaHora()->format("d/m/Y H:i:s")." - ".$valor->getCadena()."\n";}?></textarea>
        <br>
        <input type="submit" name="borrar" value="Borrar textos">
    </form>
<?php
}
