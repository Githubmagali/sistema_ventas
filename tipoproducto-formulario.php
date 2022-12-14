
<?php

include_once "config.php";
include_once "entidades/tipoproducto.php";
include_once "entidades/producto.php";


$tipoproducto = new tipoProducto();
$tipoproducto->cargarFormulario($_REQUEST);
$pg = "Edición de tipos de producto";

if($_POST){
    if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"]) && $_GET["id"] > 0){
              //Actualizo un  registro existente
              $tipoproducto->actualizar();
        } else {
            //Es nuevo
            $tipoproducto->insertar();
        }
    } else if(isset($_POST["btnBorrar"])){
        $tipoproducto->cargarFormulario($_REQUEST);
   

        $producto = new Producto();
        if ($producto->obtenerporTipo($tipoProducto->idtipoproducto)){
            $msg["texto"] = "No se puede elimina un tipo de producto con productos asociados.";
            $msg["codigo"] = "alert-danger";
        } else {
            $tipoProducto->eliminar();
            header("Location: tipoproducto-listado.php");
        }
    }
    if (isset($_GET["id"]) && $_GET["id"] > 0){
        $tipoProducto->cargarFormulario($_REQUEST);
        $tipoProducto->obtenerPorId();
    }
}

include_once "header.php";
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Tipo de productos</h1>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="tipoproducto-listado.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="tipoproducto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>

           <div class="row">
                <div class="col-12  form-group">
                    <label for="txtCuit">Nombre:</label>
                    <input type="text" required="" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $tipoproducto->nombre; ?>">
                </div>
                
                
            </div>
        </div>
      

      </div>
<?php include_once ("footer.php");?>