<?php
// Include database connection
include('../config/db_connection.php');

if (isset($_GET['department_code'])) {
    $department_code = $_GET['department_code'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare('SELECT department_id FROM departments WHERE department_code = ? LIMIT 1');
    $stmt->bind_param('s', $department_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo json_encode(['success' => true, 'department_id' => $row['department_id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Subject not found']);
    }

    exit(); 
}

$query = "SELECT department_id, department_code FROM departments";
$result = $conn->query($query);

$departments = [];
while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
}

// Return data as JSON
echo json_encode($departments);
?>
