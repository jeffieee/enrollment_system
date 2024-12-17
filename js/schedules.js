document.addEventListener('DOMContentLoaded', function() {


    // Initialize DataTable
    const schedulesTable = $('#schedulesTable').DataTable({
        "processing": true, 
        "serverSide": false, 
        "paging": true,      
        "searching": true,   
        "pageLength": 5,
        "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
        "ajax": {
            "url": "http://localhost/enrollment_app/api/schedules.php?action=list",
            "type": "GET",
            "dataSrc": "data"  
        },
        "columns": [
            { "data": "time" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" 
                                data-time="${row.time}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" 
                                data-time="${row.time}">Delete</button>`;
                }
            }
        ]
    });

    // Handle Edit Button Click
    $('#schedulesTable').on('click', '.edit-btn', function() {
        const time = $(this).data('time');
        const [startTime, endTime] = time.split(' - '); // Split the "08:00 AM - 10:00 AM" into start and end time

        $('#edit_start_time').val(convertTo24Hour(startTime)); // Convert to 24-hour format for <input type="time">
        $('#edit_end_time').val(convertTo24Hour(endTime));
        $('#original_timesched').val(time); // Save the original schedule time

        $('#editModal').modal('show');
    });

    // Handle the Edit Form Submission
    document.getElementById('editScheduleForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        const formData = new FormData(this);

        fetch('../api/schedules.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.success) {
                alert(data.message);
                schedulesTable.ajax.reload(null, false); 
                $('#editModal').modal('hide');
            } else {
                alert(data.message || 'Update failed');
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => submitButton.disabled = false); 
    });
    //ADD
    document.getElementById('addScheduleForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('../api/schedules.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                $('#schedulesTable').DataTable().ajax.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Handle Delete Button Click
    $('#schedulesTable').on('click', '.delete-btn', function() {
        const time = $(this).data('time');
        if (confirm(`Are you sure you want to delete the schedule: ${time}?`)) {
            fetch(`../api/schedules.php?action=delete&time=${encodeURIComponent(time)}`, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    schedulesTable.ajax.reload(null, false);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    // Convert 12-hour time to 24-hour time
    function convertTo24Hour(time) {
        const [hour, minute] = time.match(/\d+/g);
        const ampm = time.includes('PM') ? 'PM' : 'AM';
        let hours = parseInt(hour, 10);
        if (ampm === 'PM' && hours < 12) hours += 12;
        if (ampm === 'AM' && hours === 12) hours = 0;
        return `${String(hours).padStart(2, '0')}:${minute}`;
    }



 
});
