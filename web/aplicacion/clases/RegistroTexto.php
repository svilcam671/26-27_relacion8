<?php 

class RegistroTexto {

    // Propiedades privadas
    private string $_cadena;
    private DateTime $_fechaHora;

    /**
     * Constructor que recibe una cadena como parametro y pone la fecha y hora actual al momento de crear una instancia
     *
     * @param string $cadena recibe una cadena de texto
     */
    public function __construct(string $cadena) {
        
        $this->_cadena = $cadena;
        $this->_fechaHora = new DateTime();

    }

    // Metodos getter
    public function getCadena(): string {
        return $this->_cadena;
    }

    public function getFechaHora(): DateTime {
        return $this->_fechaHora;
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