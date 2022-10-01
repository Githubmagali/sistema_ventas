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
        $this->idtipoproducto = isset($request["id"]) ? $request["id"] : "";
        $this->nombre = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        
     
       
    }

    public function insertar()
    {
        //Instancia la clase mysqli con el constructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        //Arma la query
        $sql = "INSERT INTO tipoproductos (
                    nombre
                   
                   
                ) VALUES (
                    '$this->nombre'
                    
                    
                );";
                //si tienen '' porque es una stream '$this->nombre',
        // print_r($sql);exit;
        //Ejecuta la query
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
        $sql = "UPDATE tipoprodutos SET
                nombre = '". $this->nombre. "',
                
                WHERE idtipoproducto = ".$this->idtipoproducto;

        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "DELETE FROM tipoproductos WHERE idtipoproducto= " . $this->idtipoprodcuto;
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT idtipoproducto,
                       
                       
                FROM tipoproductos
                WHERE idtipoproducto = $this->idproducto";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        //Convierte el resultado en un array asociativo
        if ($fila = $resultado->fetch_assoc()) {
            $this->idcliente = $fila["idproducto"];
            $this->nombre = $fila["nombre"];
          
           
        }
        $mysqli->close();

    }

     public function obtenerTodos(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT 
                    idtipoproducto,
                        nombre,
                        
                       
                FROM tipoproductos";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        $aResultado = array();
        if($resultado){
            //Convierte el resultado en un array asociativo
//fila trae los satos 
            while($fila = $resultado->fetch_assoc()){ // mientras fila tenga datos lo va a hacer una y otra vez
                $entidadAux = new TipoProducto(); //entidadAux me sirve para crear el objeto
                $entidadAux->idproducto = $fila["idtipoproducto"];
                $entidadAux->nombre = $fila["nombre"];
                
               
                $aResultado[] = $entidadAux;
            }
        }
        return $aResultado; //finalizado el bucle devuelve el resultado
    }

}
?>