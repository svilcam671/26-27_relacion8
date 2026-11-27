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

$error="";
$usuario = "";

if (isset($_POST["login"])) {

    $usuario = isset($_POST["usuario"])?trim($_POST["usuario"]):"";
    $contrasena = isset($_POST["contrasena"])?trim($_POST["contrasena"]):"";
    $codUsuario = $acl->getCodUsuario($usuario);

    if ($acl->esValido($usuario, $contrasena) && !$acl->getBorrado($codUsuario)) {

        $acceso->registrarUsuario($usuario, $acl->getNombre($codUsuario), $acl->getPermisos($codUsuario));

        header("Location: $paginaActual");
        exit;
    }
    else {
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
            if ($error !== "") {
                ?> <small class="error"> <?php echo $error ?> </small> <?php
            }
        ?>
        <br><br>
        <input type="submit" name="login" value="Iniciar sesión">

    </form>
<?php
}
