<?php
  //este esta bien
include_once "config.php";
include_once "entidades/usuario.php";
$pg= "Usuarios";

$entidadUsuario = new Usuario();
$aUsuarios = $entidadUsuario->obtenerTodos();
include_once("header.php");
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Listado de usuarios</h1>
    <div class="row">
        <div class="col-12 mb-3">
            <a href="usuario-formulario.php" class="btn btn-primary mr-2">Nuevo</a>

        </div>
    </div>
    <table class="table table-hover border">
        <th  style="width: 170px;">Usuario</th>
        <th style="width: 130px;">Nombre</th>
        <th style="width: 150px;">Correo</th>
        <th style="width: 110px;">Acciones</th>
        <?php foreach ($aUsuarios as $usuario){ ?>
            
            <tr>
                <td><?php echo $usuario->usuario; ?></td>
                <td><?php echo $usuario->nombre; ?></td>
                <td><?php echo $usuario->correo; ?></td>
                <td style="width: 110px;">
            <a href="usuario-formulario.php?id=<?php echo $usuario->idusuario; ?>"><i class="fas fa-search"></i></a>
        </td>
            </tr>
            <?php }?>
    </table>
</div>

<?php include_once("footer.php"); ?>
 
