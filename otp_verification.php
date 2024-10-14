<?php
session_start();

// Simulate OTP sending during redirection after signup
$showModal = false; // Default is not showing the modal

// Example: If the user is redirected to this page after signing up
// You can set this session flag in the signup logic where OTP is sent
if (!isset($_SESSION['otp_sent'])) {
    // Simulate OTP sent action (In real scenario, this would happen after signup)
    $_SESSION['otp_sent'] = true;
    $showModal = true;
} elseif (isset($_SESSION['otp_sent']) && $_SESSION['otp_sent'] == true) {
    $showModal = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="otp-verification-container">
        <h1>OTP Verification</h1>
        <p>Enter the 6-digit code sent to your email.</p>
        <form action="" method="POST">
            <label for="otp">6-digit OTP</label>
            <input type="text" id="otp" name="otp" maxlength="6" required>

            <button type="submit">Submit</button>
        </form>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="otpSentModal" tabindex="-1" aria-labelledby="otpSentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otpSentModalLabel">OTP Sent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    An OTP has been sent to your email. Please check and enter it below to verify your account.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Trigger Modal if OTP is sent -->
    <?php if ($showModal): ?>
    <script>
        var otpSentModal = new bootstrap.Modal(document.getElementById('otpSentModal'));
        otpSentModal.show();
    </script>
    <?php endif; ?>

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        .otp-verification-container {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid skyblue;
            border-radius: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color:  #4a5e88;
            border: none;
            color: white;
            border-radius: 10px;
            cursor: pointer;
        }
    </style>

</body>
</html>
