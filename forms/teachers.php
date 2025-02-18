
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

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <a href="../index.php">Dashboard</a>
                <a href="students.php">Students Management</a>
                <a href="subjects.php">Subject Management</a>
                <a href="teachers.php">Teacher Management</a>
                <a href="courses.php">Course Management</a>
                <a href="departments.php">Department Management</a>
                <a href="schedules.php">Schedule Management</a>
              
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 content" id="mainContent">
                            

                <h2>Add New Teacher</h2>
                <form id="addTeacherForm" method="POST" action="../api/teachers.php">
                    <div class="mb-3">
                        <label for="teacher_name">Teacher Name:</label>
                        <input type="text" id="teacher_name" name="teacher_name" class="form-control" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="subject_id">Subject:</label>
                        <select id="subject_id" name="subject_id" class="form-control" required>
                            <!-- Options will be fetched from the database -->
                        </select>
                    </div>
                    <script>
                        
                    </script>

                    <div class="mb-3">
                        <label for="department_id">Department:</label>
                        <select id="department_id" name="department_id" class="form-control" required>
                            <!-- Options will be fetched from the database -->
                        </select>
                    </div>
                    <script>
                    
                    </script>
                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <h2>Subjects Management</h2>
                <table id="teachersTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Teacher Name </th>
                            <th>Subject Name </th>
                            <th>Department Code </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Teacher</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editTeacherForm">
                                <input type="hidden" id="original_teachername" name="original_teacher_name"> <!-- Hidden field for student ID -->
                                    <div class="mb-3">
                                        <label for="edit_teachername" class="form-label">Subject Code:</label>
                                        <input type="text" class="form-control" id="edit_teachername" name="teacher_name" required>
                                    </div>
                                    
                        
                                    <div class="mb-3">
                                        <label for="edit_subj_name" class="form-label">Subject:</label>
                                        <select class="form-control" id="edit_subj_name" name="subject_name" required>
                                            <!-- Options will be populated dynamically -->
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_dept_code" class="form-label">Department:</label>
                                        <select class="form-control" id="edit_dept_code" name="department_code" required>
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
                <script src="../js/teachers.js"></script> 

            </div>
        </div>
    </div>

    
</body>
</html>


