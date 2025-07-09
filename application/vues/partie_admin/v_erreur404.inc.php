<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>404 Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="<?php echo Chemins::STYLES . 'app.min.css'; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Chemins::STYLES . 'bootstrap.min.css'; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Chemins::STYLES . 'icons.min.css'; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Chemins::STYLES . 'jquery-jvectormap-1.2.2.css'; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Chemins::STYLES . 'preloader.min.css'; ?>" rel="stylesheet" type="text/css" />
    
    <!-- Bootstrap CSS (from CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JAVASCRIPT -->
    <script src="<?php echo Chemins::JS . 'jquery.min.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'bootstrap.bundle.min.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'metisMenu.min.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'simplebar.min.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'waves.min.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'feather.min.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'pace.min.js'; ?>"></script>
    <script src="https://kit.fontawesome.com/a2cccffcf0.js" crossorigin="anonymous"></script>
    <script src="<?php echo Chemins::JS . 'apexcharts.min.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'jquery-jvectormap-1.2.2.min.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'jquery-jvectormap-world-mill-en.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'dashboard.init.js'; ?>"></script>
    <script src="<?php echo Chemins::JS . 'app.js'; ?>"></script>
    
</head>

<body>

    <div class="my-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <h1 class="display-1 fw-semibold">4<span class="text-primary mx-2">0</span>4</h1>
                        <h4 class="text-uppercase">Désolé page indisponible</h4>
                        <div class="mt-5 text-center">
                            <a class="btn btn-primary waves-effect waves-light" href="index.php">Retour au lobby</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10 col-xl-8">
                    <div>
                        <img src="<?php echo Chemins::IMAGES . 'error-img.png'; ?>" class="img-fluid" alt="Logo">
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
