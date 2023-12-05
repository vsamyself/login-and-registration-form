<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

    $uname = $_POST['uname'];
    $upswd = $_POST['upswd'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tamilhacks";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM register WHERE uname1='$uname' AND upswd1='$upswd'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
	ob_start(); // Start output buffering
                    header("Location: http://localhost/project2/profile.html");
                    ob_end_flush(); // Flush the output buffer and send the header
                    exit();
    } else {
        die(json_encode(array("status" => false)));
    }

    $conn->close();
} else {
    $text = $user; // $user is not defined in your code. You might want to replace it with a valid variable.
    echo json_encode(array('text' => $text, 'name' => "vishnu" /* and anything else you want */));
}
