<?php
// Include database connection
include('../config/db_connection.php');

// Query to get the total students by course
$sql = "
    SELECT 
        age,
        count(student_id) as total_students
    FROM 
        enrollment
    GROUP BY 
        age;
";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // Fetch rows and store in $data array
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'age' => $row['age'],
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
