<?php
    session_start();
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
    $_SESSION['error'] = null;
?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="asset/img/icon.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="asset/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/glyphicons.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/nbl.css"/>

    <script src="asset/js/jquery-3.3.1.min.js"></script>
    <script src="asset/js/popper.js"></script>
    <script src="asset/bootstrap/js/bootstrap.min.js"></script>

    <title>NBL Oxiplan</title>
</head>
<body class="h-100 paleta4">
    <div class="container h-100 d-flex align-items-center">

        <div class="card mx-auto d-block">
            <div class="card-body">
                <form class="form-signin" action="controller/iniciarSesion.php" method="POST">
                    <img src="asset/img/logo_nbl.png" class="mb-3" alt="LOGO">
                        <div class="div px-4 mt-3">
                            <input type="text" id="user" name="user" class="form-control mb-3" placeholder="Usuario" required>
                            <input type="password" id="inputPassword" name="password" class="form-control mb-3" placeholder="Password" required>
                            <button class="btn btn-block btn-signin paleta1" type="submit">INGRESAR</button>
                            <?php echo $error; ?>
                        </div>
                </form>    
            </div>
        </div>

    </div>
</body>
</html>