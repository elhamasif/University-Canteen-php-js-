<?php
require 'dbConfig.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $role = $_POST['role'];

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)) {
        die("All fields are required.");
    }

    // Validate password confirmation
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Check if username or email already exists
    $checkStmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    if (!$checkStmt) {
        die("Database error: " . $conn->error);
    }

    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        die("Username or email already exists. Please try a different one.");
    }

    $checkStmt->close();

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Handle profile picture upload
    $targetDir2 = "userimages/";

    // Ensure the uploads directory exists
    if (!is_dir($targetDir2)) {
        if (!mkdir($targetDir2, 0777, true)) {
            die("Failed to create the userimages directory.");
        }
    }

    // Generate a unique file name for the uploaded profile picture
    $uniqueFileName = uniqid() . '_' . basename($_FILES['profile-picture']['name']);
    $profilePicturePath = $targetDir2 . $uniqueFileName;

    // Temporary file location
    $tempFile2 = $_FILES['profile-picture']['tmp_name'];

    // Validate and move the uploaded file
    if (is_uploaded_file($tempFile2)) {
        if (!move_uploaded_file($tempFile2, $profilePicturePath)) {
            die("Failed to upload profile picture.");
        }
    } else {
        die("Possible file upload attack detected.");
    }

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role, profile_picture) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Database error: " . $conn->error);
    }

    $stmt->bind_param("sssss", $username, $email, $passwordHash, $role, $profilePicturePath);

    if ($stmt->execute()) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registration Successful</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    background: linear-gradient(135deg, #4CAF50, #45a049);
                    font-family: Arial, sans-serif;
                }
                .success-popup {
                    background: white;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                    text-align: center;
                    animation: fadeIn 0.5s ease-out;
                }
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(-20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                h2 {
                    color: #4CAF50;
                    margin-bottom: 20px;
                }
                p {
                    color: #666;
                    margin-bottom: 20px;
                }
                .loading {
                    width: 50px;
                    height: 50px;
                    border: 5px solid #f3f3f3;
                    border-top: 5px solid #4CAF50;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                    margin: 20px auto;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
        </head>
        <body>
            <div class="success-popup">
                <h2>Registration Successful!</h2>
                <p>Your account has been created successfully.</p>
                <p>Redirecting to login page...</p>
                <div class="loading"></div>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 3000);
            </script>
        </body>
        </html>
        <?php
    } else {
        die("Error: " . $stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
