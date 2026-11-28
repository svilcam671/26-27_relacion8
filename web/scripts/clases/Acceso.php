<?php 
class Acceso {
    
    // Variables de instancia
    private $_validado;
    private $_nick;
    private $_nombre;
    private $_permisos;
    
    
    // Constructor
    public function __construct() {
        
        $this->_validado=false;
        $this->_nick="";
        $this->_nombre="";
        $this->_permisos=[];
        
        $this->recogerDeSesion();
        
    }
    
    /**
     * Funcion privada para guardar la información en la sesión
     *
     * @return boolean Devuelve true si se ha podido hacer. False en cualquier otro caso
     */
    private function escribirASesion():bool
    {
     if (!isset($_SESSION))    
         return false;
     
     if ($this->_validado)
     {
         $_SESSION["acceso"]["validado"]=true;
         $_SESSION["acceso"]["nick"]=$this->_nick;
         $_SESSION["acceso"]["nombre"]=$this->_nombre;
         $_SESSION["acceso"]["permisos"]=$this->_permisos;
         
     }
     else 
     {
         $_SESSION["acceso"]["validado"]=false;
     }

     return true;
    }
    
    /**
     * Función privada que recoje la información de la sesión
     *
     * @return boolean Devuelve true si se ha podido recoger
     */
    private function recogerDeSesion():bool
    {
       if (!isset($_SESSION) ||
           !isset($_SESSION["acceso"]) ||
           !isset($_SESSION["acceso"]["validado"]) ||
           $_SESSION["acceso"]["validado"]==false)
       {
           $this->_validado=false;
       }
       else 
       {
           $this->_validado=true;
           $this->_nick=$_SESSION["acceso"]["nick"];
           $this->_nombre=$_SESSION["acceso"]["nombre"];
           $this->_permisos=$_SESSION["acceso"]["permisos"];
           
       }

       return true;
        
    }

    /**
     * Sirve para registrar un usuario en la aplicación. Almacena
     * los valores en las propiedades apropiadas y en la sesión 
     * para guardar en la sesión la información del usuario validado.
     *
     * @param string $nick nick del usuario a registrar
     * @param string $nombre nombre del usuario a registrar
     * @param array $permisos permisos del usuario a registrar
     * @return boolean Devuelve true si ha podido registrar el usuario
     */
    public function registrarUsuario(string $nick, string $nombre, array $permisos):bool
     {
        if ($nick == "")
            $this->_validado = false;
        else
            $this->_validado = true;
        $this->_nick = $nick;
        $this->_nombre = $nombre;
        $this->_permisos = $permisos;
        
        if (!$this->escribirASesion())
            return false;

        return true;
    }
    
    
    /**
     * Elimina la información de registro de un usuario
     *
     * @return boolean Devuelve true si ha podido hacerlo
     */
    public function quitarRegistroUsuario():bool {
        $this->_validado = false;
        if (!$this->escribirASesion())
             return false;

        return true;
    }
    
    
    /**
     * Función que devuelve si hay o no un usuario registrado
     *
     * @return boolean Devuelve true si hay usuario registrado. False en caso contrario
     */
    public function hayUsuario():bool {

        return $this->_validado;

     }
    
    
    /**
     * Función que devuelve si el usuario registrado tiene o no el permiso indicado
     *
     * @param integer $numero Numero de permiso a comprobar
     * @return bool Devuelve true si hay usuario registrado y tiene el permiso indicado
     */
    public function puedePermiso(int $numero):bool {
       
        if (!$this->hayUsuario()) {
            return false;
        }

        if (!array_key_exists($numero, $this->_permisos)) {
            return false;
        }
        
        return $this->_permisos[$numero];
        


    }
    
    
    /*
     * Métodos get
     */

     /**
      * Devuelve el nick del usuario indicado o false si no hay usuario
      *
      * @return string|false
      */
    public function getNick():string|false 
    { 
       
        if (!$this->hayUsuario()) {
            return false;
        }

        return $this->_nick;
    }
  
    /**
     * Devuelve el nombre del usuario registrado o false si no hay usuario
     *
     * @return string|false
     */
    public function getNombre():string|false 
    { 
        if (!$this->hayUsuario())
            return false;
        
        return $this->_nombre; 
    }    
    
    /**
     * Metodo magico get que es llamado de forma automatica cuando se quiere obtener informacion sobre una variable, exista o no, del objeto. 
     * La redefinimos para que su uso quede deshabilitado devolviendo un error.
     * @param string $name
     * @return mixed
     */
    public function __get(string $name):mixed {
        throw new Exception("No existe la propiedad $name");
    }

    /**
     * Metodo magico set que es llamado de forma automatica cuando se quiere asignar valor a una variable de la clase exista o no.
     * La redefinimos para que su uso quede deshabilitado devolviendo un error.
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value):void {
        throw new Exception("No existe la propiedad $name por lo que no se puede asignar el valor");
    }

    /**
     * Metodo isset que comprueba si existe una variable en el objeto o no. Devolvemos false para deshabilitarla.
     *
     * @param string $name
     * @return boolean
     */
    public function __isset(string $name):bool {
        return false;
    }

    /**
     * Metodo unset magico que quita el valor de una variable. Devolvemos un mensaje de error para deshabilitarla.
     *
     * @param string $name
     * @return void
     */
    public function __unset(string $name):void {
        throw new Exception("No existe la propiedad $name");
    }
}
