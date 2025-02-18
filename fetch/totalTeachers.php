<?php
// Include database connection
include('../config/db_connection.php');

// Query to count the total number of students
$sql = "SELECT COUNT(*) AS total_teachers FROM teachers";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful and fetch the result
if ($result) {
    $row = $result->fetch_assoc();
    // Return the total number of students as a JSON response
    echo json_encode($row['total_teachers']);
} else {
    // If there was an error with the query
    echo json_encode(["error" => "Query failed"]);
}

// Close the database connection
$conn->close();
?>
