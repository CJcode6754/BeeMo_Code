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