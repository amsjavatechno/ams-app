<?php
require __DIR__ . '/../../vendor/autoload.php';

use AmsApp\Constants\AppConstants;
use AmsApp\Security\CSRFUtil;
use AmsApp\Security\InputSanitizer;
use AmsApp\Service\UserService\UserRegistrationService;
use AmsApp\Utils\Http\HttpBaseUtil;
use AmsApp\Utils\Http\ResponseBody;
use AmsApp\Utils\SessionFactory;

try {

    HttpBaseUtil::validatePostRequest();

    // Input validation: Retrieve POST data
    $data = HttpBaseUtil::parseJsonInput();

    $csrfToken = $data['token']; // CSRF Token from the client
    $email = InputSanitizer::sanitize($data['email'], InputSanitizer::EMAIL_SANITIZER);
    $name = InputSanitizer::sanitize($data['name'], InputSanitizer::STRING_SANITIZER);
    $password = InputSanitizer::sanitize($data['password'], InputSanitizer::STRING_SANITIZER);

    // CSRF Token Validation
    if (!CSRFUtil::validateToken($csrfToken)) {
        throw new Exception("Invalid CSRF Token.");
    }

    $registrationService = new UserRegistrationService();

    // Register the user and send OTP
    $response = $registrationService->setUserInCookieAndSendOtp($email, $name, $password);

    SessionFactory::set(AppConstants::SESSION_EMAIL, $email);

    // Return the response using ResponseBody
    ResponseBody::sendDataResponse(200, ResponseBody::SUCCESS, null, $response);

} catch (Exception $e) {
    // Handle error responses using ResponseBody
    ResponseBody::sendDataResponse(200, ResponseBody::ERROR, $e->getMessage(), null);
}

