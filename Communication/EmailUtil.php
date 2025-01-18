<?php

namespace AmsApp\Communication;
require __DIR__.'/../vendor/autoload.php';
use AmsApp\AppConfig;
use AmsApp\Utils\Http\HttpBaseUtil;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use AmsApp\Exceptions\ExceptionBuilder;
class EmailUtil
{
    const EMAIL_HOST_NAME = "email.host.name";
    const EMAIL_USERNAME = "email.username";
    const EMAIL_PASSWORD = "email.password";
    const EMAIL_ENCRYPTION = "email.encryption";
    const EMAIL_PORT = "email.port";
    const EMAIL_FROM_ADDRESS = "email.from.address";
    const EMAIL_TITLE = "email.title";
    private PHPMailer $mailer;
    private bool $connected = false;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        try {
            // SMTP configuration
            $this->mailer->isSMTP();
            $this->mailer->Host = AppConfig::getPropertyValueByKey(self::EMAIL_HOST_NAME);
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = AppConfig::getPropertyValueByKey(self::EMAIL_USERNAME);
            $this->mailer->Password = AppConfig::getPropertyValueByKey(self::EMAIL_PASSWORD);
            $this->mailer->SMTPSecure = AppConfig::getPropertyValueByKey(self::EMAIL_ENCRYPTION);
            $this->mailer->Port = AppConfig::getPropertyValueByKey(self::EMAIL_PORT);
            $this->mailer->setFrom(AppConfig::getPropertyValueByKey(self::EMAIL_FROM_ADDRESS), AppConfig::getPropertyValueByKey(self::EMAIL_TITLE));
        } catch (Exception $e) {
            ExceptionBuilder::create()->withCode(HttpBaseUtil::HTTP_INTERNAL_SERVER_ERROR)->withMessage("Failed to configure PHPMailer: " . $e->getMessage())->build();
        }
    }

    public function connect(): void
    {
        if (!$this->connected) {
            try {
                $this->mailer->smtpConnect();
                $this->connected = true;
            } catch (Exception $e) {
                ExceptionBuilder::create()->withMessage("Failed to connect to SMTP: " . $e->getMessage())->build();
            }
        }
    }

    public function sendEmail($to, $subject, $body, $isHtml = true):bool
    {
        $isSuccess = false;
        try {
            if (!$this->connected) {
                $this->connect();
            }
            // Reset the recipient and email settings
            $this->mailer->clearAddresses();
            $this->mailer->clearAttachments();

            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->isHTML($isHtml);

            $isSuccess = $this->mailer->send();
        } catch (Exception $e) {
            ExceptionBuilder::create()->withMessage("Failed to send email: " . $e->getMessage())->build()->throwNow();
        }
        return $isSuccess;
    }

    public function close(): void
    {
        if ($this->connected) {
            $this->mailer->smtpClose();
            $this->connected = false;
        }
    }
}



//$emailUtil = new EmailUtil();
//
//try {
//    // Open SMTP connection
//    $emailUtil->connect();
//
//    // Send multiple emails using the same connection
//    $emailUtil->sendEmail('amsjavatechno@gmail.com', 'Hello This is Test Body', 'Body for user 1');
//} catch (Exception $e) {
//    echo "Error: " . $e->getMessage();
//} finally {
//    // Close the connection
//    $emailUtil->close();
//}