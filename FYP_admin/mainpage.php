<?php
SESSION_START();
require_once("include/output_functions.php");
require_once("include/validation.php");
check_logout();

html_header("Home");

$access = $_SESSION['access_page'];
$access = explode(",", trim($access));

$pages = array(
    array("training", "TRAINING", "fa-sitemap"),
    array("testing", "TESTING", "fa-lightbulb-o"),
    array("dataana", "DATASET ANALYSIS", "fa-area-chart"),
    array("admin", "ADMIN", "fa-users"),
    array("setting", "SETTINGS", "fa-cogs"),
);
?>
<body>
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-main">
    <div class="navbar-brand"><a href="mainpage.php" class="border-right pr-3">AdminPortal</a></div>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle btn btn-outline-white pl-4 pr-4" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> -->
            <?php //echo $_SESSION['valid_admin']; ?>
            <!-- </a>
            <div class="dropdown-menu dropdown-menu-right text-main" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Training History</a>
                <a class="dropdown-item" href="#">Testing History</a>
                <a class="dropdown-item" href="#">User Training Record</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </li>
    </ul>
    </nav> -->
    <?php   nav_bar("");    ?>

    <div class="container mt-5">
        <div class="d-flex flex-wrap justify-content-center text-main">
            <?php
            for ($i=0; $i < count($access); $i++) { 
                echo '<a href="'.$pages[$access[$i]][0].'.php" class="m-2 pt-5 pb-5 btn btn-light function-box">
                        <div class="center text-main">
                            <i class="fa '.$pages[$access[$i]][2].' fa-3x mb-2" aria-hidden="true"></i>
                            <h5>'.$pages[$access[$i]][1].'</h5>
                        </div>
                    </a>';
            }
            ?>
        </div>
    </div>
    <!-- <div class="container mt-5">
        <div class="d-flex flex-wrap justify-content-center text-main">
            <a href="training.php" class="m-2 pt-5 pb-5 btn btn-light function-box">
                <div class="center text-main">
                    <i class="fa fa-sitemap fa-3x mb-2" aria-hidden="true"></i>
                    <h5>TRAINING</h5>
                </div>
            </a>
            <a href="testing.php" class="m-2 pt-5 pb-5 btn btn-light function-box">
                <div class="center text-main">
                    <i class="fa fa-lightbulb-o fa-3x mb-2" aria-hidden="true"></i>
                    <h5>TESTING</h5>
                </div>
            </a>
            <a href="dataana.php" class="m-2 pt-5 btn btn-light function-box">
                <div class="center text-main">
                    <i class="fa fa-area-chart fa-3x mb-2" aria-hidden="true"></i>
                    <h5>DATASET ANALYSIS</h5>
                </div>
            </a>
            <a href="admin.php" class="m-2 pt-5 pb-5 btn btn-light function-box">
                <div class="center text-main">
                    <i class="fa fa-users fa-3x mb-2" aria-hidden="true"></i>
                    <h5>ADMIN</h5>
                </div>
            </a>
            <a href="setting.php" class="m-2 pt-5 pb-5 btn btn-light function-box">
                <div class="center text-main">
                    <i class="fa fa-cogs fa-3x mb-2" aria-hidden="true"></i>
                    <h5>SETTINGS</h5>
                </div>
            </a>
        </div>
    </div> -->
</body>
</html>