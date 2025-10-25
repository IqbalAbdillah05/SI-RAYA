document.addEventListener('DOMContentLoaded', function() {
    // Get all role radio buttons
    const roleInputs = document.querySelectorAll('input[name="role"]');
    
    // Get all form sections
    const adminForm = document.getElementById('adminForm');
    const dosenForm = document.getElementById('dosenForm');
    const mahasiswaForm = document.getElementById('mahasiswaForm');
    
    // Add change event listener to each radio button
    roleInputs.forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Hide all forms first
            adminForm.style.display = 'none';
            dosenForm.style.display = 'none';
            mahasiswaForm.style.display = 'none';
            
            // Show the selected form
            if (this.value === 'admin') {
                adminForm.style.display = 'block';
            } else if (this.value === 'dosen') {
                dosenForm.style.display = 'block';
            } else if (this.value === 'mahasiswa') {
                mahasiswaForm.style.display = 'block';
            }
        });
    });
});