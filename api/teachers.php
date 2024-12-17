<?php
// Database connection
include('../config/db_connection.php');

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $query = "SELECT  
                t.teacher_name, 
                s.subject_name,
                d.department_code 
              FROM teachers t 
              LEFT JOIN subjects s ON t.subject_id = s.subject_id
              LEFT JOIN departments d ON t.department_id = d.department_id";
              
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
    $teacher_name = $_POST['teacher_name'] ?? '';
    $subject_id = $_POST['subject_id'] ?? '';
    $department_id = $_POST['department_id'] ?? '';

    // Validate inputs
    if (!empty($teacher_name) && !empty($subject_id) && !empty($department_id)) {
        $query = "INSERT INTO teachers (teacher_name, subject_id, department_id) 
                  VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sii", $teacher_name, $subject_id, $department_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Teacher added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add the teacher.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}

// POST Method for updating a teacher
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] == 'update') {
    $teacher_name = $_POST['teacher_name'] ?? '';
    $subject_id = $_POST['subject_name'] ?? '';
    $department_id = $_POST['department_code'] ?? '';
    $original_teachername = $_POST['original_teacher_name'] ?? '';

    // Validate inputs
    if (!empty($teacher_name) && !empty($subject_id) && !empty($department_id) && !empty($original_teachername)) {
        // Update query
        $query = "UPDATE teachers 
                  SET teacher_name = ?, subject_id = ?, department_id = ? 
                  WHERE teacher_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("siis", $teacher_name, $subject_id, $department_id, $original_teachername);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Teacher updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the teacher.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}

// Delete a course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'delete') {
    // Parse raw input to retrieve query parameters
    $input = json_decode(file_get_contents('php://input'), true);
    $teacher_name = $input['teacher_name'] ?? '';

    if (!empty($teacher_name)) {
        $sql = "DELETE FROM teachers WHERE teacher_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $teacher_name);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Teacher deleted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete subject.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing teacher details.']);
    }
}





?>
