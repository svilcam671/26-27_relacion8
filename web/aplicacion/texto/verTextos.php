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

//$usuario=getenv("MYSQL_USER");

$textos=[];
$errores=[];

if (isset($_SESSION["textos"])) {
    $textos = $_SESSION["textos"];
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
        <br><br>
        <input type="submit" name="enviar" value="Registrar texto">

    

        <h2>Textos registrados</h2>
        <textarea name="area" id="area" cols="40" rows="20"><?php 
                foreach ($textos as $clave => $valor){
                    echo $valor->getFechaHora()->format("d/m/Y H:i:s")." - ".$valor->getCadena()."\n";}?>
        </textarea>
        <br>
        <input type="submit" name="borrar" value="Borrar textos">
    </form>
<?php
}
