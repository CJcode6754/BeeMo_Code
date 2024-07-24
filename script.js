// <--ADD WORKER-->
document.addEventListener('DOMContentLoaded', function() {
    const workerForm = document.getElementById('workerForm');
    const fullName = document.getElementById('FullName');
    const email = document.getElementById('Email');
    const phoneNumber = document.getElementById('PhoneNumber');
    const password = document.getElementById('Password');
    const submitButton = document.getElementById('btn');

    const validateForm = () => {
        const fullNameValid = fullName.checkValidity();
        const emailValid = email.checkValidity();
        const phoneNumberValid = /^[0-9]{10,15}$/.test(phoneNumber.value);
        const passwordValid = password.value.trim().length >= 8 && password.value.trim().length <= 32;

        if (fullNameValid && emailValid && phoneNumberValid && passwordValid) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    };

    fullName.addEventListener('input', () => {
        fullNameTouched = true;
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
        emailTouched = true;
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
        phoneNumberTouched = true;
        const mobileNumberPattern = /^[0-9]{11}$/; // Adjust this pattern as needed
        if (!mobileNumberPattern.test(phoneNumber.value)) {
            phoneNumber.classList.remove('is-valid');
            phoneNumber.classList.add('is-invalid');
        } else {
            phoneNumber.classList.remove('is-invalid');
            phoneNumber.classList.add('is-valid');
        }
        validateForm();
    });

    password.addEventListener('input', () => {
        passwordTouched = true;
        const passwordValue = password.value.trim();
        if (passwordValue.length < 8 || passwordValue.length > 32) {
            password.classList.remove('is-valid');
            password.classList.add('is-invalid');
        } else {
            password.classList.remove('is-invalid');
            password.classList.add('is-valid');
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


// <--FETCH DATA TO DATABASE TO SHOW THE PARAMETER DATA-->
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


// <--SIGNUP FORM VALIDATION-->
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#password');
    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPasswordField = document.querySelector('#confirmPassword');
    const registerForm = document.getElementById('registerForm');
    const fullNameInput = document.getElementById('fullName');
    const emailInput = document.getElementById('email');
    const mobileNumberInput = document.getElementById('mobileNumber');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const termsCheckbox = document.getElementById('termsCheckbox');
    const btn = document.getElementById('btn');

    let fullNameTouched = false;
    let emailTouched = false;
    let mobileNumberTouched = false;
    let passwordTouched = false;
    let confirmPasswordTouched = false;
    let termsTouched = false;

    const toggleVisibility = (field, toggle) => {
        const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
        field.setAttribute('type', type);
        toggle.querySelector('i').classList.toggle('fa-eye');
        toggle.querySelector('i').classList.toggle('fa-eye-slash');
    };

    togglePassword.addEventListener('click', function() {
        toggleVisibility(passwordField, togglePassword);
    });

    toggleConfirmPassword.addEventListener('click', function() {
        toggleVisibility(confirmPasswordField, toggleConfirmPassword);
    });

    const validateFullName = () => {
        if (!fullNameInput.checkValidity()) {
            if (fullNameTouched) {
                fullNameInput.classList.add('is-invalid');
            }
        } else {
            fullNameInput.classList.remove('is-invalid');
        }
    };

    const validateEmail = () => {
        if (!emailInput.checkValidity()) {
            if (emailTouched) {
                emailInput.classList.add('is-invalid');
            }
        } else {
            emailInput.classList.remove('is-invalid');
        }
    };

    const validateMobileNumber = () => {
        const mobileNumberPattern = /^[0-9]{11}$/; // Adjust this pattern as needed
        if (!mobileNumberPattern.test(mobileNumberInput.value)) {
            if (mobileNumberTouched) {
                mobileNumberInput.classList.add('is-invalid');
            }
        } else {
            mobileNumberInput.classList.remove('is-invalid');
        }
    };

    const validatePassword = () => {
        const passwordValue = passwordInput.value.trim();
        if (passwordValue.length < 8 || passwordValue.length > 32) {
            if (passwordTouched) {
                passwordInput.classList.add('is-invalid');
            }
        } else {
            passwordInput.classList.remove('is-invalid');
        }
    };

    const validateConfirmPassword = () => {
        if (passwordInput.value !== confirmPasswordInput.value || !confirmPasswordInput.checkValidity()) {
            if (confirmPasswordTouched) {
                confirmPasswordInput.classList.add('is-invalid');
            }
        } else {
            confirmPasswordInput.classList.remove('is-invalid');
        }
    };

    const validateTermsCheckbox = () => {
        if (!termsCheckbox.checked) {
            if (termsTouched) {
                termsCheckbox.classList.add('is-invalid');
            }
        } else {
            termsCheckbox.classList.remove('is-invalid');
        }
    };

    const validateForm = () => {
        validateFullName();
        validateEmail();
        validateMobileNumber();
        validatePassword();
        validateConfirmPassword();
        validateTermsCheckbox();

        // Enable or disable button based on form validity
        if (registerForm.checkValidity() && termsCheckbox.checked) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    };

    // <--Add input event listeners for individual validation functions-->
    fullNameInput.addEventListener('input', () => {
        fullNameTouched = true;
        validateForm();
    });

    emailInput.addEventListener('input', () => {
        emailTouched = true;
        validateForm();
    });

    mobileNumberInput.addEventListener('input', () => {
        mobileNumberTouched = true;
        validateForm();
    });

    passwordInput.addEventListener('input', () => {
        passwordTouched = true;
        validateForm();
    });

    confirmPasswordInput.addEventListener('input', () => {
        confirmPasswordTouched = true;
        validateForm();
    });

    termsCheckbox.addEventListener('change', () => {
        termsTouched = true;
        validateForm();
    });

    // Initial form validation on page load
    validateForm();
});


// <--INDEX (LOGIN PAGE)
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


//<--EMAIL OTP-->
document.addEventListener('DOMContentLoaded', function() {
    // Function to get URL parameter (you might need to adjust this based on your URL structure)
    function getUrlParameter(name) {
        name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    };

    const userEmail = getUrlParameter('email'); // Assuming 'email' is the parameter name

    // Update the email in the confirmation message
    const userEmailSpan = document.getElementById('userEmail');
    if (userEmail) {
        userEmailSpan.textContent = userEmail;
    }

    // Disable the button and start the timer (if needed)
    const resendButton = document.getElementById('btn');
    resendButton.disabled = true;

    const timerElement = document.getElementById('timer');
    let secondsLeft = 180; // Set your desired timer duration in seconds

    function startTimer() {
        const interval = setInterval(function() {
            secondsLeft--;
            timerElement.textContent = secondsLeft + ' seconds';

            if (secondsLeft === 0) {
                clearInterval(interval);
                resendButton.disabled = false;
            }
        }, 1000);
    }

    // Start timer on page load
    startTimer();
});


// <--Forgot Password
document.addEventListener('DOMContentLoaded', function() {
    const forgotForm = document.getElementById('forgotForm');
    const emailInput = document.getElementById('floatingInput1');
    const submitButton = document.getElementById('btn'); // Select the button

    // Function to validate form
    function validateForm() {
        if (emailInput.value === '') {
            // Don't apply invalid state if the field is empty initially
            emailInput.classList.remove('is-invalid');
            submitButton.disabled = true;
        } else if (emailInput.validity.valid) {
            submitButton.disabled = false;
            emailInput.classList.remove('is-invalid');
        } else {
            submitButton.disabled = true;
            emailInput.classList.add('is-invalid');
        }
    }

    // Event listener for input change
    emailInput.addEventListener('input', validateForm);

    // Initial validation check
    validateForm();
});






// <-- Reset Password -->
document.addEventListener('DOMContentLoaded', function() {
    const resetPwForm = document.getElementById('ResetpwForm');
    const passwordInput = document.getElementById('floatingPassword2');
    const confirmPasswordInput = document.getElementById('floatingConfirmPassword2');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const submitButton = document.getElementById('btn');

    let isPasswordTouched = false;
    let isConfirmPasswordTouched = false;

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
    function validateForm() {
        let isValid = true;

        if (isPasswordTouched) {
            // Check if password is valid
            if (passwordInput.value.trim() === '' || passwordInput.value.length < 8 || passwordInput.value.length > 32) {
                passwordInput.classList.add('is-invalid');
                isValid = false;
            } else {
                passwordInput.classList.remove('is-invalid');
            }
        }

        if (isConfirmPasswordTouched) {
            // Check if passwords match
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.classList.add('is-invalid');
                isValid = false;
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
            }
        }

        submitButton.disabled = !isValid;
        return isValid;
    }

    // Event listener for input change
    passwordInput.addEventListener('input', function() {
        isPasswordTouched = true;
        validateForm();
    });

    confirmPasswordInput.addEventListener('input', function() {
        isConfirmPasswordTouched = true;
        validateForm();
    });

    // Initial validation check (optional)
    validateForm();

    // Form submission
    resetPwForm.addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});
