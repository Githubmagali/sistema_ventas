<?php

include_once "config.php"; //en sus distintas operaciones hace in insert, delete, etc, para poder
//conectarse a la base de datos y hacer esas operacioes necesitamos las constantes de la conexion que estan en config, por eso lo incluyo antes
include_once "entidades/tipoproducto.php";



$pg= "Edición de tipo de productos";
$tipoproducto= new Tipoproducto();
$tipoproducto->cargarFormulario($_REQUEST);
if($_POST){


    if (isset($_POST["btnGuardar"])){
        if (isset($_GET ["id"]) && $_GET ["id"] >0){

            $tipoProducto->actualizar(); //actualizar lo lee desde el propio objeto. El objeto con los datos se carga en cargar formulario
        } else {
         $tipoProducto->insertar();} //pasa los mismo que en actualizar, lo inserta donde tiene el objeto cargaddo $this->nombre
    
    $msg["texto"]= "Gaurdado correctamente";
    $msg["codigo"]= "alert-success";
} else if (isset($_POST["btnBorrar"])){
    $tipoProducto->eliminar();
    header("Location:cliente-listado.php");
}
}

if (isset($_GET["id"])&&($GET["id"])>0){
    $tipoproducto->obtenerPorId();
}