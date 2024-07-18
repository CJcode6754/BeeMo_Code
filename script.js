// <--ADD WORKER JS-->
document.getElementById('workerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var fullName = document.getElementById('fullName');
    var email = document.getElementById('email');
    var phoneNumber = document.getElementById('phoneNumber');
    var password = document.getElementById('password');

    var fullNameValid = fullName.checkValidity();
    var emailValid = email.checkValidity();
    var phoneNumberValid = phoneNumber.checkValidity();
    var passwordValid = password.checkValidity();

    if (fullNameValid && emailValid && phoneNumberValid && passwordValid) {
        fullName.classList.remove('is-invalid');
        email.classList.remove('is-invalid');
        phoneNumber.classList.remove('is-invalid');
        password.classList.remove('is-invalid');
        this.submit();
    } else {
        if (!fullNameValid) {
            fullName.classList.add('is-invalid');
        } else {
            fullName.classList.remove('is-invalid');
        }

        if (!emailValid) {
            email.classList.add('is-invalid');
        } else {
            email.classList.remove('is-invalid');
        }

        if (!phoneNumberValid) {
            phoneNumber.classList.add('is-invalid');
        } else {
            phoneNumber.classList.remove('is-invalid');
        }

        if (!passwordValid) {
            password.classList.add('is-invalid');
        } else {
            password.classList.remove('is-invalid');
        }
    }
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
    forgotForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if (emailInput.validity.valid) {
            // Reset any previous invalid state
            emailInput.classList.remove('is-invalid');
            // Proceed with sending recovery link (simulated here)
            alert('Sending recovery link to ' + emailInput.value);
            // Optionally, redirect to index.html after sending
            window.location.href = 'resetpw2.html';
        } else {
            emailInput.classList.add('is-invalid');
        }
    });
});


