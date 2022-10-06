<?php

include_once "config.php";
include_once "tipoproducto.php";
$pg= "Listado de los productos";

$tipoProducto= new TipoProducto();
$aProducto = $producto->obtenerTodos();

include_once("header.php");
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Listado de productos</h1>
    <div class="row">
        <div class="col-12 mb-3">
            <a href="tipoproducto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>

        </div>
    </div>
    <table class="table table-hover border">
        <tr>Nombre</tr>
        <tr>Acciones</tr>
        <?php foreach ($aTipoProductos as $tipo){ ?>
            <tr>
                <td><?php echo $tipo->nombre; ?></td>
                <td style="width: 110px;">
            <a href="tipoproducto-formulario.php?id=<?php echo $tipo->idtipoproducto; ?>"><i class="fas fa-search"></i></a>
        </td>
            </tr>
            <?php }?>
    </table>
</div>

<?php include_once("footer.php"); ?>
 
<div class="container-fluid">
    <h1 class="h3">Listado de productos</h1>
    <div class="row">
        <div class="col-12">
            <a href="tipoproducto-formulario.php" class="btn">Nuevo</a>
        </div>
    </div>
    <table class="table table-hover border">
        <tr>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($aTipoProductos as $tipoProducto){ ?>
            <tr>
                <td><?php echo $tipoProducto->nombre; ?></td>
                <td stlyle="width: 110px;"></td>
                <a href="tipoproducto-formulario.php?id=<?php echo $tipoProducto->idtipoproducto;?>"></a>
            </tr>
<? }?>
    </table>
</div>