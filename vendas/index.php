<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela Inicial</title>
  <!-- Estilos CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="../principal/css/styles.scss" rel="stylesheet">
  <link href="../principal/assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../principal/css/style.css" rel="stylesheet">
  <link href="../principal/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/formvalidation@0.6.2-dev/dist/css/formValidation.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../vendor/select2/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="../vendor/ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
  <style>
    .required::after {
      content: "*";
      color: red;
      margin-left: 2px;
    }
  </style>
</head>

<body>

  <main>
    <?php require_once "../principal/index.php"; ?>
    <div class="content">
      <?php require_once '../vendas/content/content.php'; ?>
    </div>
  </main>

  <!-- Scripts JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/select2/select2/dist/js/select2.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="../principal/js/index.js"></script>
  <script src="../principal/js/jquery.easing.min.js"></script>
  <script src="../principal/js/principal.js"></script>
  <script src="../principal/js/jquery.dataTables.min.js"></script>
  <script src="../principal/js/dataTables.bootstrap4.min.js"></script>
  <script src="./js/index.js"></script>
  <script>
    $(document).ready(function() {
      $('.select2').select2();
    });

    feather.replace();
  </script>

</body>

</html>