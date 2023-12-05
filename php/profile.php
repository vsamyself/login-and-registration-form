<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tamilhacks";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['profile'])) {
        $name = $conn->real_escape_string($_POST["name"]);
        $stmt = $conn->prepare("SELECT uname1, email, upswd1, number, dob FROM register WHERE uname1=?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            die(json_encode(array("email" => $row["email"], "number" => $row["number"], "dob" => $row["dob"], "name" => $row["uname1"])));
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
        $name = $conn->real_escape_string($_POST["name"]);
        $number = $conn->real_escape_string($_POST["number"]);
        $dob = $conn->real_escape_string($_POST["dob"]);

        $stmt = $conn->prepare("UPDATE register SET number=?, dob=? WHERE uname1=?");
        $stmt->bind_param("sss", $number, $dob, $name);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            die(json_encode(array("status" => true, "data" => "Update successful")));
        } else {
            die(json_encode(array("status" => false, "error" => "Update failed")));
        }
    }
} catch (Exception $e) {
    die(json_encode(array("status" => false, "error" => $e->getMessage())));
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
