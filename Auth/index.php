<?php
session_start();
require __DIR__.'/../vendor/autoload.php';
use AmsApp\Security\CSRFUtil;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/auth.css" >
</head>
<body>
<div class="container">
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastMessage" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <small class="text-muted">Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, this is your toast message!
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Otp Verification</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This is the modal content.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <div class="form-section">
        <div class="logo">
            <img src="../images/JavatechnoAMSLOGO.png" alt="AmSPortal Logo">
        </div>
        <div id="messageDialog" title="Notification" style="display: none;">
            <p id="messageContent"></p>
        </div>

        <div id="messageContainer" class="success">
        </div>
        <h1>Get Started Now</h1>
        <form id="signupForm">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required autocomplete="off">

            <label for="email">Email address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required autocomplete="off">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <small class="error-message" id="passwordError"></small>

            <?= CSRFUtil::getHiddenInput(); ?>

            <div class="checkbox-container">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the <a href="#">terms & policy</a></label>
            </div>

            <button type="submit" id="submitBtn" disabled>Signup</button>

            <div class="divider">
                <span>Or</span>
            </div>

            <div class="signIn-link">
                <p>Have an account? <a href="#">Sign In</a></p>
            </div>
        </form>
        <form id="otpForm" style="display:none;">
            <label for="otp">Enter OTP</label>
            <div class="otp-container">
                <input type="text" class="otp-input" maxlength="1" required>
                <input type="text" class="otp-input" maxlength="1" required>
                <input type="text" class="otp-input" maxlength="1" required>
                <input type="text" class="otp-input" maxlength="1" required>
            </div>
            <button type="submit">Verify OTP</button>
            <button type="button" id="backButton">Back</button>
            <button type="button" id="resetButton">Reset</button>
        </form>
    </div>
    <div class="design-section">
        <div>
            <h2> *** Expense Participation Simplified ***</h2>
            <p>“Manage and share expenses seamlessly with your friends or partners.”</p>
        </div>
    </div>
</div>

<script src="../javascript/auth.js"></script>
</body>
</html>