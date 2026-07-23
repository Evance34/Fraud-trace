<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'config.php';

/*
====================================================
Create Mail Object
====================================================
*/

function createMailer()
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Host = SMTP_HOST;

    $mail->SMTPAuth = true;

    $mail->Username = SMTP_USERNAME;

    $mail->Password = SMTP_PASSWORD;

    $mail->SMTPSecure = SMTP_ENCRYPTION;

    $mail->Port = SMTP_PORT;

    $mail->CharSet = 'UTF-8';

    $mail->isHTML(true);

    $mail->setFrom(COMPANY_EMAIL, SITE_NAME);

    return $mail;
}

/*
====================================================
Send Confirmation Email to Victim
====================================================
*/

function sendConfirmationEmail($recipientName, $recipientEmail, $referenceNumber)
{
    try {

        $mail = createMailer();

        $mail->addAddress($recipientEmail, $recipientName);

        $mail->Subject = "Your Fraud Trace Complaint Has Been Received";

        $body = "

        <h2>Thank You for Contacting Fraud Trace</h2>

        <p>Dear {$recipientName},</p>

        <p>We have successfully received your complaint.</p>

        <p><strong>Reference Number:</strong> {$referenceNumber}</p>

        <p>Our team will review the information you submitted. If additional information is required, we will contact you using the details you provided.</p>

        <p>Please keep your reference number for future correspondence.</p>

        <br>

        <p>Regards,</p>

        <p><strong>Fraud Trace</strong></p>

        ";

        $mail->Body = $body;

        return $mail->send();

    } catch (Exception $e) {

        return false;

    }
}

/*
====================================================
Notify Fraud Trace Team
====================================================
*/

function notifyAdmin($data, $referenceNumber)
{
    try {

        $mail = createMailer();

        $mail->addAddress(COMPANY_EMAIL, SITE_NAME);

        $mail->Subject = "New Fraud Complaint - {$referenceNumber}";

        $body = "

        <h2>New Complaint Received</h2>

        <table border='1' cellpadding='10' cellspacing='0' width='100%'>

        <tr>

        <td><strong>Reference</strong></td>

        <td>{$referenceNumber}</td>

        </tr>

        <tr>

        <td><strong>Name</strong></td>

        <td>{$data['fullname']}</td>

        </tr>

        <tr>

        <td><strong>Email</strong></td>

        <td>{$data['email']}</td>

        </tr>

        <tr>

        <td><strong>Phone</strong></td>

        <td>{$data['phone']}</td>

        </tr>

        <tr>

        <td><strong>Fraud Type</strong></td>

        <td>{$data['fraudType']}</td>

        </tr>

        <tr>

        <td><strong>Country</strong></td>

        <td>{$data['country']}</td>

        </tr>

        <tr>

        <td><strong>Amount Lost</strong></td>

        <td>{$data['amountLost']}</td>

        </tr>

        </table>

        <br>

        <h3>Description</h3>

        <p>{$data['description']}</p>

        ";

        $mail->Body = $body;

        return $mail->send();

    } catch (Exception $e) {

        return false;

    }
}