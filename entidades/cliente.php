<?php

class Cliente 
{
    private $idcliente;
    private $nombre;
    private $cuit;
    private $telefono;
    private $correo;
    private $fecha_nac;
    private $fk_idprovincia;
    private $fk_idlocalidad;
    private $domicilio;

    public function __construct() 
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
    //si recargo los datos y hago POST viene con datos el $request cliente almacenandolo en el PROPIO OBJETO, pero si no hago
//POST el unico que puede almacenar es idcliente que va a ir cuando ingreso por la lupa
    {
        $this->idcliente = isset($request["id"]) ? $request["id"] : "";
        $this->nombre = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->cuit = isset($request["txtCuit"]) ? $request["txtCuit"] : "";
        $this->telefono = isset($request["txtTelefono"]) ? $request["txtTelefono"] : "";
        $this->correo = isset($request["txtCorreo"]) ? $request["txtCorreo"] : "";
        $this->fk_idprovincia = isset($request["lstProvincia"]) ? $request["lstProvincia"] : "";
        $this->fk_idlocalidad = isset($request["lstLocalidad"]) ? $request["lstLocalidad"] : "";
        $this->domicilio = isset($request["txtDomicilio"]) ? $request["txtDomicilio"] : "";
        if (isset($request["txtAnioNac"]) && isset($request["txtMesNac"]) && isset($request["txtDiaNac"])) {
            $this->fecha_nac = $request["txtAnioNac"] . "-" . $request["txtMesNac"] . "-" . $request["txtDiaNac"];
        }
    }

    public function insertar()
    {
        
        //Instancia la clase mysqli con el constructor parametrizado
        //Cuatro pasos; Se conecta a la base de datos con la msqli, creandolo primero
        //con el contructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        
        //(Congigg::BBDD_HOST es una cadena de conexion cada motor de base de datos tiene un puerto distinto msqly)
        //Arma la query con $sql
        $sql = "INSERT INTO clientes (
                    nombre,
                    cuit,
                    telefono,
                    correo,
                    fecha_nac,
                    fk_idprovincia,
                    fk_idlocalidad,
                    domicilio
                ) VALUES (
                    '$this->nombre',
                    '$this->cuit', 
                    '$this->telefono',
                    '$this->correo',
                    '$this->fecha_nac',
                    $this->fk_idprovincia,
                    $this->fk_idlocalidad,
                    '$this->domicilio'
                );";
                //si tienen '' porque es una stream (que es lineal) '$this->nombre',
       //si tienen '' porque es una stream '$this->nombre',
        
        // if Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idcliente = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }

    public function actualizar()
    {

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "UPDATE clientes SET
                nombre = '". $this->nombre. "',
                cuit = '".$this->cuit."',
                telefono = '".$this->telefono."',
                correo = '".$this->correo."',
                fecha_nac =  '".$this->fecha_nac."',
                fk_idprovincia =  '".$this->fk_idprovincia."',
                fk_idlocalidad =  '".$this->fk_idlocalidad."',
                domicilio =  '".$this->domicilio."'
                
                WHERE idcliente = ".$this->idcliente;

        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar() //elimina por ID que lo toma del propio objeto
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "DELETE FROM clientes WHERE idcliente = " . $this->idcliente;
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
        $sql = "SELECT idcliente,
                        nombre,
                        cuit,
                        telefono,
                        correo,
                        fecha_nac,
                        fk_idprovincia,
                        fk_idlocalidad,
                        domicilio
                FROM clientes
                WHERE idcliente = $this->idcliente";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        //Convierte el resultado en un array asociativo. Trae una SOLA FILA DE DATOS NOMAS!!Va de derecha a iz, le pregunta a fetch_assoc almacena todo eso en fila y si fila tiene datos
        //primero hace en fetch_assoc, todo eso lo almacena en fila
        //pregunta $fila contienen datos, si contiene datos ingresa
        //si fila contiene datos SELO ASIGNA AL PROPIO OBJETO
        //le almacena datos al prodpio objeto
        if ($fila = $resultado->fetch_assoc()) {
            $this->idcliente = $fila["idcliente"];
            $this->nombre = $fila["nombre"];
            $this->cuit = $fila["cuit"];
            $this->telefono = $fila["telefono"];
            $this->correo = $fila["correo"];
            if(isset($fila["fecha_nac"])){
                $this->fecha_nac = $fila["fecha_nac"];
            } else {
                $this->fecha_nac = "";
            }
            $this->fk_idprovincia = $fila["fk_idprovincia"]; //La llave foranea se traa como un numero
            $this->fk_idlocalidad = $fila["fk_idlocalidad"];
            $this->domicilio = $fila["domicilio"];
        }
        $mysqli->close();

    }

     public function obtenerTodos(){ 
        //Obtener todos es por si queremos traer la info de todos los clientes, entonces no pongo ninguna clusula WHERE
        //PORQUE ES UN OBTENER TODOS
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT 
                    idcliente,
                    nombre,
                    cuit,
                    telefono,
                    correo,
                    fecha_nac,
                    fk_idprovincia,
                    fk_idlocalidad,
                    domicilio
                FROM clientes";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        $aResultado = array();
        //la query arroja un objeto resultado
        //array almacen los diferentes resultados porque tenemos una fila de datos
       
        if($resultado){
            //Convierte el resultado en un array asociativo
//fila trae los satos 
//while es un bucle y sin el se alamcenaria todo en 
            while($fila = $resultado->fetch_assoc()){ // mientras fila tenga datos lo va a hacer una y otra vez
                $entidadAux = new Cliente(); //entidadAux me sirve para crear el objeto, LOS DATOS LOS TRAE $FILA
                $entidadAux->idcliente = $fila["idcliente"];
                $entidadAux->nombre = $fila["nombre"];
                $entidadAux->cuit = $fila["cuit"];
                $entidadAux->telefono = $fila["telefono"];
                $entidadAux->correo = $fila["correo"];
                if(isset($fila["fecha_nac"])){
                    $entidadAux->fecha_nac = $fila["fecha_nac"];
                } else {
                    $entidadAux->fecha_nac = "";
                }
                $entidadAux->fk_idprovincia = $fila["fk_idprovincia"];
                $entidadAux->fk_idlocalidad = $fila["fk_idlocalidad"];
                $entidadAux->domicilio = $fila["domicilio"];
                $aResultado[] = $entidadAux;
            }
        }
        return $aResultado; //finalizado el bucle devuelve el resultado
    }

}
?>