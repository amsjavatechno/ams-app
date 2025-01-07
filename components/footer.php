<?php
require 'vendor/autoload.php';
use AmsApp\GlobalConstants;
?>
<footer class="text-center mt-5 mb-3 bg-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>&copy; <?php echo date("Y").'-'.(date("Y")+1).' '.GlobalConstants::SITE_TITLE  ?>. All rights reserved.</p>
            </div>
            <div class="col-md-6">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="mailto:contact@ams-portal.com" class="text-primary">Contact Us</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://facebook.com/yourprofile" class="text-primary" target="_blank">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://twitter.com/yourprofile" class="text-primary" target="_blank">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://instagram.com/yourprofile" class="text-primary" target="_blank">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>