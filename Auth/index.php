<?php
session_start();
const SIGN_UP_BASED_TOKEN_ID = "SignUpBasedToken";
const OTP_BASED_TOKEN_ID = "OtpBasedToken";
const AUTH_ERROR_MSG_ID = "AUTH_ERROR_MSG_ID";
require __DIR__ . '/../vendor/autoload.php';

use AmsApp\Components\Dynamic\AmsModals;
use AmsApp\Components\Dynamic\Forms;
use AmsApp\Components\Dynamic\ToastMsg;
use AmsApp\Components\Dynamic\Header;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <?php echo Header::loadCssResources("../styles/auth.css", "../styles/animation.css"); ?>
</head>
<body>
<div class="auth-container">
    <div class="logo-container" id="logo-container">
        <!-- Main Text -->
        <div class="logo-text">
            <small>AmS</small><small>Portal</small>
            <div class="powered-by"><small style="color: #201f1f">Powered by</small>
                <small style="color: #020e29">JavaTechno</small>
            </div>
            <!-- Overlay Effect -->
            <div class="logo-text-overlay"></div>
        </div>
    </div>


    <?php
    //    echo Forms::getOtpForm1(OTP_BASED_TOKEN_ID);
    echo AmsModals::getModel("errorModal");
    ?>
    <div class="form-section">
        <div class="logo">
            <img src="../images/ams-logo.png" alt="AmSPortal Logo" width="150px" height="82px">
        </div>
        <?php
        echo ToastMsg::getToastMsg(AUTH_ERROR_MSG_ID);
        echo Forms::getSignUpForm(SIGN_UP_BASED_TOKEN_ID);
        echo Forms::getOtpForm(OTP_BASED_TOKEN_ID);
        ?>
    </div>
    <div class="design-section">
        <div>
            <h2> *** Expense Participation Simplified ***</h2>
            <p>“Manage and share expenses seamlessly with your friends or partners.”</p>
        </div>
    </div>
</div>


<script src="../javascript/validation.js"></script>
<script>
    const toastMessageId = $('#<?php echo AUTH_ERROR_MSG_ID; ?>');

</script>
<script src="../javascript/auth.js"></script>
</body>
</html>