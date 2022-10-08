<?php

class Venta //Cliente es una entidad solo en las tables es en prural
{
    private $idventa;
    private $fk_idcliente;
    private $fk_idproducto;
    private $fecha;
    private $cantidad;
    private $preciounitario;
    private $total;
   

    private $nombre_cliente;
    private $nombre_producto;

    public function __construct() //constructor por defecto
    {
        $this->cantidad = 0;
        $this->preciounitario = 0.0;
        $this->total = 0.0;

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
        $this->idventa = isset($request["id"]) ? $request["id"] : "";
        $this->fk_idcliente = isset($request["lstCliente"]) ? $request["lstCliente"] : "";
        $this->fk_idproducto = isset($request["lstProducto"])? $request["lstProducto"]: "";
        if(isset($request["txtAnio"]) && isset($request["txtMes"]) && isset($request["txtDia"])){
            $this->fecha = $request["txtAnio"] . "-" .  $request["txtMes"] . "-" .  $request["txtDia"] . " " . $request["txtHora"];
        }
        $this->cantidad= isset($request["txtCantidad"]) ? $request["txtCantidad"] : 0;
        $this->preciounitario = isset($request["txtPreciouni"]) ? $request["txtPreciouni"] :0;
        $this->total = $this->preciounitario * $this->cantidad;
       
       
    }

    public function insertar()
    {
        //tiene 4 instancias el metodo insertar, primero se conecta con la base de datos usando la clase mysqli
        //crea el objeto mysqli con el constructor parametrizado que tiene la cadena de conexion
        //cada base de datos tiene un puerto distinto, el de myslqli es 3306 
        //Instancia la clase mysqli con el constructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        //Arma la query que es un stream que va a insertar dentro de a tabla clientes las columnas que 
        //nosotros indicamos y los valores del propio objeto VALUES ($this->fk_idcliente... )en el orden de INSERT,
        //no importa el orden de la tabla, solo este
        $sql = "INSERT INTO ventas ( 
                    fk_idcliente,
                    fk_idproducto,
                    fecha,
                    cantidad,
                    preciounitario,
                    total
                    
                ) VALUES (
                    $this->fk_idcliente,
                    $this->fk_idproducto, 
                    '$this->fecha',
                    $this->cantidad,
                    $this->preciounitario,
                    $this->total
                   
                   
                );";
                
        //El stream lo toma el apache y lo ejecuta en msql a traves de la clase msqli
                //si tienen '' porque es una stream '$this->nombre',
        // if llama a la query en la msqli y le enviamos por PARAMETRO este stream ( objeto de tipo resource que puede ser leído o escrito de una forma lineal)
        //esto lo que va a hacer es ejecutar el stram dentro de la base de datos
        //Ejecuta la query
        //cuando insertamos un registro en la table el id es AUTOINCREMENTAL, no sabemos que nro le va a poner PERO nos lo infrma a traves de  $mysqli->insert_id
        //asi obtenemos el utimo id insertado QUE se lo asignamos al prodpio objeto
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idcliente = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }

    public function actualizar() //metodo actualizar con la clausula UPDATE que tmbn son 4 partes
    //se crea el objeto msqli
    {

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "UPDATE ventas SET
                fk_idcliente = '". $this->fk_idcliente. "',
                fk_idproducto = '".$this->fk_idproducto."',
                fecha= '".$this->fecha."',
                cantidad = '".$this->cantidad."',
                preciounitario=  '".$this->preciounitario."',
                total =  '".$this->total."'
               
                
                WHERE idventa = ".$this->idventa;

        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "DELETE FROM ventas WHERE idventa = " . $this->idventa;
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT idventa,
                        fk_idcliente,
                        fk_idproducto,
                        fecha,
                        cantidad,
                        preciounitario,
                        total
                        
                        
                FROM ventas
                WHERE idventa = $this->idventa";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        //Convierte el resultado en un array asociativo
        if ($fila = $resultado->fetch_assoc()) {
            $this->idventa = $fila["idventa"];
            $this->fk_idcliente = $fila["fk_idcliente"];
            $this->fk_idproducto = $fila["fk_idproducto"];
            $this->fecha = $fila["fecha"];
            $this->cantidad = $fila["cantidad"];
            $this->preciounitario = $fila["preciounitario"];
            $this->total = $fila["total"];
           
        }
        $mysqli->close();

    }

     public function obtenerTodos(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT 
                    idventa,
                    fk_idcliente,
                    fk_idproducto,
                    fecha,
                    cantidad,
                    preciounitario,
                    total
                   
                FROM ventas";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        $aResultado = array();
        if($resultado){
            //Convierte el resultado en un array asociativo
//fila trae los satos 
            while($fila = $resultado->fetch_assoc()){ // mientras fila tenga datos lo va a hacer una y otra vez
                $entidadAux = new Venta(); //entidadAux me sirve para crear el objeto
                $entidadAux->idventa = $fila["idventa"];
                $entidadAux->fk_idcliente= $fila["fk_idcliente"];
                $entidadAux->fk_idproducto = $fila["fk_idproducto"];
                $entidadAux->fecha = $fila["fecha"];
                $entidadAux->cantidad = $fila["cantidad"];
                $entidadAux->preciounitario = $fila["preciounitario"];
                $entidadAux->total= $fila["total"];
             
               
                $aResultado[] = $entidadAux;
            }
        }
        return $aResultado; //finalizado el bucle devuelve el resultado
    }

    public function cargarGrilla(){
        $mysqli= new mysqli (Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
    $sql = "SELECT
    V.idventa,
    V.fecha,
    V.cantidad,
    V.fk_idcliente,
    C.nombre as nombre_cliente,
    V.fk_idproducto,
    V.total,
    V.preciounitario,
    P.nombre as nombre_producto
    FROM ventas V
    INNER JOIN clientes C ON V.fk_idcliente= C.idcliente
    INNER JOIN productos P ON V.fk_idproducto= P.idproducto
    ORDER BY V.fecha DESC";

if (!$resultado = $mysqli->query($sql)) {
    printf("Error en query: %s\n", $mysqli->error . " " . $sql);
    
    }
    $aResultado = array();
        if($resultado){
            //Convierte el resultado en un array asociativo
            while($fila = $resultado->fetch_assoc()){
                $entidadAux = new Venta();
                $entidadAux->idventa = $fila["idventa"];
                $entidadAux->fk_idcliente = $fila["fk_idcliente"];
                $entidadAux->fk_idproducto = $fila["fk_idproducto"];
                $entidadAux->fecha = $fila["fecha"];
                $entidadAux->cantidad = $fila["cantidad"];
                $entidadAux->preciounitario = $fila["preciounitario"];
                $entidadAux->nombre_cliente = $fila["nombre_cliente"];
                $entidadAux->nombre_producto = $fila["nombre_producto"];
                $entidadAux->total = $fila["total"];
                $aResultado[] = $entidadAux;
            }
        }
        $mysqli->close();
        return $aResultado;
    }
    public function obtenerFacturacionMensual($mes){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE,  Config::BBDD_PORT);
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE MONTH(fecha) = $mes";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $fila = $resultado->fetch_assoc();
        $mysqli->close();
        return $fila["total"];
    }

    public function obtenerFacturacionAnual($anio){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE YEAR(fecha) = $anio";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $fila = $resultado->fetch_assoc();
        $mysqli->close();
        return $fila["total"];
    }


}
?>