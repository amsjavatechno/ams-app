<?php
namespace AmsApp\Utils;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Autoload PHPMailer

class MailUtils
{
    private $mail;

    public function __construct($host, $username, $password, $port, $encryption = 'tls')
    {
        $this->mail = new PHPMailer(true);
        try {
            // Server settings
            $this->mail->isSMTP();                    // Use SMTP
            $this->mail->Host = $host;                // Set mail server
            $this->mail->SMTPAuth = true;             // Enable SMTP authentication
            $this->mail->Username = $username;        // SMTP username
            $this->mail->Password = $password;        // SMTP password
            $this->mail->SMTPSecure = $encryption;    // Enable encryption (tls or ssl)
            $this->mail->Port = $port;                // TCP port to connect to
            $this->mail->CharSet = 'UTF-8';           // Set email character encoding
        } catch (Exception $e) {
            throw new Exception("Mailer initialization error: " . $e->getMessage());
        }
    }

    public function sendMail($from, $fromName, $to, $subject, $body, $isHtml = true, $cc = [], $bcc = [])
    {
        try {
            // Sender info
            $this->mail->setFrom($from, $fromName);

            // Recipient(s)
            if (is_array($to)) {
                foreach ($to as $recipient) {
                    $this->mail->addAddress($recipient);
                }
            } else {
                $this->mail->addAddress($to);
            }

            // CC and BCC
            foreach ($cc as $ccEmail) {
                $this->mail->addCC($ccEmail);
            }
            foreach ($bcc as $bccEmail) {
                $this->mail->addBCC($bccEmail);
            }

            // Email content
            $this->mail->isHTML($isHtml);             // Set email format to HTML
            $this->mail->Subject = $subject;          // Set subject
            $this->mail->Body = $body;                // Set HTML body
            if (!$isHtml) {
                $this->mail->AltBody = strip_tags($body); // Set plain-text alternative body
            }

            // Send email
            return $this->mail->send();
        } catch (Exception $e) {
            throw new Exception("Mailer error: " . $this->mail->ErrorInfo);
        }
    }
}

?>
