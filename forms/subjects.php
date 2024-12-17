
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

                    <h2>Add New Subjects</h2>
                    <form id="addSubjectsForm" method="POST" action="../api/subjects.php">
                        <div class="mb-3">
                            <label for="subject_code">Subject Code:</label>
                            <input type="text" id="subject_code" name="subject_code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject_name">Subject Name:</label>
                            <input type="text" id="subject_name" name="subject_name" class="form-control" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="schedule_id">Schedule:</label>
                            <select id="schedule_id" name="schedule_id" class="form-control" required>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <h2>Subjects Management</h2>
                    <table id="subjectsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Subject Code </th>
                                <th>Subject Name </th>
                                <th>Schedule Time </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Subject</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editSubjectForm">
                                <input type="hidden" id="original_subjectcode" name="original_subject_code"> <!-- Hidden field for student ID -->
                                    <div class="mb-3">
                                        <label for="edit_subcode" class="form-label">Subject Code:</label>
                                        <input type="text" class="form-control" id="edit_subcode" name="subject_code" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_subname" class="form-label">Subject Name:</label>
                                        <input type="text" class="form-control" id="edit_subname" name="subject_name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_subj_time" class="form-label">Schedule:</label>
                                        <select class="form-control" id="edit_subj_time" name="schedule_id" required>
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
                <script src="../js/subjects.js"></script> 
        </div>
    </div>



    
    
</body>
</html>


