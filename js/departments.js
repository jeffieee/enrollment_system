document.addEventListener('DOMContentLoaded', function() {

    // Initialize DataTable
    const departmentsTable = $('#departmentsTable').DataTable({
        "processing": true,
        "serverSide": false,
        "pageLength": 5,
        "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
        "ajax": {
            "url": "http://localhost/enrollment_app/api/departments.php?action=list",
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "department_code" },
            { "data": "department_name" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" 
                                data-departmentcode="${row.department_code}" 
                                data-departmentname="${row.department_name}" >Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" 
                                data-departmentcode="${row.department_code}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Handle Edit Button Click
    $('#departmentsTable').on('click', '.edit-btn', function() {
        const departmentcode = $(this).data('departmentcode');
        const departmentname = $(this).data('departmentname');
    
        $('#edit_departmentcode').val(departmentcode);
        $('#edit_departmentname').val(departmentname);
        $('#original_departmentcode').val(departmentcode);
    
        $('#editModal').modal('show');
    });

    // Handle the Edit Form Submission
    document.getElementById('editDepartmentForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        const formData = new FormData(this);

        fetch('../api/departments.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.success) {
                alert(data.message);
                departmentsTable.ajax.reload(null, false); 
                $('#editModal').modal('hide');
            } else {
                alert(data.message || 'Update failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

    // Handle Add Form Submission
    document.getElementById('addDepartmentForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        const formData = new FormData(this);

        fetch('../api/departments.php?action=add', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.success) {
                alert(data.message);
                departmentsTable.ajax.reload(null, false); 
                this.reset(); 
            } else {
                alert(data.message || 'Add failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

    // Handle Delete Button Click
    $('#departmentsTable').on('click', '.delete-btn', function() {
        const departmentCode = $(this).data('departmentcode');

        if (confirm(`Are you sure you want to delete the department with code "${departmentCode}"?`)) {
            fetch(`../api/departments.php?action=delete`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ department_code: departmentCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    alert(data.message);
                    departmentsTable.ajax.reload(null, false); 
                } else {
                    alert(data.message || 'Delete failed');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

});
