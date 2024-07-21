document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#floatingPassword');
    const toggleVisibility = function(field, toggle) {
        // Toggle the type attribute for the field
        const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
        field.setAttribute('type', type);
        // Toggle the eye icon
        toggle.querySelector('i').classList.toggle('fa-eye');
        toggle.querySelector('i').classList.toggle('fa-eye-slash');
    };

    togglePassword.addEventListener('click', function() {
        toggleVisibility(passwordField, togglePassword);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('floatingInput');
    const passwordInput = document.getElementById('floatingPassword');
    const submitButton = document.querySelector('#login');

    let emailTouched = false;
    let passwordTouched = false;

    const validateEmail = () => {
        const emailValid = emailInput.checkValidity();
        if (emailTouched) {
            emailInput.classList.toggle('is-invalid', !emailValid);
        }
        return emailValid;
    };

    const validatePassword = () => {
        const passwordValid = passwordInput.checkValidity();
        if (passwordTouched) {
            passwordInput.classList.toggle('is-invalid', !passwordValid);
        }
        return passwordValid;
    };

    const validateForm = () => {
        const emailValid = validateEmail();
        const passwordValid = validatePassword();
        // Enable or disable button based on form validity
        submitButton.disabled = !(emailValid && passwordValid);
    };

    emailInput.addEventListener('input', () => {
        emailTouched = true;
        validateForm();
    });

    passwordInput.addEventListener('input', () => {
        passwordTouched = true;
        validateForm();
    });

    loginForm.addEventListener('submit', function(event) {

        const emailValid = validateEmail();
        const passwordValid = validatePassword();

        if (emailValid && passwordValid) {
            this.submit();
        } else {
            if (!emailTouched) {
                emailTouched = true;
                validateEmail();
            }

            if (!passwordTouched) {
                passwordTouched = true;
                validatePassword();
            }
        }
    });

    // Initial validation to ensure the button state is correct on page load
    validateForm();
});





let timer = document.getElementById('timer');
        let btn = document.getElementById('btn');
        let timeLeft = 180; // 3 minutes in seconds
        let timerInterval;

        function updateTimer() {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            // Format the time as MM:SS
            timer.innerHTML = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft > 0) {
                timeLeft--;
            } else {
                clearInterval(timerInterval);
                timer.innerHTML = "Time's up!";
                btn.disabled = false;
            }
        }

        function startTimer() {
            clearInterval(timerInterval);
            timeLeft = 180; // Reset the timer to 3 minutes
            timerInterval = setInterval(updateTimer, 1000);
            updateTimer(); // Initial call to display the timer immediately
            btn.disabled = true;
        }

        function resetTimer() {
            startTimer();
        }

        // Start the timer when the page loads
        window.onload = startTimer;


