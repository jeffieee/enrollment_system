<?php
// Database connection
include('../config/db_connection.php');


$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $query = "SELECT 
                s.student_id, 
                s.lastname, 
                s.firstname, 
                s.birthdate, 
                c.course_name 
              FROM students s 
              LEFT JOIN courses c ON s.course_id = c.course_id";
              
    $result = $conn->query($query);

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode(['data' => $students]);  
    exit;
}

//POST METHOD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] == 'add') {
    $lastname = $_POST['lastname'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $course_id = $_POST['course_id'] ?? '';

    // Validate inputs
    if (!empty($lastname) && !empty($firstname) && !empty($birthdate) && !empty($course_id)) {
        $query = "INSERT INTO students (lastname, firstname, birthdate, course_id) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $lastname, $firstname, $birthdate, $course_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Student added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add student.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}
//edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] == 'update') {
    $student_id = $_POST['student_id'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $birthdate = $_POST['birthdate'];
    $course_id = $_POST['course_id'];

    // Perform the update query
    $sql = "UPDATE students SET lastname = ?, firstname = ?, birthdate = ?, course_id = ? WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $lastname, $firstname, $birthdate, $course_id, $student_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Student updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update student.']);
    }
}

// Delete a course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'delete') {
    // Parse raw input to retrieve query parameters
    $input = json_decode(file_get_contents('php://input'), true);
    $student_id = $input['student_id'] ?? '';

    if (!empty($student_id)) {
        $sql = "DELETE FROM students WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $student_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Student deleted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete student.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing student code.']);
    }
}


?>
