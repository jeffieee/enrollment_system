<?php
// Include database connection
include('../config/db_connection.php');

// Query to get the total students by course
$sql = "
    SELECT 
        d.department_code AS department_code, 
        COUNT(t.teacher_id) AS total_teachers
    FROM 
        teachers t
    LEFT JOIN 
        departments d
    ON 
        t.department_id = d.department_id
    GROUP BY 
        d.department_code;
";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // Fetch rows and store in $data array
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'department_code' => $row['department_code'],
            'teachers' => (int)$row['total_teachers']
        ];
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();
?>
