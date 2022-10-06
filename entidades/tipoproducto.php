<?php

class TipoProducto //Cliente es una entidad solo en las tables es en prural
{
    private $idtipoproducto;
    private $nombre;
    
    

    public function __construct() //constructor por defecto
    {


    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
        return $this;
    }

    public function cargarFormulario($request)
    {
        $this->idtipoproducto = isset($request["id"])? $request["id"] : "";
        $this->nombre = isset($request["txtNombre"])? $request["txtNombre"] : "";
        //request lee tanto GET como POST
        }

    public function insertar()
    {
        //Instancia la clase mysqli con el constructor parametrizado
        //Cuatro pasos; Se conecta a la base de datos con la msqly, creandolo primero
        //con el contructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
         //(Congigg::BBDD_HOST es una cadena de conexion cada motor de base de datos tiene un puerto distinto msqly)
        //Arma la query
        $sql = "INSERT INTO tipo_productos (
                    nombre
                   ) VALUES (
                    '$this->nombre'
                    
                    
                );";
                //si tienen '' porque es una stream '$this->nombre',
        // print_r($sql);exit;
        // if Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idtipoproducto = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }

    public function actualizar()
    {

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "UPDATE tipo_productos SET
                nombre = '$this->nombre'
                
                WHERE idtipoproducto = " . $this->idtipoproducto;

        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar() //elimina por ID que lo toma del propio objeto
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "DELETE FROM tipo_productos WHERE idtipoproducto = " . $this->idtipoproducto;
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId()//obtener el cliente
    //crea el objeto
    //arma la base de datos con $sql=SELECT la query
    //FROM selecciona toda la informacion de la table "clientes"
    //where $this->idcliente lo lee del propio objeto
    //if arroja un resultado (objeto)
    //si es verdadero avanza y para PODER MANIPULAR a estos resultados necesitamos ejecutar el metodo fetch_assoc
    
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT idtipoproducto,
                        nombre   
                FROM tipo_productos
                WHERE idtipoproducto = " .  $this->idtipoproducto;
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        
        //Convierte el resultado en un array asociativo. Trae una SOLA FILA DE DATOS NOMAS!!Va de derecha a iz, le pregunta a fetch_assoc almacena todo eso en fila y si fila tiene datos
        //primero hace en fetch_assoc, todo eso lo almacena en fila
        //pregunta $fila contienen datos, si contiene datos ingresa
        //si fila contiene datos SELO ASIGNA AL PROPIO OBJETO
        //le almacena datos al prodpio objeto
        if ($fila = $resultado->fetch_assoc()) {
            
            $this->nombre = $fila["nombre"];
          
           
        }
        $mysqli->close();

    }
//Obtener todos es por si queremos traer la info de todos los clientes, entonces no pongo ninguna clusula WHERE
        //PORQUE ES UN OBTENER TODOS
     public function obtenerTodos(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT 
                    idtipoproducto,
                        nombre
                        FROM tipo_productos";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        $aResultado = array();
        if($resultado){
            //Convierte el resultado en un array asociativo
//fila trae los satos 
            while($fila = $resultado->fetch_assoc()){ // mientras fila tenga datos lo va a hacer una y otra vez
                $entidadAux = new TipoProducto(); //entidadAux me sirve para crear el objeto
                $entidadAux->idtipoproducto = $fila["idtipoproducto"];
                $entidadAux->nombre = $fila["nombre"];
                
               
                $aResultado[] = $entidadAux;
            }
        }
        return $aResultado; //finalizado el bucle devuelve el resultado
    }

}
?>