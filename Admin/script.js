window.addEventListener('DOMContentLoaded', (event) => {
    const form = document.getElementById('registrationForm');
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        registerStudent();
    });
});

function registerStudent() {
    const form = document.getElementById('registrationForm');
    const formData = new FormData(form);

    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Student registration was successful');
            form.reset();
        } else {
            alert(data.error);
        }
    })
    .catch(error => {
        console.error(error);
        alert('An error occurred during registration');
    });
}