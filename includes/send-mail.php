<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function createMailer()
{
    $mail = new PHPMailer(true);

    // Enable SMTP
    $mail->isSMTP();

    // SMTP Server
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // Gmail Credentials
    $mail->Username = 'thegrowthn@gmail.com';
    $mail->Password = 'sioj iqvg aufj mewo';

    // Encryption
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Email Settings
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);

    // Sender
    $mail->setFrom('thegrowthn@gmail.com', 'Fraud Trace');

    // Uncomment this for debugging if needed
    // $mail->SMTPDebug = 2;

    return $mail;
}

/*
==========================================
Send Confirmation Email to Victim
==========================================
*/

function sendConfirmationEmail($recipientName, $recipientEmail, $referenceNumber)
{
    try {

        $mail = createMailer();

        $mail->addAddress($recipientEmail, $recipientName);

        $mail->Subject = 'Your Fraud Trace Complaint Has Been Received';

        $mail->Body = "
        <h2>Thank You for Contacting Fraud Trace</h2>

        <p>Dear <strong>{$recipientName}</strong>,</p>

        <p>We have successfully received your complaint.</p>

        <p><strong>Reference Number:</strong> {$referenceNumber}</p>

        <p>Our investigation team will review the information you submitted. If additional information is required, we will contact you using the details you provided.</p>

        <p>Please keep your reference number for future correspondence.</p>

        <br>

        <p>Regards,</p>
        <p><strong>Fraud Trace Team</strong></p>
        ";

        return $mail->send();

    } catch (Exception $e) {

        echo $mail->ErrorInfo;
        return false;

    }
}

/*
==========================================
Notify Admin
==========================================
*/

function notifyAdmin($data, $referenceNumber)
{
    try {

        $mail = createMailer();

        $mail->addAddress('skedoidiot@gmail.com', 'Fraud Trace');

        $mail->Subject = "New Fraud Complaint - {$referenceNumber}";

        $mail->Body = "

        <h2>New Fraud Complaint Received</h2>

        <table border='1' cellpadding='10' cellspacing='0' width='100%'>

            <tr>
                <td><strong>Reference</strong></td>
                <td>{$referenceNumber}</td>
            </tr>

            <tr>
                <td><strong>Full Name</strong></td>
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

        return $mail->send();

    } catch (Exception $e) {

        echo $mail->ErrorInfo;
        return false;

    }
}
