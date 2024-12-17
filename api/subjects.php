<?php
// Database connection
include('../config/db_connection.php');


$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $query = "SELECT 
              
                s.subject_code, 
                s.subject_name, 
                sch.time
              FROM subjects s 
              LEFT JOIN schedules sch ON s.schedule_id = sch.schedule_id";
              
    $result = $conn->query($query);

    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }

    echo json_encode(['data' => $subjects]);  
    exit;
}

//POST METHOD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] == 'add') {
    $subject_code = $_POST['subject_code'] ?? '';
    $subject_name = $_POST['subject_name'] ?? '';
    $schedule_id = $_POST['schedule_id'] ?? '';
  

    // Validate inputs
    if (!empty($subject_code) && !empty($subject_name) && !empty($schedule_id)) {
        $query = "INSERT INTO subjects (subject_code, subject_name, schedule_id) 
                  VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $subject_code, $subject_name, $schedule_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Subject added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add the subject.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}

// Update a course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'update') {
    $original_subject_code = $_POST['original_subject_code'] ?? ''; 
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $time = $_POST['schedule_id'];

    if (!empty($subject_code) && !empty($subject_name) && !empty($original_subject_code) && !empty($time)) {
        $sql = "UPDATE subjects SET subject_code = ?, subject_name = ?, schedule_id = ? WHERE subject_code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssis', $subject_code, $subject_name, $time, $original_subject_code);
 
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Courses updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update Courses. Error: ' . $stmt->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing fields.']);
    }
}

// Delete a course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'delete') {
    // Parse raw input to retrieve query parameters
    $input = json_decode(file_get_contents('php://input'), true);
    $subject_code = $input['subject_code'] ?? '';

    if (!empty($subject_code)) {
        $sql = "DELETE FROM subjects WHERE subject_code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $subject_code);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Subject deleted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete subject.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing course code.']);
    }
}
?>
