<?php
// Include database connection
include('../config/db_connection.php');

// Query to get the total students by course
$sql = "
    SELECT 
        c.course_code AS course, 
        COUNT(s.student_id) AS total_students
    FROM 
        students s
    LEFT JOIN 
        courses c 
    ON 
        s.course_id = c.course_id
    GROUP BY 
        c.course_code
";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // Fetch rows and store in $data array
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'course' => $row['course'],
            'students' => (int)$row['total_students']
        ];
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();
?>
