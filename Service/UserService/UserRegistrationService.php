<?php

namespace AmsApp\Service\UserService;
use AmsApp\Dao\UserDao;
use AmsApp\Dao\OtpVerificationDao;
use AmsApp\Communication\EmailUtil;
use AmsApp\Service\OtpVerificationService;
use Exception;

class UserRegistrationService
{
    private UserDao $userDao;
    private OtpVerificationDao $otpDao;
    private EmailUtil $emailUtil;

    public function __construct(UserDao $userDao, OtpVerificationDao $otpDao, EmailUtil $emailUtil)
    {
        $this->userDao = $userDao;
        $this->otpDao = $otpDao;
        $this->emailUtil = $emailUtil;
    }

    /**
     * Registers a new user and sends OTP.
     * @throws Exception
     */
    public function registerUser($email, $name, $password, $gender_id, $status_id): array
    {
        // Check if the user already exists
        $existingUser = $this->userDao->getUserByEmail($email);
        if ($existingUser) {
            throw new Exception("User with this email already exists.");
        }

        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $user_id = $this->userDao->insertUser(null, $name, $email, $passwordHash, $gender_id, $status_id, 0);

        if (!$user_id) {
            throw new Exception("Failed to register user.");
        }


        $otp = new OtpVerificationService();
        $otp->sendOtp($email);

        return ["user_id" => $user_id, "message" => "User registered successfully. OTP sent to email."];
    }


    /**
     * Registers a new user and sends OTP.
     * @throws Exception
     */
    public function registerUserAndSendOtp($email, $name, $password): array
    {
        // Check if the user already exists
        $existingUser = $this->userDao->getUserByEmail($email);
        if ($existingUser) {
            throw new Exception("User with this email already exists.");
        }

        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $user_id = $userDao->createUser($name, $email, $passwordHash);

        if (!$user_id) {
            throw new Exception("Failed to register user.");
        }


        $otp = new OtpVerificationService();
        $otp->sendOtp($email);

        return ["user_id" => $user_id, "message" => "User registered successfully. OTP sent to email."];
    }




}
