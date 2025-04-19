document.getElementById('teacher').addEventListener('change', () => {
    const selectedTeacherId = document.getElementById('teacher').value;
    document.getElementById('selectedTeacherId').value = selectedTeacherId;
  
    const selectedTeacherOption = document.getElementById('teacher').options[document.getElementById('teacher').selectedIndex];
    const selectedTeacherName = selectedTeacherOption.text;
  
    // Display the selected teacher's name in the input field
    document.getElementById('selected-teacher').value = selectedTeacherName;
  });
  
  function fetchTeachers() {
    fetch('/api/teachers')
      .then(response => response.json())
      .then(data => {
        const teacherSelect = document.getElementById('teacher');
        teacherSelect.innerHTML = '';
  
        data.forEach(teacher => {
          const option = document.createElement('option');
          option.value = teacher.id;
          option.text = teacher.name;
          teacherSelect.appendChild(option);
        });
      })
      .catch(error => {
        console.error('Error fetching teachers:', error);
        alert('Error fetching teachers. Please try again later.');
      });
  }
  
  function filterTeachers(event) {
    const searchInput = event.target.value;
    const teacherSelect = document.getElementById('teacher');
    const teacherOptions = teacherSelect.options;
  
    for (let i = 0; i < teacherOptions.length; i++) {
      const option = teacherOptions[i];
      if (option.text.toLowerCase().includes(searchInput.toLowerCase())) {
        option.style.display = 'block';
      } else {
        option.style.display = 'none';
      }
    }
  }
  
  // Initial fetch of teachers
  fetchTeachers();
  
  document.getElementById('teacherSearch').addEventListener('input', filterTeachers);