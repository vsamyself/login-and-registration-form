<?php

$uname1 = $_POST['uname1'];
$email  = $_POST['email'];
$upswd1 = $_POST['upswd1'];
$upswd2 = $_POST['upswd2'];
$number = $_POST['number'];
$dob    = $_POST['date'];

if (!empty($uname1) || !empty($email) || !empty($upswd1) || !empty($upswd2) || !empty($number) || !empty($dob)) {

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "tamilhacks";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die(json_encode(array('status' => false, 'msg' => 'Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error)));
    } else {

        // Checking if email is already registered
        $SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {

            // Check if passwords match
            if ($upswd1 === $upswd2) {

                // Hash the password
                $hashed_password = password_hash($upswd1, PASSWORD_DEFAULT);

                // Insert user data
                $INSERT = "INSERT INTO register (uname1, email, upswd1, upswd2, number, dob) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ssssss", $uname1, $email, $hashed_password, $upswd2, $number, $dob);
                $stmt->execute();

                if ($stmt) {
                    ob_start(); // Start output buffering
                    header("Location: http://localhost/project2/profile.html");
                    ob_end_flush(); // Flush the output buffer and send the header
                    exit();
                    
                } else {
                    echo json_encode(array('status' => false, 'msg' => 'Error in statement: ' . $conn->error));
                }

            } else {
                echo json_encode(array('status' => false, 'msg' => 'Passwords do not match'));
            }

        } else {
            echo json_encode(array('status' => false, 'msg' => 'Someone already registered using this email'));
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo json_encode(array('status' => false, 'msg' => 'All fields are required'));
}
?>
