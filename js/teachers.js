document.addEventListener('DOMContentLoaded', function() {
    
    // Reusable function to populate dropdowns
    function populateDropdown(fetchUrl, selectId1, selectId2, valueKey, textKey) {
        fetch(fetchUrl)
            .then(response => response.json())
            .then(data => {
                if (data && Array.isArray(data)) {
                    const select1 = document.getElementById(selectId1);  
                    const select2 = document.getElementById(selectId2); 

                    data.forEach(item => {
                        const option1 = document.createElement('option');
                        option1.value = item[valueKey];
                        option1.textContent = item[textKey];
                        select1.appendChild(option1);

                        const option2 = document.createElement('option');
                        option2.value = item[valueKey];
                        option2.textContent = item[textKey];
                        select2.appendChild(option2);
                    });
                } else {
                    console.error(`Invalid data format for ${fetchUrl}:`, data);
                }
            })
            .catch(error => console.error(`Error fetching data from ${fetchUrl}:`, error));
    }

    // Populate the course and department dropdowns
    populateDropdown('../fetch/fetch_subjects.php', 'subject_id', 'edit_subj_name', 'subject_id', 'subject_name');
    populateDropdown('../fetch/fetch_department.php', 'department_id', 'edit_dept_code', 'department_id', 'department_code');

    // Initialize DataTable
    const teachersTable = $('#teachersTable').DataTable({
        "processing": true,
        "serverSide": false,
        "pageLength": 5,
        "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
        "ajax": {
            "url": "http://localhost/enrollment_app/api/teachers.php?action=list",
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "teacher_name" },
            { "data": "subject_name" },
            { "data": "department_code" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" 
                                data-teachername="${row.teacher_name}" 
                                data-subjectname="${row.subject_name}" 
                                data-departmentcode="${row.department_code}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" 
                                data-teacher="${row.teacher_name}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Handle Edit Button Click
    $('#teachersTable').on('click', '.edit-btn', async function() {
        const teachername = $(this).data('teachername');
        const subjectname = $(this).data('subjectname');
        const department_code = $(this).data('departmentcode');

        $('#edit_teachername').val(teachername);
        $('#original_teachername').val(teachername);

        try {
            const subjectResponse = await fetch(`../fetch/fetch_subjects.php?subject_name=${encodeURIComponent(subjectname)}`);
            const subjectData = await subjectResponse.json();
            if (subjectData && subjectData.success) {
                $('#edit_subj_name').val(subjectData.subject_id);
            }

            const departmentResponse = await fetch(`../fetch/fetch_department.php?department_code=${encodeURIComponent(department_code)}`);
            const departmentData = await departmentResponse.json();
            if (departmentData && departmentData.success) {
                $('#edit_dept_code').val(departmentData.department_id);
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }

        $('#editModal').modal('show');
    });

    // Handle the Edit Form Submission
    document.getElementById('editTeacherForm').addEventListener('submit', function(event) {
        event.preventDefault();
    
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 
    
        const formData = new FormData(this);
    
        fetch('../api/teachers.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.success) {
                alert(data.message);
                teachersTable.ajax.reload(null, false); 
                $('#editModal').modal('hide');
            } else {
                alert(data.message || 'Update failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

    // Handle Add Form Submission
    document.getElementById('addTeacherForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        const formData = new FormData(this);

        fetch('../api/teachers.php?action=add', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                teachersTable.ajax.reload(null, false);
                this.reset(); 
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

     // Handle Delete Button Click
     $('#teachersTable').on('click', '.delete-btn', function() {
        const teacher = $(this).data('teacher');
        
        if (confirm('Are you sure you want to delete this teacher?')) {
            fetch(`../api/teachers.php?action=delete&id=${teacher}`, {
               
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ teacher_name: teacher })
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    alert(data.message);
                    teachersTable.ajax.reload(null, false); 
                } else {
                    alert(data.message || 'Delete failed');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
    
});
