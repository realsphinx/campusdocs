<style>
  .logo {
    margin: auto;
    font-size: 24px;
    background: #ffffff;
    padding: 10px;
    border-radius: 50%;
    color: #000000b3;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s, transform 0.3s;
  }

  .logo:hover {
    background-color: #f0f0f0;
    transform: scale(1.1);
  }

  .navbar {
    padding: 50;
  }

  .navbar .container-fluid {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .navbar .logo-container,
  .navbar .logout-container {
    display: flex;
    align-items: center;
  }

  .navbar .logout-container a {
    color: white;
    text-decoration: none;
    transition: color 0.3s;
    font-size: 24px;
    margin-left: 10px;
  }

  .navbar .logout-container a:hover {
    color: #ff0000;
  }

  .user-info {
    margin-right: 10px;
    color: white;
  }
</style>

<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <div class="logo-container">
      <div class="logo">
	  <i class="fa fa-share-alt"></i>
      </div>
    </div>
    <div class="logout-container">
      <span class="user-info"><?php echo $_SESSION['login_name'] ?></span>
      <a href="#" id="logout-link"><i class="fa fa-power-off"></i></a>
    </div>
  </div>
</nav>

<!-- Modal de Confirmación de Cierre de Sesión -->
<div class="modal fade" id="logout_modal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Confirmación de Cierre de Sesión</h5>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas cerrar sesión?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a href="ajax.php?action=logout" class="btn btn-primary">Aceptar</a>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    $('#logout-link').on('click', function(e) {
      e.preventDefault();
      $('#logout_modal').modal('show');
    });
  });
</script>
