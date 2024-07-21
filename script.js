document.addEventListener('DOMContentLoaded', function() {
    const workerForm = document.getElementById('workerForm');
    const fullName = document.getElementById('fullName');
    const email = document.getElementById('email');
    const phoneNumber = document.getElementById('phoneNumber');
    const password = document.getElementById('password');
    const submitButton = document.getElementById('btn');

    const validateForm = () => {
        const fullNameValid = fullName.checkValidity();
        const emailValid = email.checkValidity();
        const phoneNumberValid = phoneNumber.checkValidity();
        const passwordValid = password.checkValidity();

        if (fullNameValid && emailValid && phoneNumberValid && passwordValid) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    };

    fullName.addEventListener('input', () => {
        if (fullName.checkValidity()) {
            fullName.classList.remove('is-invalid');
            fullName.classList.add('is-valid');
        } else {
            fullName.classList.remove('is-valid');
            fullName.classList.add('is-invalid');
        }
        validateForm();
    });

    email.addEventListener('input', () => {
        if (email.checkValidity()) {
            email.classList.remove('is-invalid');
            email.classList.add('is-valid');
        } else {
            email.classList.remove('is-valid');
            email.classList.add('is-invalid');
        }
        validateForm();
    });

    phoneNumber.addEventListener('input', () => {
        if (phoneNumber.checkValidity()) {
            phoneNumber.classList.remove('is-invalid');
            phoneNumber.classList.add('is-valid');
        } else {
            phoneNumber.classList.remove('is-valid');
            phoneNumber.classList.add('is-invalid');
        }
        validateForm();
    });

    password.addEventListener('input', () => {
        if (password.checkValidity()) {
            password.classList.remove('is-invalid');
            password.classList.add('is-valid');
        } else {
            password.classList.remove('is-valid');
            password.classList.add('is-invalid');
        }
        validateForm();
    });

    workerForm.addEventListener('submit', function(event) {
        if (!workerForm.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        workerForm.classList.add('was-validated');
    }, false);
});

// <--FORGOT PASSWORD JS-->
document.addEventListener('DOMContentLoaded', function() {
    const forgotForm = document.getElementById('forgotForm');
    const emailInput = document.getElementById('floatingInput1');
    emailInput.addEventListener('input', function() {
        if (emailInput.validity.valid) {
            emailInput.classList.remove('is-invalid');
        } else {
            emailInput.classList.add('is-invalid');
        }
    });
});

function fetchData() {
    fetch('fetch_data.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error fetching data:', data.error);
                return;
            }

            // Convert weight from grams to kilograms
            const weightInKg = (data.weight / 1000).toFixed(2);

            // Update the elements with new data
            document.querySelector('.temp-degree').textContent = `${data.temperature} °C`;
            document.querySelector('.humid-percent').textContent = `${data.humidity}%`;
            document.querySelector('.weight-value').textContent = `${weightInKg} kg`;
        })
        .catch(error => console.error('Error fetching data:', error));
}

setInterval(fetchData, 10000); // Refresh data every 5 seconds
window.onload = fetchData; // Fetch data on initial load
