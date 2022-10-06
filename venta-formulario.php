<?php

include_once "config.php";
include_once "entidades/venta.php";
include_once "entidades/cliente.php";
include_once "entidades/producto.php";

$pg="Edicion de venta";

$venta=new Venta();
$venta->cargarFormulario($_REQUEST);

if ($_POST){
    if(isset($_POST["btnGuardar"])){
      if (isset($_GET["id"])&& $_GET["id"]>0){
        $venta->actualizar();
      }
    } else
    {
        $venta->insertar();}


        $msg ["texto"]= "Guardado correctamente";
        $msg["codigo"] = "Sin stock";
    } else if (isset ($_POST ["btnBorrar"])){
        $venta->eliminar();
        header ("Location:venta-listado.php");
    }
    include_once("header.php"); 
?>

<div class="container-fluid">
    <h1 class="h3 mb-4">Venta</h1>
    <div class="row">
        <div class="col-12">
            <a href="ventas.php"class="btn btn-primary">Listado</a>
            <a href="venta-formulario.php"class="btn btn-primary">Nuevo</a>
            <button type="submit"class="btn btn-success"id="btnGuardar"name="btnGuardar">Guardar</button>
            <button type="submit" class="btn btn-danger"id="btnBorrar"name="btnBorrar">Borrar</button>
        </div>
    </div>
    <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Venta</h1>
          <?php if(isset($msg)){ ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert <?php echo $msg["codigo"]; ?>" role="alert">
                        <?php echo $msg["texto"]; ?>
                    </div>
                </div>
            </div>
            <?php } ?>

            