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
            "TEXTO"=>"Login",
            "ADICIONAL" => " >> "
        ]
];

//$usuario=getenv("MYSQL_USER");

// variable para guardar el error en caso de fallo al iniciar sesion
$error="";

// variable para guardar el usuario que llega del formulario
$usuario = "";

// compruebo que llega la peticion del formulario de inicio de sesion con los datos
if (isset($_POST["login"])) {

    // recupero el usuario del formulario y quito los espacios en el nombre
    $usuario = isset($_POST["usuario"])?trim($_POST["usuario"]):"";

    // recupero la contraseña del formulario y quito los espacios
    $contrasena = isset($_POST["contrasena"])?trim($_POST["contrasena"]):"";

    // apartir del nombre de usuario saco el codigo de usuario 
    $codUsuario = $acl->getCodUsuario($usuario);

    // si el usuario existe y la contraseña es correcta y si el usuario no esta borrado
    if ($acl->esValido($usuario, $contrasena) && !$acl->getBorrado($codUsuario)) {

        // registro el usuario en la sesion con el usuario (nick), el nombre del usuario guardado y los permisos de ese usuario
        $acceso->registrarUsuario($usuario, $acl->getNombre($codUsuario), $acl->getPermisos($codUsuario));

        // redirecciono a la ultima direccion visitada antes de ir al formulario de inicio de sesion
        $dir = $_SESSION["paginaActual"];
        header("Location: $dir");
        exit;
    }
    else {

        // si no guardo un error 
        $error="* Usuario o contraseña no validos";
    }


}


//dibuja la plantilla de la vista
inicioCabecera("Login R8");
cabecera();
finCabecera();
inicioCuerpo("Login", $barra );
cuerpo($usuario, $error);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{

}

//vista
function cuerpo(string $usuario, string $error) {
?>
    <h2>Iniciar sesión</h2>
    <form action="login.php" method="post">

        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario ?>">
        <br>
        <label for="contrasena">Contraseña</label>
        <input type="password" name="contrasena" id="contrasena">
        <?php  

            // si hay un error guardado lo muestro 
            if ($error !== "") {
                ?><br> <small class="error"> <?php echo $error ?> </small> <?php
            }
        ?>
        <br><br>
        <input type="submit" name="login" value="Iniciar sesión">

    </form>
<?php
}
