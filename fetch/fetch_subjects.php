<?php
// Include database connection
include('../config/db_connection.php');


if (isset($_GET['subject_name'])) {
    $subject_name = $_GET['subject_name'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare('SELECT subject_id FROM subjects WHERE subject_name = ? LIMIT 1');
    $stmt->bind_param('s', $subject_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo json_encode(['success' => true, 'subject_id' => $row['subject_id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Subject not found']);
    }

    exit(); 
}
$query = "SELECT subject_id, subject_name FROM subjects";
$result = $conn->query($query);

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}

// Return data as JSON
echo json_encode($subjects);
?>
