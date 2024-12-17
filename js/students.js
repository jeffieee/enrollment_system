document.addEventListener('DOMContentLoaded', function() {

    // Populate the course dropdown for both Add and Edit modals
    fetch('../fetch/fetch_courses.php')
        .then(response => response.json())
        .then(data => {
            if (data && Array.isArray(data)) {
                const courseSelect = document.getElementById('course_id');  
                const editCourseSelect = document.getElementById('edit_course_name'); 

                data.forEach(course => {
                    const courseOption = document.createElement('option');
                    courseOption.value = course.course_id;
                    courseOption.textContent = course.course_name;
                    courseSelect.appendChild(courseOption);

                    const editCourseOption = document.createElement('option');
                    editCourseOption.value = course.course_id;
                    editCourseOption.textContent = course.course_name;
                    editCourseSelect.appendChild(editCourseOption);
                });
            } else {
                console.error('Invalid data format for courses:', data);
            }
        })
        .catch(error => console.error('Error fetching courses:', error));

    // Initialize DataTable
    const studentTable = $('#studentsTable').DataTable({
        "processing": true,
        "serverSide": false,
        "pageLength": 5,
        "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
        "ajax": {
            "url": "http://localhost/enrollment_app/api/students.php?action=list",
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "student_id" },
            { "data": "lastname" },
            { "data": "firstname" },
            { "data": "birthdate" },
            { "data": "course_name" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" 
                                data-id="${row.student_id}" 
                                data-lastname="${row.lastname}" 
                                data-firstname="${row.firstname}" 
                                data-birthdate="${row.birthdate}" 
                                data-course_name="${row.course_name}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" 
                                data-id="${row.student_id}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Handle Edit Button Click
    $('#studentsTable').on('click', '.edit-btn', function() {
        const studentId = $(this).data('id');
        const lastname = $(this).data('lastname');
        const firstname = $(this).data('firstname');
        const birthdate = $(this).data('birthdate');
        const courseName = $(this).data('course_name');
       
        

        // Populate the modal with the student's data
        $('#edit_student_id').val(studentId);
        $('#edit_lastname').val(lastname);
        $('#edit_firstname').val(firstname);
        $('#edit_birthdate').val(birthdate);

        

        // Get the course_id from the API using course_name
        fetch(`../fetch/fetch_courses.php?course_name=${encodeURIComponent(courseName)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    const courseId = data.course_id;
                    $('#edit_course_name').val(courseId);
                } else {
                    console.error('Error fetching course ID:', data.message || 'Unknown error');
                }
            })
            .catch(error => console.error('Fetch error:', error));

        // Show the edit modal
        $('#editModal').modal('show');
    });

    // Handle the Edit Form Submission
    document.getElementById('editStudentForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        const formData = new FormData(this);
        
        fetch('../api/students.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.success) {
                alert(data.message);
                studentTable.ajax.reload(null, false); 
                $('#editModal').modal('hide');
            } else {
                alert(data.message || 'Update failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

    // Handle Add Form Submission
    document.getElementById('addStudentForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        const formData = new FormData(this);

        fetch('../api/students.php?action=add', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.success) {
                alert(data.message);
                studentTable.ajax.reload(null, false); 
                this.reset(); 
            } else {
                alert(data.message || 'Add failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

    // Handle Delete Button Click
    $('#studentsTable').on('click', '.delete-btn', function() {
        const studentId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this student?')) {
            fetch(`../api/students.php?action=delete&id=${studentId}`, {
               
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ student_id: studentId })
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    alert(data.message);
                    studentTable.ajax.reload(null, false); 
                } else {
                    alert(data.message || 'Delete failed');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
