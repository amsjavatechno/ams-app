<?php
require __DIR__ . '/../../vendor/autoload.php';
use AmsApp\Security\CSRFUtil;
use AmsApp\Security\InputSanitizer;
use AmsApp\Service\UserService\UserRegistrationService;
use AmsApp\Dao\UserDao;
use AmsApp\Dao\OtpVerificationDao;
use AmsApp\Communication\EmailUtil;
use AmsApp\Utils\Http\HttpBaseUtil;
use AmsApp\Utils\Http\ResponseBody;

try {

    // Check if the request method is POST
    if (!HttpBaseUtil::verifyMethod(HttpBaseUtil::POST_METHOD)) {
        throw new Exception("Invalid request method. Only POST requests are allowed.");
    }

    // Input validation: Retrieve POST data
    $data = HttpBaseUtil::parseJsonInput();

    $csrfToken = $data['token']; // CSRF Token from the client
    $email = InputSanitizer::sanitize($data['email'], InputSanitizer::EMAIL_SANITIZER);
    $name = InputSanitizer::sanitize($data['name'],InputSanitizer::STRING_SANITIZER);
    $password = InputSanitizer::sanitize($data['password'],InputSanitizer::STRING_SANITIZER);

    // CSRF Token Validation
    if (!CSRFUtil::validateToken($csrfToken)) {
        throw new Exception("Invalid CSRF Token.");
    }

    // Service instantiation
    $userDao = new UserDao();
    $otpDao = new OtpVerificationDao();
    $emailUtil = new EmailUtil();
    $registrationService = new UserRegistrationService($userDao, $otpDao, $emailUtil);

    // Register the user and send OTP
    $response = $registrationService->registerUserAndSendOtp($email, $name, $password);

    // Return the response using ResponseBody
    ResponseBody::sendDataResponse(200, ResponseBody::SUCCESS, $response);

} catch (Exception $e) {
    // Handle error responses using ResponseBody
    ResponseBody::sendDataResponse(200, ResponseBody::ERROR, $e->getMessage());
}

