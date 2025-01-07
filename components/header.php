<?php
require 'vendor/autoload.php';
use AmsApp\GlobalConstants;
$logo =  SITE_PATH.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'ams-portal.png';
//$logo_url = SITE_PATH.DIRECTORY_SEPARATOR.
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img src="images/ams-logo.png" alt="ams-portal" width="150" height="75" class="d-inline-block align-text-top">
            </a>
        </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../Auth/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Auth/signup.php">Sign Up</a>
                    </li>
                </ul>
            </div>
    </nav>
</header>