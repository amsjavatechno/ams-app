<?php

namespace AmsApp\Service;
require __DIR__.'/../vendor/autoload.php';
use AmsApp\Dao\OtpVerificationDao;
use AmsApp\Communication\EmailUtil;
use Exception;

class OtpVerificationService
{
    private $otpVerificationDao;
    private $emailUtil;

    public function __construct()
    {
        $this->otpVerificationDao = new OtpVerificationDao();
        $this->emailUtil = new EmailUtil();
    }

    /**
     * Generate and send OTP to the user's email only after it is inserted into the database.
     * @throws Exception
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
     */
    public function verifyOtp($email, $otpCode)
    {
        // Check if OTP is expired
        if ($this->otpVerificationDao->isOtpExpired($email, $otpCode)) {
            return "OTP has expired. Please request a new one.";
        }

        // Fetch OTP details from the database
        $otpData = $this->otpVerificationDao->getOtpByEmail($email, $otpCode);

        // Check if the OTP exists and is not already verified
        if ($otpData && !$otpData['is_verified']) {
            // Mark OTP as verified
            $this->otpVerificationDao->verifyOtp($email, $otpCode);
            return "OTP successfully verified.";
        }

        return "Invalid OTP or OTP already verified.";
    }

    /**
     * Initiate password reset flow by sending OTP to the user's email.
     */
    public function forgotPassword($email)
    {
        // Check if the email exists in the database (you can add a separate check here)
        // For simplicity, assume the email exists.

        return $this->sendOtp($email);  // Send OTP to initiate password reset
    }
}

