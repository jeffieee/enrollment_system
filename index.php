
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
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ms-3" href="index.html">Enrollment Management System</a>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                 <a href="index.php">Dashboard</a>
                <a href="forms/students.php">Students Management</a>
                <a href="forms/subjects.php">Subject Management</a>
                <a href="forms/teachers.php">Teacher Management</a>
                <a href="forms/courses.php">Course Management</a>
                <a href="forms/departments.php">Department Management</a>
                <a href="forms/schedules.php">Schedule Management</a>

                <div style="position: relative; top: 345px; left: 450px;" id="total-students"></div>
                <div style="position: relative; top: 310px; left: 750px;" id="total-teachers"></div>
                <div style="position: relative; top: 275px; left: 1050px;" id="total-courses"></div>
                <div style="position: relative; top: 237px; left: 1350px;" id="total-subjects"></div>
                

                <div style="position: relative; top: -170px; left: 420px;" id="bar-graph">
                <!-- Content will be loaded dynamically here -->
                </div>

                <div style="position: relative; top: -490px; left: 1070px;" id="horizontal-bar-graph">
                <!-- Content will be loaded dynamically here -->
                </div>

             

                <div style="position: relative; top: -1160px; left: 440px;" id="line-graph">
                <!-- Content will be loaded dynamically here -->
                </div>
           
        

           
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.js"></script>

    <script type="text/javascript" src="js/barGraph.js"></script>
    <script type="text/javascript" src="js/horizontalBarGraph.js"></script>
    <script type="text/javascript" src="js/studentCard.js"></script>
    <!-- <script type="text/javascript" src="js/donutGraph.js"></script> -->
    <script type="text/javascript" src="js/lineGraph.js"></script>


  

  


    
    
</body>
</html>


