
<?php

include_once "config.php";
include_once "entidades/tipoproducto.php";



$tipoproducto = new tipoProducto();
$tipoproducto->cargarFormulario($_REQUEST);
$pg = "Edición de tipos de producto";

if ($_POST) {

    if (isset($_POST["btnGuardar"])) {
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            //Actualizo un producto existente
            $tipoproducto->actualizar();
        } else {
            //Es nuevo
            $tipoproducto->insertar();
        }
    } else if (isset($_POST["btnBorrar"])) {
        $tipoProducto->eliminar();
        header("Location: tipooroducto-listado.php");
    }
}

if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $tipoproducto->obtenerPorId();
}


include_once "header.php";
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Tipo de productos</h1>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="tipodeproductos.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="tipoproducto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
           
                <div class="col-12 mb-3 form-group">
                    <label for="txtCuit">Nombre:</label>
                    <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $tipoproducto->nombre; ?>">
                </div>
                
                
            </div>
        </div>
      

      </div>
<?php include_once ("footer.php");?>