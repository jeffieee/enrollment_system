<?php
// Database connection
include('../config/db_connection.php');

$action = $_GET['action'] ?? '';

// List all departments
if ($action === 'list') {
    $query = "SELECT department_code, department_name FROM departments";
    $result = $conn->query($query);

    $departments = [];
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }

    echo json_encode(['data' => $departments]);  
    exit;
}

// Add new department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $department_code = $_POST['department_code'] ?? '';
    $department_name = $_POST['department_name'] ?? '';
  
    if (!empty($department_code) && !empty($department_name)) {
        $query = "INSERT INTO departments (department_code, department_name) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $department_code, $department_name);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Department added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add the department.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}

// Update department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    $original_department_code = $_POST['original_department_code'] ?? ''; 
    $department_code = $_POST['department_code'] ?? ''; 
    $department_name = $_POST['department_name'] ?? ''; 

    if (!empty($department_code) && !empty($department_name) && !empty($original_department_code)) {
        $sql = "UPDATE departments SET department_code = ?, department_name = ? WHERE department_code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $department_code, $department_name, $original_department_code);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Department updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update department. Error: ' . $stmt->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing fields.']);
    }
}

// Delete department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    // Get the JSON input sent from the client
    $input = json_decode(file_get_contents('php://input'), true);
    $department_code = $input['department_code'] ?? '';

    if (!empty($department_code)) {
        $query = "DELETE FROM departments WHERE department_code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $department_code);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Department deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete the department.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid department code.']);
    }
}
?>
