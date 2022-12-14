
<?php

include_once "config.php";
include_once "entidades/cliente.php";
include_once "entidades/provincia.php";
include_once "entidades/localidad.php";
include_once "entidades/venta.php";

$cliente = new Cliente(); 
$cliente->cargarFormulario($_REQUEST); //request va a obtener los datos que vienen desde POST
//si hago POST $cliente va a estar lleno de los datos del formulario
$pg = "Listado de clientes";//titulo de la pag
//crea la variable $pg
if($_POST){ //boton del tipo SUBMIT
    //Voy a saber si esta actualizando o es nuvo por el id en la query stream. Si el id es mayor que 0
    //voy a actualizar sino voy a insertar
    if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"]) && $_GET["id"] > 0){
              //Actualizo un cliente existente
              $cliente->actualizar(); //voy a saber si el cliente lo estoy actualizando o insertando porque el id aparece en el codigo de la pagino ej; .php?=id23
        } else {
            //Es nuevo porque el valor es menor que 0
            $cliente->insertar();
        }
        $msg["texto"] = "Guardado correctamente";
        $msg["codigo"] = "alert-success";

    } else if(isset($_POST["btnBorrar"])){

    
        $venta = new Venta();
        if ($venta->obtenerVentasPorCliente($cliente->idcliente)){
            $msg["texto"] = "No se puede eliminar un cliente con ventas asociadas correctamente";
            $msg["codigo"] = "alert-success";
        }else{
        $cliente->eliminar();
        header("Location: cliente-listado.php");
        }
    }
} 

if(isset($_GET["do"]) && $_GET["do"] == "buscarLocalidad" && $_GET["id"] && $_GET["id"] > 0){
    $idProvincia = $_GET["id"];
    $localidad = new Localidad();
    $aLocalidad = $localidad->obtenerPorProvincia($idProvincia);
    echo json_encode($aLocalidad);
    exit;
} 
if(isset($_GET["id"]) && $_GET["id"] > 0){
    $cliente->obtenerPorId();
}


$provincia = new Provincia();
$aProvincias = $provincia->obtenerTodos();


$localidad = new Localidad();
$aLocalidades = $localidad->obtenerTodos();

include_once("header.php"); 
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Cliente</h1>
          <?php if(isset($msg)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert <?php echo $msg["codigo"]; ?>" role="alert">
                        <?php echo $msg["texto"]; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="cliente-listado.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="cliente-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-6 form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $cliente->nombre ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtCuit">CUIT:</label>
                    <input type="text" required class="form-control" name="txtCuit" id="txtCuit" value="<?php echo $cliente->cuit ?>" maxlength="11">
                </div>
                <div class="col-6 form-group">
                    <label for="txtCorreo">Correo:</label>
                    <input type="" class="form-control" name="txtCorreo" id="txtCorreo" required value="<?php echo $cliente->correo ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtTelefono">Tel??fono:</label>
                    <input type="number" class="form-control" name="txtTelefono" id="txtTelefono" value="<?php echo $cliente->telefono ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtFechaNac" class="d-block">Fecha de nacimiento:</label>
                    <select class="form-control d-inline"  name="txtDiaNac" id="txtDiaNac" style="width: 80px">
                        <option selected="" disabled="">DD</option>
                        <?php for($i=1; $i <= 31; $i++): ?>
                            <?php if($cliente->fecha_nac != "" && $i == date_format(date_create($cliente->fecha_nac), "d")): ?>
                            <option selected><?php echo $i; ?></option>
                            <?php else: ?>
                            <option><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <select class="form-control d-inline"  name="txtMesNac" id="txtMesNac" style="width: 80px">
                        <option selected="" disabled="">MM</option>
                        <?php for($i=1; $i <= 12; $i++): ?>
                            <?php if($cliente->fecha_nac != "" && $i == date_format(date_create($cliente->fecha_nac), "m")): ?>
                            <option selected><?php echo $i; ?></option>
                            <?php else: ?>
                            <option><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <select class="form-control d-inline"  name="txtAnioNac" id="txtAnioNac" style="width: 100px">
                        <option selected="" disabled="">YYYY</option>
                        <?php for($i=1900; $i <= date("Y"); $i++): ?>
                         <?php if($cliente->fecha_nac != "" && $i == date_format(date_create($cliente->fecha_nac), "Y")): ?>
                            <option selected><?php echo $i; ?></option>
                            <?php else: ?>
                            <option><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?> ?>
                    </select>
                </div>
            </div>
            <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-table"></i> Domicilios
                    </div>
                    <div class="row panel-body p-3">
                        <div class="col-6 form-group">
                            <label for="txtTelefono">Provincia:</label>
                            <select class="form-control selectpicker" name="lstProvincia" id="lstProvincia" data-live-search="true" required>
                                <option value="" disabled selected>Seleccionar</option>
                                <?php foreach($aProvincias as $provincia): ?>
                                    <?php if($provincia->idprovincia == $provincia->idprovincia): ?>
                                        <option selected value="<?php echo $provincia->idprovincia; ?>"><?php echo $provincia->nombre; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $provincia->idprovincia; ?>"><?php echo $provincia->nombre; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="txtLocalidad">Localidad:</label>
                            <select class="form-control" name="lstLocalidad" id="lstLocalidad" data-live-search="true" required>
                                <option value="" disabled selected>Seleccionar</option>
                             <?php foreach ($aLocalidades as $localidad): ?>
                                <?php if ($idlocalidad == $localidad->fk_idlocalidad): ?>
                                    <option selected value="<?php echo $localidad->idlocalidad; ?>">
                                <?php echo $localidad->nombre; ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $localidad->idlocalidad; ?>"><?php echo $localidad->nombre; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?></select>
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtTelefono">Direcci??n:</label>
                            <input type="text" class="form-control" name="txtDomicilio" id="txtDomicilio" value="<?php echo $cliente->domicilio ?>">
                        </div>
                    </div>
                </div>
            </div>
            </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<script>
$(document).ready( function () {
    var idCliente = '<?php echo isset($cliente) && $cliente->idcliente > 0? $cliente->idcliente : 0 ?>';

} );

 function fBuscarLocalidad(){
            idProvincia = $("#lstProvincia option:selected").val();
            $.ajax({
                type: "GET",
                url: "cliente-formulario.php?do=buscarLocalidad",
                data: { id:idProvincia },
                async: true,
                dataType: "json",
                success: function (respuesta) {
                    let resultado = "<option value='0' disabled selected>Seleccionar</option>";
                    respuesta.forEach(function(valor, indice){
                        resultado += `<option value="${valor.idlocalidad}">${valor.nombre}</option>`;
                    });
                  $("#lstLocalidad").empty().append(resultado);
                }
            });
        }

</script>
<?php include_once("footer.php"); ?>