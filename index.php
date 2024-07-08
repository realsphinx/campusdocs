<!-- index.php -->
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Administrador | Reserva de Asientos de Cine</title>

  <?php
  session_start();
  if (!isset($_SESSION['login_id']))
    header('location:login.php');
  include('./header.php');
  // include('./auth.php'); 
  ?>

  <?php
  include('./header.php');
  ?>

  <!-- CSS Adicional -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      background: #f0f0f0;
      font-family: Arial, sans-serif;
    }

    .toast {
      position: fixed;
      top: 20px;
      right: 20px;
      min-width: 300px;
      z-index: 1060;
    }

    .back-to-top {
      position: fixed;
      bottom: 20px;
      right: 20px;
      display: none;
      background-color: #007bff;
      color: white;
      padding: 10px 15px;
      border-radius: 5px;
    }

    .back-to-top:hover {
      background-color: #0056b3;
    }

    #preloader {
      position: fixed;
      left: 0;
      top: 0;
      z-index: 9999;
      width: 100%;
      height: 100%;
      overflow: visible;
      background: rgba(255, 255, 255, 0.7) url('assets/img/preloader.gif') no-repeat center center;
    }
  </style>
</head>

<body>
  <div id="preloader"></div>
  <?php include 'topbar.php'; ?>
  <?php include 'navbar.php'; ?>

  <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white"></div>
  </div>

  <main id="view-panel">
    <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
    <?php include $page . '.php'; ?>
  </main>

  <a href="#" class="back-to-top"><i class="fas fa-chevron-up"></i></a>

  <!-- Modal de Confirmación -->
  <div class="modal fade" id="confirm_modal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmación</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="confirm">Continuar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Universal -->
  <div class="modal fade" id="uni_modal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body"></div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#preloader').fadeOut('fast', function() {
        $(this).remove();
      });

      $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
          $('.back-to-top').fadeIn();
        } else {
          $('.back-to-top').fadeOut();
        }
      });

      $('.back-to-top').click(function() {
        $('html, body').animate({
          scrollTop: 0
        }, 600);
        return false;
      });
    });

    window.start_load = function() {
      $('body').prepend('<div id="preloader2"></div>');
    }

    window.end_load = function() {
      $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
      });
    }

    window.uni_modal = function(title = '', url = '') {
      start_load();
      $.ajax({
        url: url,
        error: function() {
          alert("Ocurrió un error");
        },
        success: function(resp) {
          if (resp) {
            $('#uni_modal .modal-title').html(title);
            $('#uni_modal .modal-body').html(resp);
            $('#uni_modal').modal('show');
            end_load();
          }
        }
      });
    }

    window._conf = function(msg = '', func = '', params = []) {
      $('#confirm_modal #confirm').attr('onclick', func + "(" + params.join(',') + ")");
      $('#confirm_modal .modal-body').html(msg);
      $('#confirm_modal').modal('show');
    }

    window.alert_toast = function(msg = 'PRUEBA', bg = 'success') {
      $('#alert_toast').removeClass('bg-success bg-danger bg-info bg-warning');

      if (bg === 'success') $('#alert_toast').addClass('bg-success');
      if (bg === 'danger') $('#alert_toast').addClass('bg-danger');
      if (bg === 'info') $('#alert_toast').addClass('bg-info');
      if (bg === 'warning') $('#alert_toast').addClass('bg-warning');

      $('#alert_toast .toast-body').html(msg);
      $('#alert_toast').toast({
        delay: 3000
      }).toast('show');
    }
  </script>
</body>

</html>