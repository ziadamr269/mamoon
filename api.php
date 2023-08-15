<?php
require_once("db_config.php");

// Create a new user
function createUser($name, $phone, $parentPhone, $dob, $level) {
    global $conn;
    echo "INSERT INTO users (name, phone, parent_phone, dob, level) VALUES ('$name', '$phone', '$parentPhone', '$dob', '$level')";
    $sql = "INSERT INTO users (name, phone, parent_phone, dob, level) VALUES ('$name', '$phone', '$parentPhone', '$dob', '$level')";
    if ($conn->query($sql) === TRUE) {
        return "User created successfully";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Read all users
function getAllUsers() {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

// Update user by ID
function updateUser($id, $name, $phone, $parentPhone, $dob, $level) {
    global $conn;
    $sql = "UPDATE users SET name='$name', phone='$phone', parent_phone='$parentPhone', dob='$dob', level='$level' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        return "User updated successfully";
    } else {
        return "Error updating user: " . $conn->error;
    }
}

// Delete user by ID
function deleteUser($id) {
    global $conn;
    echo "this is id: $id";
    $sql = "DELETE FROM users WHERE id= $id ";
    if ($conn->query($sql) === TRUE) {
        return "User deleted successfully";
    } else {
        return "Error deleting user: " . $conn->error;
    }
}
?>
