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

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
            margin: 0;
        }

        .container {
            display: flex;
            max-width: 900px;
            width: 100%;
            height: 600px; /* Set a fixed height for the container */
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            position: relative;
        }

        .form-section {
            flex: 1;
            padding: 40px;
            z-index: 2;
        }

        .design-section {
            flex: 1;
            background: linear-gradient(135deg, #0056b3, #4a90e2, #76c7f2);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: left;
            overflow: hidden;
            z-index: 1; /* Ensure this element is above others */
        }

        .design-section div {
            position: relative; /* Ensure content is positioned relative to parent */
            z-index: 2; /* Ensure text is on top of the gradient and background circle */
            padding: 20px; /* Add some padding to the text */
        }

        .design-section::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: #0056b3;
            border-radius: 50%;
            top: -50%;
            left: -50%;
            z-index: 0; /* Background circle remains behind */
        }

        .design-section h2 {
            color: azure;
            font-style: italic;
            font-palette: light;
            font-size: large; /* Bigger text for quotes */
            text-align: left; /* Align text to the start */
            z-index: 2;
            margin-bottom: 10px;
        }

        .design-section p {
            color: azure;
            font-size: larger; /* Bigger text for quotes */
            text-align: left; /* Align text to the start */
            margin-top: 10px;
            z-index: 2;
            quotes: "“" "”";
        }

        .design-section p::before {
            content: open-quote;
        }

        .design-section p::after {
            content: close-quote;
        }

        .logo {
            display: flex;
            align-items: normal;
            justify-content: left;
            margin-bottom: 20px;
        }

        .logo img {
            width: 150px;
            height: auto;
        }

        @media (max-width: 768px) {
            .design-section {
                display: none;
            }
            .form-section .social-buttons {
                display: none;
            }
        }

        .form-section h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            display: flex;
            align-items: normal;
            justify-content: left;
        }

        .form-section form {
            display: flex;
            flex-direction: column;
        }

        .form-section input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-section label {
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        .form-section .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-section .checkbox-container input {
            margin-right: 10px;
        }

        .form-section .checkbox-container a {
            color: #007BFF;
            text-decoration: none;
        }

        .form-section button {
            padding: 10px;
            background-color: #0056b3;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-section button:hover {
            background-color: #004494;
        }

        .form-section .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .form-section .divider::before,
        .form-section .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #ccc;
        }

        .form-section .divider::before {
            left: 0;
        }

        .form-section .divider::after {
            right: 0;
        }

        .form-section .divider span {
            background: #fff;
            padding: 0 10px;
            font-size: 14px;
            color: #888;
        }

        .form-section .signIn-link {
            text-align: center;
            margin-top: 20px;
        }

        .form-section .signIn-link a {
            color: #007BFF;
            text-decoration: none;
        }

        /*    Otp Form CSS*/

        .otp-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .otp-input:last-child {
            margin-right: 0;
        }

        #otpForm button {
            margin-top: 10px;
            margin-right: 10px;
        }
        /*    Message Container Css */
        #messageContainer {
            display: none; /* Hidden by default */
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.5;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        #messageContainer.success {
            background-color: #d4edda; /* Light green background */
            color: #155724; /* Dark green text */
            border: 1px solid #c3e6cb; /* Green border */
        }

        #messageContainer.error {
            background-color: #f8d7da; /* Light red background */
            color: #721c24; /* Dark red text */
            border: 1px solid #f5c6cb; /* Red border */
        }

        #messageContainer.info {
            background-color: #d1ecf1; /* Light blue background */
            color: #0c5460; /* Dark blue text */
            border: 1px solid #bee5eb; /* Blue border */
        }

        #messageContainer.warning {
            background-color: #fff3cd; /* Light yellow background */
            color: #856404; /* Dark yellow text */
            border: 1px solid #ffeeba; /* Yellow border */
        }

        #messageContainer i {
            margin-right: 10px;
            font-size: 18px;
            vertical-align: middle;
        }

        .ui-dialog-titleBar {
            background-color: #0056b3;
            color: white;
        }
        .ui-dialog-titleBar-close {
            color: white;
        }

        .error-message {
            color: red;
            font-size: 0.8rem;
            margin-top: 0.0rem;
        }
        .invalid {
            border-color: red;
        }


    </style>
</head>
<body>
<div class="container">
    <div class="form-section">
        <div class="logo">
            <img src="../images/ams-logo.png" alt="AmSPortal Logo">
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

            <button type="submit" disabled>Signup</button>

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


