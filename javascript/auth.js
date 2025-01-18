const signupForm = $('#signupForm');
const otpForm = $('#otpForm');
const otpInputs = $('.otp-input');


$(document).ready(function () {
    verifyAndSubmitSignUpForm();
})

function showValidationMessageInModal(msgContent,title) {
    // Get the modal element (ensure the modal HTML is already part of your page)
    const modal = document.getElementById('errorModal');
    const modalBody = modal.querySelector('.modal-body');
    const modalTitle = modal.querySelector('.modal-title');

    // Set the content for the modal
    modalTitle.textContent = "Validation Error";  // Set the modal title
    if(title!==null){
        modalTitle.textContent = title;
    }
    modalBody.textContent = msgContent;  // Set the error message
    hideLogoAnimation()






    // Show the modal using Bootstrap's modal method
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
}

function removeTooltipIfAlreadyExist(inputField) {
    if(inputField && inputField.classList && inputField.classList.contains('is-invalid')){
        inputField.classList.remove('is-invalid');
    }
}






function verifyAndSubmitSignUpForm(){
    // Handle signup form submission
    signupForm.on('submit', function (event) {
        showLogoAnimation();
        event.preventDefault();
        // Collect form data
        const $name = $('#name');
        const $email = $('#email');
        const $password = $('#password');
        const $SignUpBasedToken = $('#SignUpBasedToken');
        const $terms = $('#terms');
        const formData = {
            name: $name.val(),
            email: $email.val(),
            password: $password.val(),
            token: $SignUpBasedToken.val(),
            terms: $terms.is(':checked') ? 'on' : 'off'
        };

        if (!isValidUsername(formData.name)) {
            showValidationMessageInModal('Username should be contains at least 3 Character.',$name);
            return;
        }

        // Validate email
        if (!isValidEmail(formData.email)) {
            showValidationMessageInModal('Please enter a valid email address.',$email);
            return;
        }

        // Validate password
        if (!isValidPassword(formData.password)) {
            showValidationMessageInModal('Password must be at least 8 characters long, and include a letter, a number, and a special character.', $password);
            return;
        }
        removeTooltipIfAlreadyExist($name);
        removeTooltipIfAlreadyExist($password);
        removeTooltipIfAlreadyExist($email);
        submitSignUpForm(formData);
        submitOtpForm();
    });

}

$(document).ajaxStart(function() {
    showLogoAnimation();
});

// Hide the overlay and loader when the AJAX request completes
$(document).ajaxStop(function() {
    hideLogoAnimation();
});

function showLogoAnimation() {
    $('#logo-container').fadeIn(1000).css('opacity', 1).css('pointer-events', 'auto'); // Show logo with fade-in effect
}

// Function to hide the logo container
function hideLogoAnimation() {
    $('#logo-container').fadeOut(1000).css('opacity', 0).css('pointer-events', 'none'); // Hide logo with fade-out effect
}





function submitSignUpForm(formData) {
    // Send signup data using jQuery AJAX with JSON payload
    $.ajax({
        url: '../api/auth/register.php',
        type: 'POST',
        contentType: 'application/json', // Set Content-Type to application/json
        data: JSON.stringify(formData), // Convert data to JSON
        dataType: 'json',
        success: function (response) {
            hideLogoAnimation();
            console.log('Server Response:', response); // Debug server response
            if (response.status === 'success') {
                // Hide signup form and show OTP form
                signupForm.hide();
                // Show the modal
                hideLogoAnimation();
                otpForm.show();
                // var otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
                // otpModal.show();
            } else {
                // Display error message
                setInterval(showValidationMessageInModal(response.message,"Notification"),500);
            }
        },
        error: function (xhr, status, error) {
            hideLogoAnimation();
            // Display error message
            showValidationMessageInModal('There was an error with the sign-up process.',"Notification");
        },
    });
}


// otp form

function submitOtpForm() {

    otpForm.on('submit', function (event) {
        event.preventDefault();

        // Collect OTP values
        const otp = otpInputs
            .map(function () {
                return $(this).val();
            })
            .get()
            .join('');

        const formData = {
            otp: otp,
            token: $('#OtpBasedToken').val()
        };

        console.log(formData)

        // Send OTP for verification (dummy example)
        $.ajax({
            url: '../api/auth/verifyOtp.php',
            type: 'POST',
            contentType: 'application/json', // Set Content-Type to application/json
            data: JSON.stringify(formData), // Convert data to JSON
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'OTP verified successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Redirect to login page
                        window.location.href = 'login.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: 'OTP verification failed. Please try again.'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'There was an error verifying the OTP.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Redirect to login page
                    window.location.href = 'index.php';
                });
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


}




