<?php
// Database connection
include('../config/db_connection.php');

$action = $_GET['action'] ?? '';

// List all courses
if ($action === 'list') {
    $query = "SELECT 
                course_code,
                course_name
              FROM courses";
              
    $result = $conn->query($query);

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }

    echo json_encode(['data' => $courses]);  
    exit;
}

// Add a new course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'add') {
    $course_code = $_POST['course_code'] ?? '';
    $course_name = $_POST['course_name'] ?? '';

    if (!empty($course_code) && !empty($course_name)) {
        $query = "INSERT INTO courses (course_code, course_name) 
                  VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $course_code, $course_name);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Course added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add the course.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}

// Update a course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'update') {
    $original_course_code = $_POST['original_course_code'] ?? ''; 
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];

    if (!empty($course_code) && !empty($course_name) && !empty($original_course_code)) {
        $sql = "UPDATE courses SET course_code = ?, course_name = ? WHERE course_code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $course_code, $course_name, $original_course_code);

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
    $course_code = $input['course_code'] ?? '';

    if (!empty($course_code)) {
        $sql = "DELETE FROM courses WHERE course_code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $course_code);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Course deleted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete course.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing course code.']);
    }
}
?>
