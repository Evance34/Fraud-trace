<?php

require_once 'includes/config.php';
require_once 'includes/send-mail.php';

/*
====================================================
Only Allow POST Requests
====================================================
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: complaint.html");

    exit();

}

/*
====================================================
Collect Form Data
====================================================
*/

$data = [

    "fullname" => cleanInput($_POST["fullname"] ?? ""),

    "email" => cleanInput($_POST["email"] ?? ""),

    "phone" => cleanInput($_POST["phone"] ?? ""),

    "address" => cleanInput($_POST["address"] ?? ""),

    "city" => cleanInput($_POST["city"] ?? ""),

    "state" => cleanInput($_POST["state"] ?? ""),

    "country" => cleanInput($_POST["country"] ?? ""),

    "fraudType" => cleanInput($_POST["fraudType"] ?? ""),

    "incidentDate" => cleanInput($_POST["incidentDate"] ?? ""),

    "amountLost" => cleanInput($_POST["amountLost"] ?? ""),

    "scammer" => cleanInput($_POST["scammer"] ?? ""),

    "website" => cleanInput($_POST["website"] ?? ""),

    "description" => cleanInput($_POST["description"] ?? ""),

    "contactMethod" => cleanInput($_POST["contactMethod"] ?? "Email")

];

/*
====================================================
Basic Validation
====================================================
*/

$required = [

    "fullname",

    "email",

    "phone",

    "city",

    "state",

    "country",

    "fraudType",

    "description"

];

foreach ($required as $field) {

    if (empty($data[$field])) {

        die("Missing required field: " . $field);

    }

}

if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {

    die("Invalid email address.");

}

/*
====================================================
Generate Reference Number
====================================================
*/

$referenceNumber = generateReferenceNumber();

/*
====================================================
Upload Evidence
====================================================
*/

$uploadedFiles = [];

if (!empty($_FILES["evidence"]["name"][0])) {

    if (!file_exists(UPLOAD_PATH)) {

        mkdir(UPLOAD_PATH, 0755, true);

    }

    foreach ($_FILES["evidence"]["name"] as $key => $filename) {

        if ($_FILES["evidence"]["error"][$key] !== UPLOAD_ERR_OK) {

            continue;

        }

        if (!isAllowedFile($filename)) {

            continue;

        }

        if ($_FILES["evidence"]["size"][$key] > MAX_FILE_SIZE) {

            continue;

        }

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $newName = uniqid("evidence_", true) . "." . $extension;

        $destination = UPLOAD_PATH . $newName;

        if (

            move_uploaded_file(

                $_FILES["evidence"]["tmp_name"][$key],

                $destination

            )

        ) {

            $uploadedFiles[] = $newName;

        }

    }

}

/*
====================================================
Send Emails
====================================================
*/

$adminSent = notifyAdmin(

    $data,

    $referenceNumber

);

$userSent = sendConfirmationEmail(

    $data["fullname"],

    $data["email"],

    $referenceNumber

);

/*
====================================================
Future Database Storage
====================================================

You can save the complaint to MySQL here later.

*/

/*
====================================================
Redirect
====================================================
*/

header(

"Location: thank-you.html?ref=" .

urlencode($referenceNumber)

);

exit();

?>