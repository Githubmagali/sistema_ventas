<?php

include_once "config.php";
include_once "entidades/cliente.php";
$pg = "Listado de clientes";

$cliente = new Cliente();
$aClientes = $cliente->obtenerTodos();



include_once("header.php");

?>

<div class="container-fluid">

    <h1 class="h3 mb-4">Listado de clientes</h1>
    <div class="row">
        <div class="col-12">
            <a href="cliente-formulario.php" class="btn btn-primary">Nuevo</a>
        </div>
    </div>
    <table class="table table-hover border">
        <tr>
            <th>Nombre</th>
            <th>CUIT</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Fecha de nacimiento</th>
            <th>Acciones</th>
            

        </tr>
        <?php foreach ($aClientes as $cliente) { ?>
            <tr>
                <td><?php echo $cliente->cuit; ?></td>
                <td><?php echo $cliente->nombre; ?></td>
                <td><?php echo date_format(date_create($cliente->fecha_nac), "d/m/Y"); ?></td>
                <td><?php echo $cliente->telefono; ?></td>
                <td><?php echo $cliente->correo; ?></td>

                <td>
                    <a href="cliente-formulario.php?id=<?php echo $cliente->idcliente; ?>"><i class="fas fa-search"></i></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php include_once("footer.php"); ?>