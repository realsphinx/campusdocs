<!-- manage_user.php -->
<?php 
include('db_connect.php');
if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
?>
<div class="container-fluid">
    <form action="" id="manage-user">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="" <?php echo isset($meta['id']) ? '' : 'required' ?>>
        </div>
        <div class="form-group">
            <label for="type">User Type</label>
            <select name="type" id="type" class="custom-select">
                <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
                <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>User</option>
            </select>
        </div>
        <div class="form-group">
            <label for="area">Área</label>
            <input type="text" name="area" id="area" class="form-control" value="<?php echo isset($meta['area']) ? $meta['area']: '' ?>" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('#manage-user').submit(function(e){
            e.preventDefault();
            start_load();
            $.ajax({
                url:'ajax.php?action=save_user',
                method:'POST',
                data:$(this).serialize(),
                success:function(resp){
                    if(resp == 1){
                        alert_toast("Datos guardados exitosamente",'success');
                        setTimeout(function(){
                            location.reload();
                        },1500)
                    } else if(resp == 2){
                        alert_toast("El nombre de usuario ya existe.",'danger');
                        end_load();
                    }
                }
            })
        })
    })
</script>
