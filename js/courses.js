document.addEventListener('DOMContentLoaded', function() {

    // Initialize DataTable
    const coursesTable = $('#coursesTable').DataTable({
        "processing": true,
        "serverSide": false,
        "pageLength": 5,
        "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
        "ajax": {
            "url": "http://localhost/enrollment_app/api/courses.php?action=list",
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "course_code" },
            { "data": "course_name" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" 
                                data-coursecode="${row.course_code}" 
                                data-coursename="${row.course_name}" >Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" 
                                data-coursecode="${row.course_code}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Handle Edit Button Click
    $('#coursesTable').on('click', '.edit-btn', function() {
        const coursecode = $(this).data('coursecode');
        const coursename = $(this).data('coursename');

        console.log(coursecode);
    
        $('#edit_coursecode').val(coursecode);
        $('#edit_coursename').val(coursename);
        $('#original_coursecode').val(coursecode);
    
        $('#editModal').modal('show');
    });

    // Handle the Edit Form Submission
    document.getElementById('editCourseForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        const formData = new FormData(this);

        fetch('../api/courses.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.success) {
                alert(data.message);
                coursesTable.ajax.reload(null, false); 
                $('#editModal').modal('hide');
            } else {
                alert(data.message || 'Update failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

    // Handle Add Form Submission
    document.getElementById('addCoursesForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        const formData = new FormData(this);

        fetch('../api/courses.php?action=add', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.success) {
                alert(data.message);
                coursesTable.ajax.reload(null, false); 
                this.reset(); 
            } else {
                alert(data.message || 'Add failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

    // Handle Delete Button Click
    $('#coursesTable').on('click', '.delete-btn', function() {
        const courseCode = $(this).data('coursecode');

        if (confirm(`Are you sure you want to delete the course with code "${courseCode}"?`)) {
            fetch(`../api/courses.php?action=delete`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ course_code: courseCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    alert(data.message);
                    coursesTable.ajax.reload(null, false); 
                } else {
                    alert(data.message || 'Delete failed');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

});
