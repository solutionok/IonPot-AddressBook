<?php
namespace IonPot\AddressBook\Service;

use \IonPot\AddressBook\Model\MemberForgot;
use \PHPMailer;

class MailService
{

    /**
     * send mail for reset password
     */
    public function sendResetPasswordEmail($memberAry)
    {
        $isExists = class_exists('PHPMailer');
        if (! $isExists) {
            require 'vendor/phpmailer/class.phpmailer.php';
            require 'vendor/phpmailer/class.smtp.php';
            require 'Model/MemberForgot.php';
        }

        $memberForgotObj = new MemberForgot();
        $resetHash = $memberForgotObj->addRecovery($memberAry[0]['id']);
        // mail template for reset password
        require_once 'Template/reset-password-email-template.php';
        $emailBody = getResetPasswordBody($memberAry[0]['username'], $resetHash);
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Username = SMTP_EMAIL_USERNAME;
        $mail->Password = SMTP_EMAIL_PASSWORD;
        $mail->Host = SMTP_HOST;
        $mail->Port = SMTP_PORT;
        $mail->SMTPAuth = SMTP_AUTH;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->SMTPDebug = 0;
        $mail->Mailer = "smtp";
        $mail->SetFrom(SENDER_EMAIL, SENDER_NAME);
        $mail->AddReplyTo(SENDER_EMAIL, SENDER_NAME);
        $mail->ReturnPath = SENDER_EMAIL;
        // reciever email address
        $mail->AddAddress($memberAry[0]["email"]);
        // subject of the mail
        $mail->Subject = "Help to recover your account";
        // content of mail
        $mail->MsgHTML($emailBody);
        $mail->IsHTML(true);

        if (! $mail->send()) {
            return false;
        } else {
            return true;
        }
    }
}
