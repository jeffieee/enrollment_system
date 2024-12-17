document.addEventListener('DOMContentLoaded', function() {

    // Populate the course dropdown for both Add and Edit modals
    fetch('../fetch/fetch_schedules.php')
        .then(response => response.json())
        .then(data => {
            if (data && Array.isArray(data)) {
                const schedSelect = document.getElementById('schedule_id');  
                const editSchedSelect = document.getElementById('edit_subj_time'); 

                data.forEach(sched => {
                    const schedOption = document.createElement('option');
                    schedOption.value = sched.schedule_id;
                    schedOption.textContent = sched.time;
                    schedSelect.appendChild(schedOption);

                    const editSchedOption = document.createElement('option');
                    editSchedOption.value = sched.schedule_id;
                    editSchedOption.textContent = sched.time;
                    editSchedSelect.appendChild(editSchedOption);
                });
            } else {
                console.error('Invalid data format for courses:', data);
            }
        })
        .catch(error => console.error('Error fetching courses:', error));

    // Initialize DataTable
    const subjectsTable = $('#subjectsTable').DataTable({
        "processing": true,
        "serverSide": false,
        "pageLength": 5,
        "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
        "ajax": {
            "url": "http://localhost/enrollment_app/api/subjects.php?action=list",
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            
            { "data": "subject_code" },
            { "data": "subject_name" },
            { "data": "time" },
            
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" 
                                
                                data-subjectcode="${row.subject_code}" 
                                data-subjectname="${row.subject_name}" 
                                data-time="${row.time}" 
                                >Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" 
                                data-id="${row.subject_code}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Handle Edit Button Click
    $('#subjectsTable').on('click', '.edit-btn', function() {
        

        const subjcode = $(this).data('subjectcode');
        const subjname = $(this).data('subjectname');

        const schedTime = $(this).data('time');

        // Populate the modal with the student's data
        $('#edit_subcode').val(subjcode);
        $('#edit_subname').val(subjname);
        $('#original_subjectcode').val(subjcode);
   
        // Get the course_id from the API using course_name
        fetch(`../fetch/fetch_schedules.php?time=${encodeURIComponent(schedTime)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    const schedId = data.schedule_id;
                    $('#edit_subj_time').val(schedId);
                } else {
                    console.error('Error fetching schedule ID:', data.message || 'Unknown error');
                }
            })
            .catch(error => console.error('Fetch error:', error));

        // Show the edit modal
        $('#editModal').modal('show');
    });

    // Handle the Edit Form Submission
    document.getElementById('editSubjectForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        const formData = new FormData(this);
        
        fetch('../api/subjects.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.success) {
                alert(data.message);
                subjectsTable.ajax.reload(null, false); 
                $('#editModal').modal('hide');
            } else {
                alert(data.message || 'Update failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

    // Handle Add Form Submission
    document.getElementById('addSubjectsForm').addEventListener('submit', function(event) {
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
                subjectsTable.ajax.reload(null, false); 
                this.reset(); 
            } else {
                alert(data.message || 'Add failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });

    // Handle Delete Button Click
    $('#subjectsTable').on('click', '.delete-btn', function() {
        const subjectCode = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this subject?')) {
            fetch(`../api/subjects.php?action=delete&id=${subjectCode}`, {
               
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ subject_code: subjectCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    alert(data.message);
                    subjectsTable.ajax.reload(null, false); 
                } else {
                    alert(data.message || 'Delete failed');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
