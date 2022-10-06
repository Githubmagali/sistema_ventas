<?php

include_once "config.php";
include_once "entidades/tipoproducto.php";
$pg = "Listado de tipo de productos";

$tipoproducto = new Tipoproducto();
$aTipoProductos = $tipoproducto->obtenerTodos();

include_once("header.php"); 
?>

<div class="container fuid">

<h1 class="h3 mb-4 text-gray-800">Lista de productos</h1>
<div class="row">
   <div class="col-12  mb-3">
    <a href="tipoproducto-formulario.php"class="btn btn-primary">Nuevo</a>
   </div>
</div>
<table class="table table-hover border">
<tr>
    <th>Nombre</th>
    <th>Acciones</th>
</tr>
    <?php foreach($aTipoProductos as $tipo) { ?>
        <tr>
            <td><?php echo $tipo->nombre; ?></td>
            <td>
        <a href="tipoproducto-formulario.php?id=<?php echo $tipo->idtipoproducto; ?>"><i class="fas fa-search"></i></a>
    </td>
        </tr>

<?php }?>
</table>
</div>
</div>
<?php include_once("footer.php"); ?>