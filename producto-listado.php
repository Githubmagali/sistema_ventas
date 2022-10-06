
   <?php

include_once "config.php";
include_once "entidades/producto.php";
$pg = "Listado de productos"; //nombre de la pagina

$producto= new Producto();
$aProductos = $producto->obtenerTodos();

include_once ("header.php"); //trae la info de html
?>

<div class="container fluid">
    <h1 class="h3 mb-4 text-gray 800">Lista de productos</h1>
    <div class="row">
        <div class="col-12 mb-3"></div>
        <a href="producto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
<table class="table table-hover border">
    <tr>
        <th>Foto</th>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($aProductos as $producto) { ?>
        </div>
    </div>
        <tr>
        <td><img src="files/<?php echo $producto->imagen; ?>" class="img-thumbnail"></td>
            <td><?php echo $producto->nombre; ?></td>
            <td><?php echo $producto->cantidad; ?></td>
            <td>$ <?php echo number_format($producto->precio, 2, ",", "."); ?></td>
                  <td>
                      <a href="producto-formulario.php?id=<?php echo $producto->idproducto; ?>"><i class="fas fa-search"></i></a>   
                  </td>
        </tr>
        <?php } ?>
</table>

</div>
    

      </div>
     
<?php include_once("footer.php"); ?>