<?php

function paginaError($mensaje)
{
    header("HTTP/1.0 404 $mensaje");
    inicioCabecera("PRACTICA");
    finCabecera();
    inicioCuerpo("ERROR", []);
    echo "<br />\n";
    echo $mensaje;
    echo "<br />\n";
    echo "<br />\n";
    echo "<br />\n";
    echo "<a href='/index.php'>Ir a la pagina principal</a>\n";

    finCuerpo();
}

function inicioCabecera($titulo)
{
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php echo $titulo ?></title>
        <meta name="description" content="">
        <meta name="author" content="Administrador">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="stylesheet" type="text/css" href="/estilos/base.css">
    <?php
}

function finCabecera()
{
    ?>
    </head>
<?php
}

function inicioCuerpo(string $cabecera, array $ubicacion = [])
{
    global $acceso;

?>

    <body>
        <div id="documento">
            <a href="/index.php"><img src="/imagenes/inicio.png" alt="Imagen de inicio" id="imgInicio"></a>
            <header>
                <h1 id="titulo"><?php echo $cabecera; ?></h1>
            </header>

            <div id="barraLogin">
                <?php 
                    // si hay un usuario conectado muestro el nombre del usuario y en enlace para poder desconectarse
                    if ($acceso->hayUsuario()) {
                        ?> 
                        
                        <p>Bienvenido, <?php echo $acceso->getNombre() ?> <a href="/aplicacion/acceso/loggout.php">Cerrar sesión</a></p>
                        
                        <?php
                    }
                    else {
                        // si no muestro el enlace para el inicio de sesion
                        ?> 
                            <a href="/aplicacion/acceso/login.php">Iniciar sesión</a>
                        <?php
                    }
                
                ?>
            </div>
            <div id="barraMenu">
                <ul>
                    <li><a href="/index.php">Inicio</a></li>

                    <?php 
                        // si hay un usuario conectado muestro los enlaces del menu para el index de la relacion 8 y para la pagina de registrar textos
                        if ($acceso->hayUsuario()) {

                            ?> 
                                <li><a href="/aplicacion/personalizar/index.php">Index R8</a></li>
                                <li><a href="/aplicacion/texto/verTextos.php">Textos</a></li>
                            
                            <?php

                            // si ademas el usuario tiene permisos para ver la pagina de personalizar se muestra el enlace a la pagina de personalizar los colores
                            if ($acceso->puedePermiso(1)) {

                                ?> 
                                    <li><a href="/aplicacion/personalizar/personalizar.php">Personalizar</a></li>
                                <?php
                            }
                        }
                    
                    ?>
                    
                    
                </ul>

            </div>

            <div id="barraUbicacion">
                <?php
                /*if ($ubicacion){
                        
                        foreach($ubicacion as $elemento) {

                            if (isset($elemento["ENLACE"])) {
                                echo "<a href='{$elemento["ENLACE"]}'>";
                                
                            }
                            echo $elemento["TEXTO"];

                            if (isset($elemento["ENLACE"])) {

                                echo "</a>";
                            }

                            if (isset($elemento["ADICIONAL"]))
                                echo $elemento["ADICIONAL"];
                            else
                                echo "&nbsp;&nbsp"; 

                            // otra solucion
                            if (isset($elemento["ENLACE"])) {
                                echo "<a href='{$elemento["ENLACE"]}'>";
                                echo $elemento["TEXTO"];
                                if (isset($elemento["ADICIONAL"]))
                                    echo $elemento["ADICIONAL"];
                                else
                                    echo "&nbsp;&nbsp";   
                                echo "</a>";                         
                            }
                            else {
                                echo $elemento["TEXTO"]."&nbsp;&nbsp;"; 
                                if (isset($elemento["ADICIONAL"]))
                                    echo $elemento["ADICIONAL"];
                                else
                                    echo "&nbsp;&nbsp";       
                                echo "</a>";   
                            }
                                
                        }
                    }*/
                ?>

                <?php
                if (!empty($ubicacion)) {
                    foreach ($ubicacion as $elemento) {
                        if (isset($elemento['ENLACE']))
                            echo '<a href="' . $elemento['ENLACE'] . '">';

                        echo $elemento['TEXTO'];

                        if (isset($elemento['ENLACE']))
                            echo '</a>';

                        if (isset($elemento['ADICIONAL']))
                            echo $elemento['ADICIONAL'];
                        else
                            echo '&nbsp;&nbsp;';
                    }
                }
                ?>


            </div>


            <div>

            <?php

        }

        function finCuerpo()
        {
            ?>
                <br />
                <br />
            </div>
            <footer>
                <hr width="90%" />
                <div>
                    &copy; Copyright by Sergio
                </div>
            </footer>
        </div>
    </body>

    </html>
<?php
        }
