<!-- users.php -->
<?php 
include('db_connect.php'); // Asegúrate de incluir la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary float-right btn-sm" id="nuevo_usuario"><i class="fa fa-plus"></i> Nuevo Usuario</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card col-lg-12">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Nombre de Usuario</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = $conn->query("SELECT * FROM users ORDER BY name ASC");
                        $i = 1;
                        while($row = $users->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['username'] ?></td>
                            <td><?php echo $row['area'] ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary editar_usuario" data-id="<?php echo $row['id'] ?>">Editar</button>
                                <button class="btn btn-sm btn-danger borrar_usuario" data-id="<?php echo $row['id'] ?>">Eliminar</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $('#nuevo_usuario').click(function(){
        uni_modal('Nuevo Usuario', 'manage_user.php');
    });

    $('.editar_usuario').click(function(){
        uni_modal('Editar Usuario', 'manage_user.php?id=' + $(this).data('id'));
    });

    $('.borrar_usuario').click(function(){
        var id = $(this).data('id');
        if(confirm('¿Estás seguro de que deseas borrar este usuario?')){
            $.ajax({
                url: 'ajax.php?action=delete_user',
                method: 'POST',
                data: { id: id },
                success: function(resp){
                    if(resp == 1){
                        alert_toast("Usuario borrado exitosamente", 'success');
                        location.reload();
                    } else {
                        alert_toast("Error al borrar el usuario", 'danger');
                    }
                }
            });
        }
    });
</script>
</body>
</html>
