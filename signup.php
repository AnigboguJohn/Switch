<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <script>
        function validateField(field) {
            let isValid = true;

            const errorElement = document.getElementById(`${field}-error`);
            const successElement = document.getElementById(`${field}-success`);
            errorElement.textContent = '';
            successElement.textContent = '';

            const value = document.getElementById(field).value.trim();

            if (field === 'firstname' || field === 'lastname') {
                if (!/^[A-Z]/.test(value) || value.length < 1) {
                    errorElement.textContent = `${field.charAt(0).toUpperCase() + field.slice(1)} must start with an uppercase letter.`;
                    isValid = false;
                } else {
                    successElement.textContent = `${field.charAt(0).toUpperCase() + field.slice(1)} looks good!`;
                    document.getElementById(field).style.borderColor = 'green';
                }
            }

            if (field === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    errorElement.textContent = 'Please enter a valid email address.';
                    isValid = false;
                } else {
                    successElement.textContent = 'Email is valid!';
                    document.getElementById(field).style.borderColor = 'green';
                }
            }

            if (field === 'password') {
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                if (!passwordRegex.test(value)) {
                    errorElement.textContent = 'Password must be at least 8 characters long, contain uppercase, lowercase, numbers, and symbols.';
                    isValid = false;
                } else {
                    successElement.textContent = 'Password is strong!';
                    document.getElementById(field).style.borderColor = 'green';
                }
            }

            return isValid;
        }

        function validateForm() {
            const fields = ['firstname', 'lastname', 'email', 'password', 'confirm_password'];
            let isValid = true;
            let isEmpty = true;

            fields.forEach(field => {
                const value = document.getElementById(field).value.trim();
                if (value.length > 0) {
                    isEmpty = false;
                }
                if (field === 'confirm_password') {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirm_password').value;
                    const confirmErrorElement = document.getElementById('confirm-password-error');

                    confirmErrorElement.textContent = (password !== confirmPassword) ? 'Passwords do not match.' : '';
                    isValid = confirmPassword === password ? isValid : false;
                } else {
                    isValid = validateField(field) && isValid;
                }
            });

            const captchaResponse = document.getElementById('g-recaptcha-response').value;
            if (isEmpty) {
                showModal('Your form is empty, please fill it.');
                return false;
            } else if (captchaResponse === '') {
                showModal('Please verify that you are a human.');
                return false;
            } else if (!isValid) {
                showModal('Please fill in the form correctly.');
                return false;
            }

            // Simulating a server/network error scenario
            setTimeout(() => {
                showModal('Server error or poor network connection.');
            }, 5000); // Simulates a delay or error after form submission

            return isValid;
        }

        function showModal(message) {
            document.getElementById('modal-body').textContent = message;
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        }

        function submitForm() {
    const formData = new FormData(document.getElementById('signupForm'));

    fetch('signup_process.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        // Check if signup was successful
        if (data.includes("Signup successful!")) {
            // Redirect to OTP page
            window.location.href = "otp_verification.php"; // Adjust the path if necessary
        } else {
            showModal(data); // Show error message in modal
        }
    })
    .catch(error => {
        showModal('There was a problem with your signup: ' + error);
    });
}

    </script>
</head>
<body>
    <h2>SWITCH</h2>
    <div class="signup-container">
        <form action="process_signup.php" method="POST" onsubmit="return validateForm();">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required onblur="validateField('firstname')">
            <div class="error" id="firstname-error" style="color: red;"></div>
            <div class="success" id="firstname-success" style="color: green;"></div>

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required onblur="validateField('lastname')">
            <div class="error" id="lastname-error" style="color: red;"></div>
            <div class="success" id="lastname-success" style="color: green;"></div>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required onblur="validateField('email')">
            <div class="error" id="email-error" style="color: red;"></div>
            <div class="success" id="email-success" style="color: green;"></div>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required onblur="validateField('password')">
            <div class="error" id="password-error" style="color: red;"></div>
            <div class="success" id="password-success" style="color: green;"></div>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <div class="error" id="confirm-password-error" style="color: red;"></div>

            <label for="privacy_policy">
                <input type="checkbox" id="privacy_policy" name="privacy_policy" required>
                I agree to the <a href="privacy_policy.php" target="_blank">Privacy Policy</a>.
            </label>

            <div class="g-recaptcha" data-sitekey="6LfAlWAqAAAAAGBnVObthm9qlAov4QD8WjaLYLrY"></div>

            <button type="submit">Sign Up</button>
        </form>
    </div>

    <!-- Bootstrap Modal for Error Messages -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close close-btn-custom" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">
                    <!-- Error message will appear here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn custom-btn" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .signup-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #001f8e;
            font-weight: 800;
            font-size: 50px;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #001f8e;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #001f8e;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

        /* Modal button custom color */
        .custom-btn {
            background-color: #001f8e;
            color: white;
        }

        .custom-btn:hover {
            background-color: #0036c3;
            color: white;
        }

        /* Close button customization */
        .close-btn-custom:hover {
            background-color: #001f8e !important;
        }
    </style>
</body>
</html>
