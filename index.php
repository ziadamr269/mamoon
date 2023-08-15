<?php
$servername = "185.27.134.10";
$username = "if0_34571905";
$password = "t0y9z1S49JM94Y";
$dbname = "if0_34571905_mamoon";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a new record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['name']) &&
        isset($input['phone']) &&
        isset($input['parent_phone']) &&
        isset($input['dob']) &&
        isset($input['level'])
    ) {
        $name = $input["name"];
        $phone = $input["phone"];
        $parent_phone = $input["parent_phone"];
        $dob = $input["dob"];
        $level = $input["level"];

        $sql = "INSERT INTO users (name, phone, parent_phone, dob, level) 
                VALUES ('$name', '$phone', '$parent_phone', '$dob', '$level')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Record created successfully"));
        } else {
            echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "Missing required fields"));
    }
}

// Read records
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $rows = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo json_encode(array("message" => "No records found"));
    }
}

// Update a record
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['id']) &&
        isset($input['name']) &&
        isset($input['phone']) &&
        isset($input['parent_phone']) &&
        isset($input['dob']) &&
        isset($input['level'])
    ) {
        $id = $input["id"];
        $name = $input["name"];
        $phone = $input["phone"];
        $parent_phone = $input["parent_phone"];
        $dob = $input["dob"];
        $level = $input["level"];

        $sql = "UPDATE users SET name='$name', phone='$phone', parent_phone='$parent_phone', dob='$dob', level='$level' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Record updated successfully"));
        } else {
            echo json_encode(array("error" => "Error updating record: " . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "Missing required fields"));
    }
}

// Delete a record
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (isset($input['id'])) {
        $id = $input["id"];

        $sql = "DELETE FROM users WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Record deleted successfully"));
        } else {
            echo json_encode(array("error" => "Error deleting record: " . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "Missing ID parameter"));
    }
}

$conn->close();
?>
