<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela Inicial</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet">
  <link href="../principal/css/styles.scss" rel="stylesheet">
  <link href="../principal/assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../principal/css/style.css" rel="stylesheet">
  <link href="../principal/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/formvalidation@0.6.2-dev/dist/css/formValidation.min.css" rel="stylesheet">
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

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="../principal/js/index.js"></script>
  <script src="../principal/js/jquery.min.js"></script>
  <script src="../principal/js/bootstrap.bundle.min.js"></script>
  <script src="../principal/js/jquery.easing.min.js"></script>
  <script src="../principal/js/principal.js"></script>
  <script src="../principal/js/jquery.dataTables.min.js"></script>
  <script src="../principal/js/dataTables.bootstrap4.min.js"></script>
  <script src="./js/index.js"></script>
  <script>
    feather.replace();

  </script>

</body>

</html>