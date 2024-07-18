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

document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var email = document.getElementById('floatingInput');
    var password = document.getElementById('floatingPassword');

    var emailValid = email.checkValidity();
    var passwordValid = password.checkValidity();

    if (emailValid && passwordValid) {
        email.classList.remove('is-invalid');
        password.classList.remove('is-invalid');
        this.submit();
    } else {
        if (!emailValid) {
            email.classList.add('is-invalid');
        } else {
            email.classList.remove('is-invalid');
        }

        if (!passwordValid) {
            password.classList.add('is-invalid');
        } else {
            password.classList.remove('is-invalid');
        }
    }
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


