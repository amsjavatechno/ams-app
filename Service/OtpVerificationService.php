<?php

namespace AmsApp\Service;
require __DIR__.'/../vendor/autoload.php';

use AmsApp\Constants\AppConstants;
use AmsApp\Constants\BaseConstants;
use AmsApp\Dao\OtpVerificationDao;
use AmsApp\Communication\EmailUtil;
use AmsApp\Exceptions\AppException;
use AmsApp\Exceptions\ExceptionBuilder;
use AmsApp\Utils\BaseUtils;
use AmsApp\Utils\SessionFactory;
use Exception;

class OtpVerificationService
{
    private OtpVerificationDao $otpVerificationDao;
    private EmailUtil $emailUtil;

    public function __construct()
    {
        $this->otpVerificationDao = new OtpVerificationDao();
        $this->emailUtil = new EmailUtil();
    }

    /**
     * Generate and send OTP to the user's email only after it is inserted into the database.
     */
    public function sendOtp($email): bool
    {
        // Generate a random OTP code (6 digits)
        $otpCode = rand(100000, 999999);

        // OTP expiration time (e.g., 5 minutes from now)
        $expiryTime = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Insert OTP into the database
        $insertResult = $this->otpVerificationDao->insertOtp($email, $otpCode, $expiryTime);

        // Only send email if OTP insertion into the database is successful
        if ($insertResult) {
            $subject = "Your OTP Code";
            $body = "Your OTP code for verification is: $otpCode. It will expire in 5 minutes.";

            // Send OTP email to the user
            if ($this->emailUtil->sendEmail($email, $subject, $body)) {
                return true; // OTP successfully inserted into DB and email sent
            } else {
                // If email sending fails, remove the OTP record from the database (optional)
                 $this->otpVerificationDao->deleteOtpByEmail($email);
                return false; // Email sending failed
            }
        }

        return false; // OTP insertion into DB failed
    }

    /**
     * Verify the OTP entered by the user.
     * @throws AppException
     */
    public function verifyOtp($email, $otpCode): string
    {
        if(BaseUtils::isNotNull($email)){
            // Check if OTP is expired
            if ($this->otpVerificationDao->isOtpExpired($email, $otpCode)) {
                return "OTP has expired. Please request a new one.";
            }

            // Check if the OTP exists and is not already verified
            if ($this->validateOtp($email,$otpCode)) {
                // Mark OTP as verified
                $this->otpVerificationDao->verifyOtp($email, $otpCode);
                return BaseConstants::OTP_SUCCESSFULLY_VERIFIED;
            }

            return "Invalid OTP or OTP already verified.";
        } else{
            ExceptionBuilder::create()->withCode(200)->withMessage("Email null Found")->buildRuntimeException()->throwNow();
        }
    }

    /**
     * Initiate password reset flow by sending OTP to the user's email.
     * @throws Exception
     */
    public function forgotPassword($email): bool
    {
        // Check if the email exists in the database (you can add a separate check here)
        // For simplicity, assume the email exists.

        return $this->sendOtp($email);  // Send OTP to initiate password reset
    }

    /**
     * @throws Exception
     */
    public function sendSuccessMail(string $message):bool
    {
        $subject = "Account Activation";
        $body = $message;
        $email = SessionFactory::get(AppConstants::SESSION_EMAIL);
        if(BaseUtils::isNotNull($email)){
            // Send OTP email to the user
            if ($this->emailUtil->sendEmail($email, $subject, $body)) {
                return true; // OTP successfully inserted into DB and email sent
            }
        }
        return false;
    }


    public function validateOtp(string $email,string $otpCode):bool
    {
        $otpData = $this->otpVerificationDao->getOtpByEmail($email, $otpCode);
        return $otpData && !$otpData['is_verified'];
    }

    public function removeOtp(string $email):bool
    {
        return $this->otpVerificationDao->deleteOtpByEmail($email);
    }



}

