<?php

// header

function html_header($title) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AdminPortal| '.$title.'</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- <script src="js/jquery-2.2.4.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script src="js/imoViewer.js"></script>
    </head>
    ';
}

function verify_form() {
    echo '
    // Disable form submissions if there are invalid fields
    (function() {
    \'use strict\';
    window.addEventListener(\'load\', function() {
        // Get the forms we want to add validation styles to
        var forms = document.getElementsByClassName(\'needs-validation\');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener(\'submit\', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            } else {
                $(\'.btn-submit\').prop("disabled", true)
                                .html("<span class=\"fa fa-spinner fa-spin\"></span>&nbsp;&nbsp; Loading...");
            }
            form.classList.add(\'was-validated\');
        }, false);
        });
    }, false);
    })();
    ';
}

function nav_bar($page) {
?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-main">
    <div class="navbar-brand"><a href="mainpage.php" class="<?php echo (strlen($page) > 0) ? "border-right " : ""; ?>pr-3 mr-3 text-white text-decoration-none">AdminPortal</a><span class="navbar-sub"><?php echo (strlen($page) > 0) ? $page : ""; ?></span></div>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle btn btn-outline-white pl-4 pr-4" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['valid_admin']; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right position-absolute text-main" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="train_history.php">Training History</a>
                <a class="dropdown-item" href="test_history.php">Testing History</a>
                <a class="dropdown-item" href="usertrain_record.php">User Training Record</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </li>
    </ul>
    </nav>
    <?php 
}

?>