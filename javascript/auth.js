const messageDialog = $("#messageDialog");
const messageContent = $("#messageContent");
const signupForm = $('#signupForm');
const otpForm = $('#otpForm');
const messageContainer = $('#messageContainer');
const otpInputs = $('.otp-input');

document.addEventListener("DOMContentLoaded", () => {
    const toastEl = document.getElementById('toastMessage');
    const toast = new bootstrap.Toast(toastEl);

    // Trigger the toast
    toast.show();

    // Optional: Add a custom trigger
    document.getElementById('showToastBtn').addEventListener('click', () => {
        toast.show();
    });
});



    document.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));

    modal.show();

//     // Show the modal
//     document.getElementById('openModalBtn').addEventListener('click', () => {
//     modal.show();
// });
//
//     // Hide the modal
//     document.getElementById('closeModalBtn').addEventListener('click', () => {
//     modal.hide();
// });
});


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


document.getElementById("password").addEventListener("focusout", (e) => {
    const input = e.target;
    const passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
    if (!passwordRegex.test(input.value.trim())) {
        showError(
            input,
            "Password must be at least 8 characters long and include a letter, a number, and a special character."
        );
    } else {
        const submitBtn = document.getElementById("submitBtn");
        clearError(input);
        submitBtn.disabled = false;

    }
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


function submitSignUpForm(formData, messageContainer) {
    // Send signup data using jQuery AJAX with JSON payload
    $.ajax({
        url: '../api/auth/register.php',
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
        submitSignUpForm(formData, messageContainer);
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
            data: {otp},
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
