<?php

namespace AmsApp\Dao;

require __DIR__ . '/../vendor/autoload.php';

use PDO;

class OtpVerificationDao extends CommonDao
{
    /**
     * Insert OTP record into the database.
     */
    public function insertOtp($email, $otpCode, $expiryTime)
    {
        $query = "INSERT INTO otp_verification (email, otp_code, expired_at) 
                  VALUES (:email, :otp_code, :expired_at)";
        return $this->insert($query, [
            'email' => $email,
            'otp_code' => $otpCode,
            'expired_at' => $expiryTime
        ]);
    }

    /**
     * Fetch OTP record by email and OTP code.
     */
    public function getOtpByEmail($email, $otpCode)
    {
        $query = "SELECT * FROM otp_verification WHERE email = :email AND otp_code = :otp_code";
        return $this->fetchOne($query, ['email' => $email, 'otp_code' => $otpCode]);
    }

    /**
     * Update OTP status to verified.
     */
    public function verifyOtp($email, $otpCode)
    {
        $query = "UPDATE otp_verification SET is_verified = 1 WHERE email = :email AND otp_code = :otp_code";
        return $this->update($query, ['email' => $email, 'otp_code' => $otpCode]);
    }

    /**
     * Check if the OTP has expired.
     */
    public function isOtpExpired($email, $otpCode)
    {
        $query = "SELECT expired_at FROM otp_verification WHERE email = :email AND otp_code = :otp_code";
        $result = $this->fetchOne($query, ['email' => $email, 'otp_code' => $otpCode]);

        return $result && strtotime($result['expired_at']) < time();
    }

    public function deleteOtpByEmail($email)
    {
        $query = "DELETE FROM otp_verification WHERE email = :email";
        return $this->delete($query, ['email' => $email]);
    }

}
?>
