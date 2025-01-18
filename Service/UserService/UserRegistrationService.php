<?php

namespace AmsApp\Service\UserService;

use AmsApp\Constants\BaseConstants;
use AmsApp\Dao\TransactionManagerUtil;
use AmsApp\Dao\UserDao;
use AmsApp\Exceptions\ExceptionBuilder;
use AmsApp\Service\OtpVerificationService;
use AmsApp\Utils\CookiesUtil;
use Exception;

class UserRegistrationService
{
    const NAME = "name";
    const EMAIL = "email";
    const PASSWORD = "password";
    private UserDao $userDao;
    private OtpVerificationService $otpVerificationService;

    public function __construct()
    {
        // Service instantiation
        $this->userDao = new UserDao();
        $this->otpVerificationService = new OtpVerificationService();
    }

    /**
     * Registers a new user and sends OTP.
     * @throws Exception
     */
    public function registerUser($email, $name, $password, $gender_id, $status_id): array
    {
        // Check if the user already exists
        $this->checkIfTheUserAlreadyExists($email);

        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $user_id = $this->userDao->insertUser(null, $name, $email, $passwordHash, $gender_id, $status_id, 0);

        if (!$user_id) {
            throw new Exception("Failed to register user.");
        }
        $this->otpVerificationService->sendOtp($email);

        return ["user_id" => $user_id, "message" => "User registered successfully. OTP sent to email."];
    }


    /**
     * Registers a new user and sends OTP.
     * @throws Exception
     */
    public function registerUserAndSendOtp($email, $name, $password): array
    {
        // Check if the user already exists
        $this->checkIfTheUserAlreadyExists($email);

        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        CookiesUtil::setCookie("name", $name);
        CookiesUtil::setCookie("email", $email);
        CookiesUtil::setCookie("password", $passwordHash);

//        // Insert user into the database
//        $user_id = $this->userDao->createUser($name, $email, $passwordHash);

//        if (!$user_id) {
//            throw new Exception("Failed to register user.");
//        }


        $this->otpVerificationService->sendOtp($email);

        return ["message" => "OTP sent to email."];
//        return ["user_id" => $user_id, "message" => "User registered successfully. OTP sent to email."];
    }

    /**
     * @param $email
     * @return void
     */
    public function checkIfTheUserAlreadyExists($email): void
    {
        $existingUser = $this->userDao->getUserByEmail($email);
        if ($existingUser) {
            ExceptionBuilder::create()->withCode(200)->withMessage(BaseConstants::USER_WITH_THIS_EMAIL_ALREADY_EXISTS)->buildRuntimeException()->throwNow();
        }
    }


    public function setUserInCookieAndSendOtp($email, $name, $password): array
    {
        $this->checkIfTheUserAlreadyExists($email);
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        CookiesUtil::setCookie(self::NAME, $name);
        CookiesUtil::setCookie(self::EMAIL, $email);
        CookiesUtil::setCookie(self::PASSWORD, $passwordHash);
        $this->otpVerificationService->sendOtp($email);
        return ["message" => "OTP sent to email."];
    }


    /**
     * @throws Exception
     */
    public function initiateUserCreationProcess(): ?array
    {
        $transactionManagerUtil = new TransactionManagerUtil();
        $email = CookiesUtil::getCookie(self::EMAIL);
        $passwordHash = CookiesUtil::getCookie(self::PASSWORD);
        $name = CookiesUtil::getCookie(self::NAME);


        if (isset($this->userDao)) {
            // Use call_user_func to pass the callable (method reference) with parameters
            $response = $transactionManagerUtil->executeTransaction(
                transactionCallback: function () use ($name, $email, $passwordHash) {
                    // This anonymous function calls the createUser method with parameters
                    $this->otpVerificationService->removeOtp($email);
                    return $this->userDao->createUser($name, $email, $passwordHash);
                }
            );

            if ($response) {
                CookiesUtil::deleteCookie(self::NAME);
                CookiesUtil::deleteCookie(self::PASSWORD);
                CookiesUtil::deleteCookie(self::EMAIL);
                $this->otpVerificationService->sendSuccessMail(BaseConstants::YOUR_ACCOUNT_IS_ACTIVATED);
                return ["message" => "User registered successfully."];
            }
        }

        return null;
    }

}
