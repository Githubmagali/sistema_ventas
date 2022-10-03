<?php

class Producto //Cliente es una entidad solo en las tables es en prural
{
    private $idproducto;
    private $nombre;
    private $fk_idtipoproducto;
    private $cantidad;
    private $precio;
    private $descripcion;
    private $imagen;
    
    

    public function __construct() //constructor por defecto
    {
$this->cantidad=0.0;
$this->precio=0.0;

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
        $this->idproducto = isset($request["id"]) ? $request["id"] : "";
        $this->nombre = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->fk_idproducto = isset($request["lstTipoProducto"]) ? $request["lstTipoProducto"] : "";
        $this->cantidad = isset($request["txtCantidad"]) ? $request["txtCantidad"] : "";
        $this->precio = isset($request["txtPrecio"]) ? $request["txtPrecio"] : "";
        $this->descripcion = isset($request["txtDescripcion"]) ? $request["txtDescripcion"] : "";
    
       
    
    }

    public function insertar()
    {
        //Instancia la clase mysqli con el constructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        //Arma la query
        $sql = "INSERT INTO productos (
                    nombre,
                    fk_idtipoproducto,
                    cantidad,
                    precio,
                    descripcion,
                    imagen,
                    
                   
                ) VALUES  (
                    '$this->nombre',
                    $this->fk_idtipoproducto,
                    $this->cantidad, 
                    $this->precio, 
                    '$this->descripcion',
                    '$this->imagen',
                    
                    
                );"; //la comilla simple' ' va a ir solo par los valores que NO son de tipo numerico
                //si tienen '' porque es una stream '$this->nombre',
        // print_r($sql);exit;
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idproducto = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }

    public function actualizar()
    {

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "UPDATE clientes SET
                nombre = '". $this->nombre. "',
               cantidad = '".$this->cantidad."',
                precio = '".$this->precio."',
                descripcion = '".$this->descripcion."',
                imagen =  '".$this->imagen."',
                fk_idtipoproducto=  '".$this->fk_idtipoproducto."',
                
                WHERE idproducto = ".$this->idproducto;

        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "DELETE FROM productos WHERE idproducto= " . $this->idprodcuto;
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT idproducto,
                        nombre,
                        fk_idtipoproducto,
                        cantidad,
                       precio,
                        descripcion,
                        imagen
                        
                       
                FROM productos
                WHERE idproducto = $this->idproducto";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        //Convierte el resultado en un array asociativo
        if ($fila = $resultado->fetch_assoc()) {
            $this->idcliente = $fila["idproducto"];
            $this->nombre = $fila["nombre"];
            $this->fk_idtipoproducto = $fila["fk_idtipoproducto"];
            $this->cantidad = $fila["cantidad"];
            $this->precio = $fila["precio"];
            $this->descripcion = $fila["descripcion"];
            $this->imagen = $fila["imagen"];
            
           
        }
        $mysqli->close();

    }

     public function obtenerTodos(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT 
                    idproducto,
                        nombre,
                        fk_idtipoproducto,
                        cantidad,
                       precio,
                        descripcion,
                        imagen
                        
                       
                FROM productos";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        $aResultado = array();
        if($resultado){
            //Convierte el resultado en un array asociativo
//fila trae los satos 
            while($fila = $resultado->fetch_assoc()){ // mientras fila tenga datos lo va a hacer una y otra vez
                $entidadAux = new Producto(); //entidadAux me sirve para crear el objeto
                $entidadAux->idproducto = $fila["idproducto"];
                $entidadAux->nombre = $fila["nombre"];
                $entidadAux->fk_idtipoproducto = $fila["fk_idtipoproducto"];
                $entidadAux->cantidad = $fila["cantidad"];
                $entidadAux->precio = $fila["precio"];
                $entidadAux->descripcion= $fila["descripcion"];
                $entidadAux->imagen = $fila["imagen"];
                
               
                $aResultado[] = $entidadAux;
            }
        }
        return $aResultado; //finalizado el bucle devuelve el resultado
    }

}
?>