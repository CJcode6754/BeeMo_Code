document.addEventListener('DOMContentLoaded', function() {
    const resetPwForm = document.getElementById('ResetpwForm');
    const passwordInput = document.getElementById('floatingPassword2');
    const confirmPasswordInput = document.getElementById('floatingConfirmPassword2');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

    // Show/Hide Password
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fa-solid fa-eye-slash"></i>' : '<i class="fa-solid fa-eye"></i>';
    });

    // Show/Hide Confirm Password
    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fa-solid fa-eye-slash"></i>' : '<i class="fa-solid fa-eye"></i>';
    });

    // Form Validation
    resetPwForm.addEventListener('submit', function(event) {
        event.preventDefault();
        let isValid = true;

        // Check if password is valid
        if (passwordInput.value.trim() === '' || passwordInput.value.length < 8 || passwordInput.value.length > 32) {
            passwordInput.classList.add('is-invalid');
            isValid = false;
        } else {
            passwordInput.classList.remove('is-invalid');
        }

        // Check if passwords match
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.classList.add('is-invalid');
            isValid = false;
        } else {
            confirmPasswordInput.classList.remove('is-invalid');
        }

        if (isValid) {
            // Submit the form if valid
            resetPwForm.submit();
        }
    });

    // Remove invalid class on input change
    passwordInput.addEventListener('input', function() {
        if (passwordInput.classList.contains('is-invalid')) {
            passwordInput.classList.remove('is-invalid');
        }
    });

    confirmPasswordInput.addEventListener('input', function() {
        if (confirmPasswordInput.classList.contains('is-invalid')) {
            confirmPasswordInput.classList.remove('is-invalid');
        }
    });
});
