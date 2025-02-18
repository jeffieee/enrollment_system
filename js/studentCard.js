fetch('fetch/totalStudents.php')
  .then(response => response.json())
  .then(totalStudents => {
    // Update the card container with the total number of students
    const cardContainer = document.getElementById('total-students');
    cardContainer.textContent = `Total Students: ${totalStudents}`;
  })
  .catch(error => {
    console.error('Error fetching total students:', error);
  });


  fetch('fetch/totalTeachers.php')
  .then(response => response.json())
  .then(totalTeachers => {
    // Update the card container with the total number of students
    const cardContainer = document.getElementById('total-teachers');
    cardContainer.textContent = `Total Teacher: ${totalTeachers}`;
  })
  .catch(error => {
    console.error('Error fetching total teacher:', error);
  });
  


  fetch('fetch/totalCourses.php')
  .then(response => response.json())
  .then(totalCourses => {
    // Update the card container with the total number of students
    const cardContainer = document.getElementById('total-courses');
    cardContainer.textContent = `Total Courses: ${totalCourses}`;
  })
  .catch(error => {
    console.error('Error fetching total courses:', error);
  });
  
  fetch('fetch/totalSubjects.php')
  .then(response => response.json())
  .then(totalSubjects => {
    // Update the card container with the total number of students
    const cardContainer = document.getElementById('total-subjects');
    cardContainer.textContent = `Total Subjects: ${totalSubjects}`;
  })
  .catch(error => {
    console.error('Error fetching total subjects:', error);
  });
  