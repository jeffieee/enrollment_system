
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

                <h2>Add New Schedules</h2>
                <form id="addScheduleForm" method="POST" action="../api/schedules.php">
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time:</label>
                        <input type="time" id="start_time" name="start_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time:</label>
                        <input type="time" id="end_time" name="end_time" required>
                    </div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <h2 >Schedules Management</h2>
                <table id="schedulesTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Time Schedule</th>
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
                            <form id="editScheduleForm">
                                <input type="hidden" id="original_timesched" name="original_time_sched">
                                <div class="mb-3">
                                    <label for="edit_start_time" class="form-label">Start Time:</label>
                                    <input type="time" id="edit_start_time" name="start_time" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_end_time" class="form-label">End Time:</label>
                                    <input type="time" id="edit_end_time" name="end_time" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>

                            </div>
                        </div>
                    </div>
                </div>
                <script src="../js/schedules.js"></script> 
            </div>
        </div>
    </div>

</body>
</html>


