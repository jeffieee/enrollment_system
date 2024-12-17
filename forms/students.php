
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment App</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.css" rel="stylesheet">
      <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand ms-3" href="../index.html">Enrollment Management System</a>
    </nav>

    <div class="container-fluid ">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <a href="../index.html">Dashboard</a>
                <a href="students.php">Students Management</a>
                <a href="subjects.php">Subject Management</a>
                <a href="teachers.php">Teacher Management</a>
                <a href="courses.php">Course Management</a>
                <a href="departments.php">Department Management</a>
                <a href="schedules.php">Schedule Management</a>
              
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 content" id="mainContent">
                            
                <h2>Add New Student</h2>
                <form id="addStudentForm" method="POST" action="../api/students.php">
                    <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="birthdate">Birthdate:</label>
                        <input type="date" id="birthdate" name="birthdate"  required>
                    </div>
                    <div class="mb-3">
                        <label for="course_id">Course:</label>
                        <select id="course_id" name="course_id" required>
                            <!-- Options will be fetched from the database -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <h2>Students Management</h2>
                <div class="table-responsive">
                <table id="studentsTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Birthdate</th>
                            <th>Course</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editStudentForm">
                                <input type="hidden" id="edit_student_id" name="student_id"> <!-- Hidden field for student ID -->
                                <div class="mb-3">
                                    <label for="edit_lastname" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control" id="edit_lastname" name="lastname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_firstname" class="form-label">First Name:</label>
                                    <input type="text" class="form-control" id="edit_firstname" name="firstname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_birthdate" class="form-label">Birthdate:</label>
                                    <input type="date" class="form-control" id="edit_birthdate" name="birthdate" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_course_name" class="form-label">Course:</label>
                                    <select class="form-control" id="edit_course_name" name="course_id" required>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../js/students.js"></script> 

        </div>
    </div>

    





    
    
</body>
</html>


