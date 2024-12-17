
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
    <a class="navbar-brand ms-3" href="../index.php">Enrollment Management System</a>
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

            <h2>Add New Department</h2>
                <form id="addDepartmentForm" method="POST" action="../api/departments.php">
                    <div class="mb-3">
                        <label for="department_code" class="form-label">Department Code:</label>
                        <input type="text" id="department_code" name="department_code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_name" class="form-label">Department Name:</label>
                        <input type="text" id="department_name" name="department_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <!-- Department Management Section -->
                <h2 class="mt-5">Department Management</h2>
                <table id="departmentsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Department Code</th>
                            <th>Department Name</th>
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
                                <h5 class="modal-title" id="editModalLabel">Edit Department</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editDepartmentForm">
                                    <input type="hidden" id="original_departmentcode" name="original_department_code">
                                    <div class="mb-3">
                                        <label for="edit_departmentcode" class="form-label">Department Code:</label>
                                        <input type="text" id="edit_departmentcode" name="department_code" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_departmentname" class="form-label">Department Name:</label>
                                        <input type="text" id="edit_departmentname" name="department_name" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

        
        </div>
    </div>

    <!-- Custom JS for Departments -->
    <script src="../js/departments.js"></script> 

</body>
</html>


