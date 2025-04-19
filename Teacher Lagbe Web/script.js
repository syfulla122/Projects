// Function to add a new teacher
function addTeacher(event) {
  event.preventDefault();  // Prevent the form from submitting the default way

  const teacherData = new FormData();
  teacherData.append('name', document.getElementById('teacherName').value);
  teacherData.append('qualification', document.getElementById('qualification').value);
  teacherData.append('hourly_rate', document.getElementById('hourlyRate').value);
  teacherData.append('experience', document.getElementById('experience').value);
  teacherData.append('subject', document.getElementById('subject').value);
  teacherData.append('class', document.getElementById('class').value);

  // Convert the image to Base64 to store URL in database
  const imageFile = document.getElementById('teacherImage').files[0];
  const reader = new FileReader();

  reader.onload = function () {
      teacherData.append('image_url', reader.result); // Append image as Base64

      // Send data to the server using Fetch API
      fetch('add_teacher.php', {
          method: 'POST',
          body: teacherData
      })
      .then(response => {
          if (!response.ok) {
              throw new Error('Error adding teacher: ' + response.statusText);
          }
          return response.text();
      })
      .then(data => {
          alert(data); // Show success message
          fetchTeachers(); // Refresh the teacher list after adding
          clearForm(); // Clear the form fields after submission
      })
      .catch(error => {
          console.error('Error adding teacher:', error);
          alert('An error occurred while adding the teacher. Please try again.');
      });
  };

  reader.readAsDataURL(imageFile); // Convert image file to Base64 string
}




// Function to fetch all teachers and display them
function fetchTeachers() {
    fetch('fetch_teacher.php')  // Fetch all teachers from the database
        .then(response => response.json())
        .then(teachers => {
            const teacherList = document.getElementById('teacherList');
            teacherList.innerHTML = ''; // Clear previous teacher list
  
            // Check if the returned data has teachers
            if (teachers.length > 0) {
                teachers.forEach(teacher => {
                    // Build HTML for each teacher, excluding dollar sign from hourly rate
                    teacherList.innerHTML += `
                        <div class="teacher-card">
                            <h3>${teacher.name || 'Name not available'}</h3>
                            <p>Qualification: ${teacher.qualification || 'N/A'}</p>
                            <p>Hourly Rate: ${teacher.hourly_rate || 'N/A'}</p> <!-- Remove dollar sign -->
                            <p>Experience: ${teacher.experience || 'N/A'} years</p>
                            <p>Subject: ${teacher.subject || 'N/A'}</p>
                            <p>Class: ${teacher.class || 'N/A'}</p>
                            <p>Teacher ID: ${teacher.teacher_id || 'N/A'}</p> <!-- Display teacher_id -->
                        </div>
                    `;
                });
            } else {
                teacherList.innerHTML = '<p>No teachers found.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching teachers:', error);
            alert('An error occurred while fetching teachers. Please try again.');
        });
  }
  
  
  
  

// Function to search teachers based on the search query
function searchTeacher() {
    const searchTerm = document.getElementById('searchBar').value.toLowerCase();  // Get search term and convert to lowercase

    if (!searchTerm) {  // Handle empty search term
        alert("Please enter a search term.");
        return;
    }

    const url = 'search_teacher.php?query=' + encodeURIComponent(searchTerm);

    fetch(url)  // Fetch search results from the server
        .then(response => {
            if (!response.ok) {
                console.error('Error:', response.statusText);
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const teacherList = document.getElementById('teacherList');
            teacherList.innerHTML = '';  // Clear previous search results

            console.log('Search results:', data);  // Log the results for debugging

            if (data.length === 0) {
                teacherList.innerHTML = '<p>No teachers found matching your search.</p>';
            } else {
                data.forEach(teacher => {
                    teacherList.innerHTML += `
                        <div class="teacher-card">
                            <h3>${teacher.teacher_name}</h3>
                            <p>Qualification: ${teacher.qualification}</p>
                            <p>Hourly Rate: ${teacher.hourly_rate}</p>
                            <p>Experience: ${teacher.experience}</p>
                            <p>Subject: ${teacher.subject}</p>
                            <p>Class: ${teacher.class}</p>
                        </div>
                    `;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);  // Log the detailed error in the console
            alert('An error occurred while searching teachers. Please try again.');
        });
}




// Function to clear the form after adding a teacher
function clearForm() {
  document.getElementById('teacherName').value = '';
  document.getElementById('qualification').value = '';
  document.getElementById('hourlyRate').value = '';
  document.getElementById('experience').value = '';
  document.getElementById('subject').value = '';
  document.getElementById('class').value = '';
  document.getElementById('teacherImage').value = '';  // Clear image field
}

// Fetch teachers when the page loads
document.addEventListener('DOMContentLoaded', fetchTeachers);

// Optional: You can also attach `searchTeacher()` to the search bar if you want live search as well
document.getElementById('searchBar').addEventListener('input', searchTeacher);


