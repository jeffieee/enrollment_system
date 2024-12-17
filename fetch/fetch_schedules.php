<?php
// Include database connection
include('../config/db_connection.php');

// Check if a specific course_name is provided
if (isset($_GET['time'])) {
    $sched = $_GET['time'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare('SELECT schedule_id FROM schedules WHERE time = ? LIMIT 1');
    $stmt->bind_param('s', $sched);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo json_encode(['success' => true, 'schedule_id' => $row['schedule_id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Schedule not found']);
    }

    exit(); 
}
$query = "SELECT schedule_id, time FROM schedules";
$result = $conn->query($query);

$schedules = [];
while ($row = $result->fetch_assoc()) {
    $schedules[] = $row;
}

// Return data as JSON
echo json_encode($schedules);
?>
