<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tela Listagem</title>
  <link rel="stylesheet" href="../principal/css/styles.scss" />
  <link href="../principal/assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../principal/css/style.css" rel="stylesheet">
  <link href="../principal/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href=" https://cdn.jsdelivr.net/npm/formvalidation@0.6.2-dev/dist/css/formValidation.min.css " rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

      <?php require_once '../listagem/content/content.php'; ?>



    </div>
  </main>


  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="../principal/js/index.js"></script>
  <script>
    feather.replace();
  </script>
  <script src="../principal/js/jquery.min.js"></script>
  <script src="../principal/js/bootstrap.bundle.min.js"></script>

  <script src="../principal/js/jquery.easing.min.js"></script>

  <script src="../principal/js/principal.js"></script>

  <script src="../principal/js/jquery.dataTables.min.js"></script>
  <script src="../principal/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>



  <script src="./js/index.js"></script>

</body>

</html>