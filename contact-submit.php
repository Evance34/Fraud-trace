<?php

require_once 'includes/config.php';
require_once 'includes/send-mail.php';

/*
====================================================
ONLY ALLOW POST REQUEST
====================================================
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: contact.html");

    exit();

}

/*
====================================================
COLLECT DATA
====================================================
*/

$fullname = cleanInput($_POST["fullname"] ?? "");

$email = cleanInput($_POST["email"] ?? "");

$phone = cleanInput($_POST["phone"] ?? "");

$subject = cleanInput($_POST["subject"] ?? "");

$message = cleanInput($_POST["message"] ?? "");

/*
====================================================
VALIDATION
====================================================
*/

if (

    empty($fullname) ||

    empty($email) ||

    empty($subject) ||

    empty($message)

){

    die("Please complete all required fields.");

}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

    die("Invalid email address.");

}

/*
====================================================
SEND EMAIL TO FRAUD TRACE
====================================================
*/

try{

    $mail = createMailer();

    $mail->addAddress(COMPANY_EMAIL,SITE_NAME);

    $mail->Subject = "Website Contact Form: " . $subject;

    $mail->Body = "

    <h2>New Contact Form Submission</h2>

    <table border='1' cellpadding='8' cellspacing='0' width='100%'>

    <tr>

    <td><strong>Name</strong></td>

    <td>{$fullname}</td>

    </tr>

    <tr>

    <td><strong>Email</strong></td>

    <td>{$email}</td>

    </tr>

    <tr>

    <td><strong>Phone</strong></td>

    <td>{$phone}</td>

    </tr>

    <tr>

    <td><strong>Subject</strong></td>

    <td>{$subject}</td>

    </tr>

    </table>

    <br>

    <h3>Message</h3>

    <p>{$message}</p>

    ";

    $mail->send();

}catch(Exception $e){

    die("Unable to send your message.");

}

/*
====================================================
SEND CONFIRMATION EMAIL
====================================================
*/

try{

    $mail = createMailer();

    $mail->addAddress($email,$fullname);

    $mail->Subject = "We've Received Your Message";

    $mail->Body = "

    <h2>Thank You for Contacting Fraud Trace</h2>

    <p>Dear {$fullname},</p>

    <p>We have successfully received your message.</p>

    <p>Our team will review your enquiry and respond as soon as possible during business hours.</p>

    <br>

    <p>Kind Regards,</p>

    <p><strong>Fraud Trace</strong></p>

    ";

    $mail->send();

}catch(Exception $e){

}

/*
====================================================
REDIRECT
====================================================
*/

header("Location: contact-success.html");

exit();

?>