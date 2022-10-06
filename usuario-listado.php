<?php

include_once "config.php";
include_once "usuario.php";
$pg= "Usuarios";

$usuario= new Usuario();
$aUsuario = $usuario->obtenerPorUsuario($usuario);

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
        <tr>Nombre</tr>
        <tr>Acciones</tr>
        <?php foreach ($aUsuarios as $usuario){ ?>
            <tr>
                <td><?php echo $usuario->nombre; ?></td>
                <td style="width: 110px;">
            <a href="usuario-formulario.php?id=<?php echo $usuario->idusuario; ?>"><i class="fas fa-search"></i></a>
        </td>
            </tr>
            <?php }?>
    </table>
</div>

<?php include_once("footer.php"); ?>
 
<div class="container-fluid">
    <h1 class="h3">Usuarios</h1>
    <div class="row">
        <div class="col-12">
            <a href="usuario-formulario.php" class="btn">Nuevo</a>
        </div>
    </div>
    <table class="table table-hover border">
        <tr>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($aUsuarios as $usuario){ ?>
            <tr>
                <td><?php echo $usuario->nombre; ?></td>
                <td stlyle="width: 110px;"></td>
                <a href="usuario-formulario.php?id=<?php echo $usuario->idusuario;?>"></a>
            </tr>
<? }?>
    </table>
</div>