<!doctype html>
<html lang="en">
<head>

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Gestión de proyectos">
<meta name="theme-color" content="#2F3BA2" />
<title>Atlas</title>
<link rel="manifest" href="<?php echo base_url('manifest.json') ?>">
<link rel="apple-touch-icon" href="<?php echo base_url('assets/img/icons/128x128.png') ?>">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/node_modules/bootstrap/dist/css/bootstrap.min.css') ?>">
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="offset-sm-4 col-sm-4">
      <div class="card text-white bg-secondary mt-4">
        <div class="card-body">
          <form method="POST" autocomplete="off">
            <div class="form-group">
              <label for="inputUserName">Usuario:</label>
              <input type="text" name="username" class="form-control" id="inputUserName" aria-describedby="inputUserName" required="required">
            </div>
            <div class="form-group">
              <label for="inputPassword">Contraseña:</label>
              <input type="password" name="password" class="form-control" id="inputPassword" required="required">
            </div>
            <button type="submit" class="btn btn-light btn-block mt-4">Aceptar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('sw'); ?>
</body>
</html>