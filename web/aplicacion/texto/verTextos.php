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

if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

//$usuario=getenv("MYSQL_USER");

$textos=[];
$errores=[];

if (isset($_SESSION["textos"])) {
    $textos = $_SESSION["textos"];
}

$enviar = isset($_POST["enviar"]);

if ($enviar) {

    $texto = isset($_POST["texto"])?trim($_POST["texto"]):"";

    if ($texto === "") {
        $errores["texto"] = "* El texto no puede estar vacio";
    }
    
    if (count($errores)===0) {

        $textos[] = new RegistroTexto($texto);
        $_SESSION["textos"] = $textos;

        header("Location: verTextos.php");
        exit;
    }
}

if (isset($_POST["borrar"])) {
    $textos = [];

    unset($_SESSION["textos"]);

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
            if (isset($errores["texto"])) {
                ?> <small class="error"> <?php echo $errores["texto"] ?> </small> <?php
            }
        
        ?>

        <br><br>
        <input type="submit" name="enviar" value="Registrar texto">

        <h2>Textos registrados</h2>
        <textarea name="area" id="area" cols="40" rows="20"><?php 
                foreach ($textos as $clave => $valor){
                    echo $valor->getFechaHora()->format("d/m/Y H:i:s")." - ".$valor->getCadena()."\n";}?></textarea>
        <br>
        <input type="submit" name="borrar" value="Borrar textos">
    </form>
<?php
}
