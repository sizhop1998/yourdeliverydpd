<?php
// Only handle POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// Read fields
$first = trim($_POST['first_name'] ?? '');
$last  = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass1 = $_POST['password'] ?? '';
$pass2 = $_POST['password2'] ?? '';

// Check for empty inputs
if (!$first || !$last || !$email || !$pass1 || !$pass2) {
    die("All fields are required.");
}

// Check if passwords match
if ($pass1 !== $pass2) {
    die("Passwords do not match.");
}

// Hash the password
$hashedPassword = password_hash($pass1, PASSWORD_DEFAULT);

// File name
$file = "registrations.csv";

// Prepare data row
$row = [
    date("Y-m-d H:i:s"),
    $first,
    $last,
    $email,
    $hashedPassword
];

// Save to CSV
$fp = fopen($file, "a");
if (!$fp) {
    die("Unable to open file.");
}
fputcsv($fp, $row);
fclose($fp);

// Success message
echo "Registration successful. Thank you, $first!";
?>
