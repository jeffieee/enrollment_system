<?php
include('../config/db_connection.php');

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $query = "SELECT time FROM schedules";
    $result = $conn->query($query);
    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }
    echo json_encode(['data' => $schedules]);  
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'update') {
        $original_time = $_POST['original_time_sched'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $schedule_time = date("h:i A", strtotime($start_time)) . " - " . date("h:i A", strtotime($end_time));

        $query = "UPDATE schedules SET time = ? WHERE time = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $schedule_time, $original_time);
        
        echo json_encode(['success' => $stmt->execute(), 'message' => 'Schedule updated successfully.']);
    }

    if (empty($_POST['start_time']) || empty($_POST['end_time'])) {
        echo json_encode(['success' => false, 'message' => 'Both start and end times are required.']);
    }
}

if ($action === 'delete') {
    $time = $_GET['time'] ?? '';
    $query = "DELETE FROM schedules WHERE time = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $time);
    echo json_encode(['success' => $stmt->execute(), 'message' => 'Schedule deleted successfully.']);
}

$conn->close();
?>