<script>

    const messageDialog = $("#messageDialog");
    const messageContent = $("#messageContent");
    const signupForm = $('#signupForm');
    const otpForm = $('#otpForm');
    const messageContainer = $('#messageContainer');
    const otpInputs = $('.otp-input');


    // Function to display error message
    function showError(input, message) {
        const errorElement = document.getElementById(input.id + "Error");
        errorElement.textContent = message;
        input.classList.add("invalid");
    }

    // Function to clear error message
    function clearError(input) {
        const errorElement = document.getElementById(input.id + "Error");
        errorElement.textContent = "";
        input.classList.remove("invalid");
    }

    // Function to check if form is valid
    function checkFormValidity() {
        const submitBtn = document.getElementById("submitBtn");
        const inputs = document.querySelectorAll("#signupForm input");
        let isValid = true;
        inputs.forEach((input) => {
            if (input.type !== "checkbox" && !input.checkValidity()) {
                isValid = false;
            }
            if (input.type === "checkbox" && !input.checked) {
                isValid = false;
            }
        });
        submitBtn.disabled = !isValid; // Enable submit button if form is valid
    }

    // Validation logic for each field
    document.getElementById("name").addEventListener("focusout", (e) => {
        const input = e.target;
        if (!input.value.trim()) {
            showError(input, "Please enter your name.");
        } else {
            clearError(input);
        }
        checkFormValidity();
    });

    document.getElementById("email").addEventListener("focusout", (e) => {
        const input = e.target;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(input.value.trim())) {
            showError(input, "Please enter a valid email address.");
        } else {
            clearError(input);
        }
        checkFormValidity();
    });

    document.getElementById("password").addEventListener("focusout", (e) => {
        const input = e.target;

        const passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
        if (!passwordRegex.test(input.value.trim())) {
            showError(
                input,
                "Password must be at least 8 characters long and include a letter, a number, and a special character."
            );
        } else {
            clearError(input);
        }
        checkFormValidity();
    });

    document.getElementById("terms").addEventListener("change", (e) => {
        const input = e.target;
        if (!input.checked) {
            showError(input, "You must agree to the terms and policy.");
        } else {
            clearError(input);
        }
        checkFormValidity();
    });

    // Optional: Prevent form submission if there are errors
    document.getElementById("signupForm").addEventListener("submit", (e) => {
        const inputs = document.querySelectorAll("#signupForm input");
        let isValid = true;
        inputs.forEach((input) => {
            if (!input.checkValidity()) {
                isValid = false;
                showError(input, input.validationMessage);
            }
        });
        if (!isValid) {
            e.preventDefault(); // Prevent form submission
        }
    });



    // Validate email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Validate password
    function isValidPassword(password) {
        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return passwordRegex.test(password);
    }

    // Validate username
    function isValidUsername(username) {
        return username.trim().length > 0;
    }


    function submitSignUpForm(formData,messageContainer){
        // Send signup data using jQuery AJAX with JSON payload
        $.ajax({
            url: 'reg.php',
            type: 'POST',
            contentType: 'application/json', // Set Content-Type to application/json
            data: JSON.stringify(formData), // Convert data to JSON
            dataType: 'json',
            success: function (response) {
                console.log('Server Response:', response); // Debug server response
                if (response.status === 'success') {
                    // Display success message
                    messageContainer
                        .removeClass()
                        .addClass('success')
                        .text('Signup successful! Please check your email for the OTP.')
                        .show();

                    // Hide signup form and show OTP form
                    signupForm.hide();
                    otpForm.show();
                } else {
                    // Display error message
                    messageContainer
                        .removeClass()
                        .addClass('error')
                        .text(response.message)
                        .show();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                // Display error message
                messageContainer
                    .removeClass()
                    .addClass('error')
                    .text('There was an error with the sign-up process.')
                    .show();
            },
        });
    }



    // Initialize the jQuery UI dialog
    messageDialog.dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog("close");
            }
        }
    });

    // Utility function to show messages
    function showMessage(message, type = "info") {
        // messageContent.text(message);
        //
        // // Add a class to style the message based on type
        // messageDialog.dialog("option", "title", type === "error" ? "Error" : "Success");
        // messageDialog.dialog("open");


        jQuery.notify("You have successfully verified your OTP!", {
            className: type === "error" ? "Error" : "success",
            globalPosition: 'top right',
            autoHide: true,
            clickToHide: true
        });


    }







    $(document).ready(function () {
        // Handle signup form submission
        signupForm.on('submit', function (event) {
            event.preventDefault();

            // Collect form data
            const formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                token: $('#hiddenItem').val(),
                terms: $('#terms').is(':checked') ? 'on' : 'off'
            };

            // Debug collected data
            console.log('Form Data:', formData);

            if (!isValidUsername(formData.name)) {
                showMessage('Username cannot be empty.', "error");
                return;
            }

            // Validate email
            if (!isValidEmail(formData.email)) {
                showMessage('Please enter a valid email address.', "error");
                return;
            }

            // Validate password
            // if (!isValidPassword(formData.password)) {
            //     showMessage('Password must be at least 8 characters long, and include a letter, a number, and a special character.', "error");
            //     return;
            // }

            // Send signup data using jQuery AJAX with JSON payload
            // submitSignUpForm(formData, messageContainer);
            signupForm.hide();
            otpForm.show();
        });

        // Handle OTP form submission
        otpForm.on('submit', function (event) {
            event.preventDefault();

            // Collect OTP values
            const otp = otpInputs
                .map(function () {
                    return $(this).val();
                })
                .get()
                .join('');

            console.log('Entered OTP:', otp);

            // Send OTP for verification (dummy example)
            $.ajax({
                url: 'verify-otp.php',
                type: 'POST',
                data: { otp },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert('OTP verified successfully!');
                    } else {
                        alert('OTP verification failed. Please try again.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('There was an error verifying the OTP.');
                }
            });
        });

        // Handle Back button
        $('#backButton').on('click', function () {
            otpForm.hide();
            signupForm.css('display', 'flex'); // Ensure the form uses flexbox for proper layout
        });

        // Handle Reset button
        $('#resetButton').on('click', function () {
            otpInputs.val('').first().focus();
        });

        // OTP input navigation
        otpInputs.on('input', function () {
            const $this = $(this);
            if ($this.val().length === 1) {
                $this.next('.otp-input').focus();
            }
        });

        otpInputs.on('keydown', function (event) {
            const $this = $(this);
            if (event.key === 'Backspace' && $this.val().length === 0) {
                $this.prev('.otp-input').focus();
            }
        });
    });

</script>
</body>
</html>