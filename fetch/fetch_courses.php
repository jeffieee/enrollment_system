<?php
// Include database connection
include('../config/db_connection.php');

// Check if a specific course_name is provided
if (isset($_GET['course_name'])) {
    $courseName = $_GET['course_name'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare('SELECT course_id FROM courses WHERE course_name = ? LIMIT 1');
    $stmt->bind_param('s', $courseName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo json_encode(['success' => true, 'course_id' => $row['course_id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Course not found']);
    }

    exit(); 
}
    

$query = "SELECT course_id, course_name FROM courses";
$result = $conn->query($query);

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

// Return all courses as JSON if no course_name is specified
echo json_encode($courses);
?>
